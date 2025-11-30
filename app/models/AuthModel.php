<?php
class AuthModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUserById($userId)
    {
        $sql = "SELECT id, password_hash FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    public function getUsersByTags($tagUids)
    {
        // $tagUids là mảng [tag1, tag2]
        $in  = str_repeat('?,', count($tagUids) - 1) . '?';
        $sql = "
            SELECT DISTINCT u.*
            FROM nfc_tags t
            JOIN couples c ON t.couple_id = c.id
            JOIN couple_members m ON m.couple_id = c.id
            JOIN users u ON u.id = m.user_id
            WHERE t.tag_uid IN ($in)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($tagUids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setPassword($userId, $password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$hash, $userId]);
    }


    public function verifyPassword($userId, $password)
    {
        $user = $this->getUserById($userId);
        if (!$user) return false;

        return password_verify($password, $user['password_hash']);
    }
}
