<?php
class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    // ✅ Lấy thông tin 1 user
    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Cập nhật mật khẩu
    public function updatePassword($id, $newPassword)
    {
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }

    // ✅ Lấy thông tin partner (người yêu)
    public function getPartnerByUser($userId)
    {
        $sql = "
        SELECT 
            u.*, 
            cm.couple_id, 
            cm.role, 
            cm.joined_at, 
            cm.last_seen_at,
            c.total_score
        FROM couple_members cm1
        JOIN couple_members cm
            ON cm1.couple_id = cm.couple_id AND cm1.user_id != cm.user_id
        JOIN users u
            ON u.id = cm.user_id
        JOIN couples c
            ON c.id = cm.couple_id
        WHERE cm1.user_id = ?
        LIMIT 1
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Cập nhật thông tin cá nhân
    public function updateProfile($id, $data)
    {
        // Tạo mảng fields và values để update linh hoạt
        $fields = [];
        $values = [];

        if (isset($data['display_name'])) {
            $fields[] = 'display_name = ?';
            $values[] = $data['display_name'];
        }
        if (isset($data['email'])) {
            $fields[] = 'email = ?';
            $values[] = $data['email'];
        }

        if (isset($data['dob'])) {
            $fields[] = 'dob = ?';
            $values[] = $data['dob'];
        }

        if (isset($data['gender'])) {
            $fields[] = 'gender = ?';
            $values[] = $data['gender'];
        }

        if (!empty($data['avatar_url'])) {
            $fields[] = 'avatar_url = ?';
            $values[] = $data['avatar_url'];
        }
        // Không có trường nào để update
        if (empty($fields)) {
            return false;
        }

        $values[] = $id; // id cho WHERE
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }
}
