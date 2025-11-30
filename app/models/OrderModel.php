<?php
// app/models/OrderModel.php
class OrderModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function markOrderAsPrinted($id)
    {
        $stmt = $this->pdo->prepare("UPDATE orders SET printed = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Tạo user mới và tag NFC
    private function createUser($name, $dob = null, $gender)
    {
        // 1. Tạo user
        $uuid = bin2hex(random_bytes(16)); // 32 ký tự hex
        $stmt = $this->pdo->prepare("
        INSERT INTO users (uuid, display_name, dob, gender, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");
        $stmt->execute([$uuid, $name, $dob, $gender]);
        $userId = $this->pdo->lastInsertId();

        // 2. Tạo tag NFC
        $uid = strtoupper(bin2hex(random_bytes(4))); // 8 ký tự
        $stmtTag = $this->pdo->prepare("
        INSERT INTO nfc_tags (tag_uid, owner_gender, created_at) 
        VALUES (:tag_uid, :owner_gender, NOW())
    ");
        $stmtTag->execute([
            'tag_uid' => $uid,
            'owner_gender' => $gender
        ]);
        $tagId = $this->pdo->lastInsertId();

        // 3. Return đầy đủ thông tin
        return [
            'user_id' => $userId,
            'tag_uid' => $uid,
            'tag_id' => $tagId,
            'name' => $name,   // để dùng tạo title cho couple
            'dob' => $dob,
            'gender' => $gender
        ];
    }
    private function createCouple($male, $female)
    {
        $uuid = bin2hex(random_bytes(16));
        $title = $male['name'] . ' & ' . $female['name'];
        $createdBy = $male['user_id'];

        // Insert couples
        $stmt = $this->pdo->prepare("
        INSERT INTO couples (uuid, title, created_by, created_at, updated_at)
        VALUES (?, ?, ?, NOW(), NOW())
    ");
        $stmt->execute([$uuid, $title, $createdBy]);
        $coupleId = $this->pdo->lastInsertId();

        // Insert couple_members
        $stmtMember = $this->pdo->prepare("
        INSERT INTO couple_members (couple_id, user_id, role, joined_at)
        VALUES (?, ?, 'partner', NOW())
    ");
        $stmtMember->execute([$coupleId, $male['user_id']]);
        $stmtMember->execute([$coupleId, $female['user_id']]);

        // Update NFC tags
        $stmtUpdateTag = $this->pdo->prepare("
        UPDATE nfc_tags 
        SET couple_id = :couple_id 
        WHERE tag_uid IN (:male_tag, :female_tag)
    ");
        $stmtUpdateTag->execute([
            'couple_id' => $coupleId,
            'male_tag' => $male['tag_uid'],
            'female_tag' => $female['tag_uid']
        ]);

        return $coupleId;
    }


    // Tạo order + rollback nếu lỗi
    public function createOrderTransaction($data)
    {

        try {
            // 1. Bắt đầu transaction
            $this->pdo->beginTransaction();

            // 2. Tạo user nam + tag
            $male = $this->createUser($data['male_name'], $data['male_dob'], 'male');

            // 3. Tạo user nữ + tag
            $female = $this->createUser($data['female_name'], $data['female_dob'], 'female');

            // 4. Tạo couple
            $coupleId = $this->createCouple($male, $female);

            // 5. Chuẩn bị SQL insert order
            $stmt = $this->pdo->prepare("
            INSERT INTO orders 
            (receiver_name, receiver_email, receiver_address, receiver_phone,
             male_name, male_dob, male_tag_uid, male_user_id,
             female_name, female_dob, female_tag_uid, female_user_id,
             anniversary, couple_id, printed, created_at)
            VALUES
            (:receiver_name, :receiver_email, :receiver_address, :receiver_phone,
             :male_name, :male_dob, :male_tag_uid, :male_user_id,
             :female_name, :female_dob, :female_tag_uid, :female_user_id,
             :anniversary, :couple_id, 0, NOW())
        ");

            $male_name_utf8   = mb_convert_encoding($data['male_name'], 'UTF-8', 'auto');
            $female_name_utf8 = mb_convert_encoding($data['female_name'], 'UTF-8', 'auto');

            // 6. Chuẩn bị mảng params
            $params = [
                'receiver_name' => $data['receiver_name'] ?? '',
                'receiver_email' => $data['receiver_email'] ?? '',
                'receiver_address' => $data['receiver_address'] ?? '',
                'receiver_phone' => $data['receiver_phone'] ?? '',
                'male_name' => $male_name_utf8,
                'male_dob' => $data['male_dob'] ?? null,
                'male_tag_uid' => $male['tag_uid'],
                'male_user_id' => $male['user_id'],
                'female_name' => $female_name_utf8,
                'female_dob' => $data['female_dob'] ?? null,
                'female_tag_uid' => $female['tag_uid'],
                'female_user_id' => $female['user_id'],
                'anniversary' => $data['anniversary'] ?? null,
                'couple_id' => $coupleId
            ];

            // 7. Thực hiện insert order
            if (!$stmt->execute($params)) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception('SQL execution failed: ' . implode(' | ', $errorInfo));
            }
            $orderId = $this->pdo->lastInsertId();

            // 8. Commit transaction
            $this->pdo->commit();

            return [
                'order_id' => $orderId,
                'male_tag' => $male['tag_uid'],
                'female_tag' => $female['tag_uid'],
                'couple_id' => $coupleId
            ];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            file_put_contents(DEBUG_LOG, date('Y-m-d H:i:s') . " - ROLLBACK TRANSACTION\n", FILE_APPEND);
            file_put_contents(DEBUG_LOG, date('Y-m-d H:i:s') . " - Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);
            throw $e;
        }
    }


    // admin
    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM orders WHERE id = ?");
        return $stmt->execute([$id]);
    }


    public function filter($status = '', $keyword = '', $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM orders WHERE 1";
        $params = [];

        if ($status === 'printed') {
            $sql .= " AND printed = 1";
        } elseif ($status === 'unprinted') {
            $sql .= " AND printed = 0";
        }

        if ($keyword) {
            $sql .= " AND (receiver_name LIKE :kw1 OR receiver_phone LIKE :kw2)";
            $params[':kw1'] = "%$keyword%";
            $params[':kw2'] = "%$keyword%";
        }

        // Lấy tổng số bản ghi
        $countSql = "SELECT COUNT(*) as cnt FROM ($sql) as t";
        $stmt = $this->pdo->prepare($countSql);
        $stmt->execute($params);
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];

        // Lấy dữ liệu với LIMIT trực tiếp (an toàn vì là số nguyên)
        $sql .= " ORDER BY created_at DESC LIMIT $offset, $perPage";
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['data' => $data, 'total' => $total];
    }



    public function getUnprintedTagInfo()
    {
        $sql = "
        SELECT
            t.tag_uid,
            CASE 
                WHEN t.owner_gender = 'male' THEN o.male_name
                WHEN t.owner_gender = 'female' THEN o.female_name
            END AS name,
            t.owner_gender AS gender,
            CASE 
                WHEN t.owner_gender = 'male' THEN o.male_dob
                WHEN t.owner_gender = 'female' THEN o.female_dob
            END AS birthday,
            o.anniversary,
            o.id AS order_id,
            o.printed
        FROM nfc_tags t
        JOIN orders o
            ON t.tag_uid = o.male_tag_uid
            OR t.tag_uid = o.female_tag_uid
        WHERE o.printed = 0
        ORDER BY o.created_at DESC
    ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllEmails()
    {
        $sql = "SELECT DISTINCT receiver_email, receiver_name 
            FROM orders 
            WHERE receiver_email != ''";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
