<?php
// app/models/NFCModel.php

class NFCModel
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }
  public function getPdo()
  {
    return $this->pdo;
  }

  /**
   * Lấy thông tin tag theo UID
   */
  public function getTagByUid($tagUid)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM nfc_tags WHERE tag_uid = :tag_uid");
    $stmt->execute(['tag_uid' => $tagUid]);
    $tag = $stmt->fetch(PDO::FETCH_ASSOC);
    return $tag ?: null;
  }

  /**
   * Lấy couple_id từ tag UID
   */
  public function getCoupleIdByTag($tagUid)
  {
    $tag = $this->getTagByUid($tagUid);
    return $tag['couple_id'] ?? null;
  }

  /**
   * Log scan NFC
   */
  public function logScan($tagUid, $location = null, $location_name = null)
  {
    $coupleId = $this->getCoupleIdByTag($tagUid);

    $stmt = $this->pdo->prepare("
        INSERT INTO nfc_scan_logs (tag_uid, couple_id, location, location_name, scanned_at)
        VALUES (:tag_uid, :couple_id, :location, :location_name, NOW())
    ");

    return $stmt->execute([
      'tag_uid' => $tagUid,
      'couple_id' => $coupleId,
      'location' => $location,
      'location_name' => $location_name
    ]);
  }

  /**
   * Tìm user liên kết với tag
   */
  public function findUserByTag($tagUid)
  {
    $tag = $this->getTagByUid($tagUid);
    if (!$tag || empty($tag['couple_id'])) return null;

    $sql = "SELECT u.*
            FROM users u
            JOIN couple_members cm ON cm.user_id = u.id
            WHERE cm.couple_id = :couple_id";

    if (!empty($tag['owner_gender'])) {
      $sql .= " AND u.gender = :gender";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([
        'couple_id' => $tag['couple_id'],
        'gender' => $tag['owner_gender']
      ]);
    } else {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['couple_id' => $tag['couple_id']]);
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
  }
  /**
   * Debug helper
   */
  public function debug($message)
  {
    $logFile = __DIR__ . '/debug_nfc.log';
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
  }
}
