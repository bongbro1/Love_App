<?php
// app/models/CheckinModel.php
class CheckinModel
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCheckinData($coupleId)
    {
        // Lấy streak hiện tại
        $stmt = $this->db->prepare("SELECT current_streak FROM couple_streaks WHERE couple_id = ?");
        $stmt->execute([$coupleId]);
        $streak = $stmt->fetch(PDO::FETCH_ASSOC);
        return [
            'streak' => $streak['current_streak'] ?? 0
        ];
    }


    // Thêm checkin mới
    public function addLocation(int $coupleId, float $lat, float $lng, ?string $name = null): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO locations (couple_id, name, position, created_at)
            VALUES (:couple_id, :name, POINT(:lat, :lng), NOW())
        ");
        $stmt->execute([
            ':couple_id' => $coupleId,
            ':name' => $name ?? 'Vị trí không tên',
            ':lat' => $lat,
            ':lng' => $lng
        ]);

        return (int) $this->db->lastInsertId();
    }
    public function addCheckin($coupleId, $userId, $locationId = null, $lat = null, $lng = null, $method = 'manual', $note = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO checkins (couple_id, user_id, location_id, lat, lng, method, note)
            VALUES (:couple_id, :user_id, :location_id, :lat, :lng, :method, :note)
        ");
        $stmt->execute([
            'couple_id' => $coupleId,
            'user_id' => $userId,
            'location_id' => $locationId,
            'lat' => $lat,
            'lng' => $lng,
            'method' => $method,
            'note' => $note
        ]);
    }



    // Lấy streak hiện tại của couple
    public function getStreak($coupleId)
    {
        $stmt = $this->db->prepare("SELECT current_streak, best_streak, last_checkin_date FROM couple_streaks WHERE couple_id = :couple_id");
        $stmt->execute(['couple_id' => $coupleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật streak sau khi checkin
    public function updateStreak($coupleId)
    {
        $today = date('Y-m-d');
        $streakData = $this->getStreak($coupleId);

        if (!$streakData) {
            // Chưa có record -> tạo mới
            $stmt = $this->db->prepare("INSERT INTO couple_streaks (couple_id, last_checkin_date, current_streak, best_streak) VALUES (:couple_id, :date, 1, 1)");
            $stmt->execute(['couple_id' => $coupleId, 'date' => $today]);
            return ['current_streak' => 1, 'best_streak' => 1];
        }

        $lastDate = $streakData['last_checkin_date'];
        $diffDays = (strtotime($today) - strtotime($lastDate)) / 86400;

        $currentStreak = 1;
        $bestStreak = $streakData['best_streak'];

        if ($diffDays === 1) {
            $currentStreak = $streakData['current_streak'] + 1;
        } elseif ($diffDays === 0) {
            $currentStreak = $streakData['current_streak']; // đã checkin hôm nay
        } else {
            $currentStreak = 1; // reset streak
        }

        $bestStreak = max($bestStreak, $currentStreak);

        $stmt = $this->db->prepare("
            INSERT INTO couple_streaks (couple_id, last_checkin_date, current_streak, best_streak)
            VALUES (:couple_id, :date, :current_streak, :best_streak)
            ON DUPLICATE KEY UPDATE last_checkin_date = :date2, current_streak = :current_streak2, best_streak = :best_streak2
        ");

        $stmt->execute([
            'couple_id' => $coupleId,
            'date' => $today,
            'current_streak' => $currentStreak,
            'best_streak' => $bestStreak,
            'date2' => $today,
            'current_streak2' => $currentStreak,
            'best_streak2' => $bestStreak
        ]);

        return ['current_streak' => $currentStreak, 'best_streak' => $bestStreak];
    }

    public function getLastCheckin($coupleId)
    {
        $stmt = $this->db->prepare("
            SELECT location_id, lat, lng, created_at
            FROM checkins
            WHERE couple_id = :couple_id
            ORDER BY created_at DESC
            LIMIT 1
        ");
        $stmt->execute(['couple_id' => $coupleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
