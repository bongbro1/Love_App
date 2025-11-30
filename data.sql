-- USERS
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid VARCHAR(36) NOT NULL UNIQUE,            -- uuid ứng dụng
  email VARCHAR(255),
  password_hash VARCHAR(255),
  display_name VARCHAR(100),
  dob DATE,                                    -- ngày sinh
  gender ENUM('male','female','other') DEFAULT 'other',  -- giới tính
  avatar_url VARCHAR(500),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX(email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- COUPLES (một record = một cặp đôi)
CREATE TABLE couples (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uuid VARCHAR(36) NOT NULL UNIQUE,
  title VARCHAR(255),       -- tên cặp đôi (optional)
  total_score INT DEFAULT 0,
  created_by BIGINT UNSIGNED, -- user id khởi tạo
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- COUPLE MEMBERS (liên kết user <-> couple)
CREATE TABLE couple_members (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  role ENUM('partner','admin') DEFAULT 'partner',
  joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_seen_at TIMESTAMP NULL,
  UNIQUE KEY (couple_id, user_id),
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- LOCATIONS (địa điểm có thể gắn NFC/QR)
CREATE TABLE locations (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NULL, -- nếu location riêng cho cặp đôi
  name VARCHAR(255),
  address VARCHAR(500),
  position POINT NOT NULL, -- <== dùng POINT thay cho lat/lng
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE SET NULL,
  SPATIAL INDEX(position) -- <== tạo chỉ mục không gian đúng cách
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- CHECKINS (mỗi lần quét NFC/QR để ghi kỷ niệm)
CREATE TABLE checkins (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,       -- người quét (có thể lưu cả 2 nếu 2 người đều quét)
  location_id BIGINT UNSIGNED NULL,
  lat DECIMAL(9,6) NULL,
  lng DECIMAL(9,6) NULL,
  method ENUM('nfc','qr','manual') DEFAULT 'manual',
  note TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE SET NULL,
  INDEX (couple_id, created_at),
  INDEX (user_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- COUPLE_STREAKS (cache trạng thái streak cho tối ưu)
CREATE TABLE couple_streaks (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL UNIQUE,
  last_checkin_date DATE NULL,     -- ngày cuối cùng có checkin
  current_streak INT UNSIGNED DEFAULT 0,
  best_streak INT UNSIGNED DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- MEMORIES (album)
CREATE TABLE memories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255),
  description TEXT,
  event_date DATE NULL, -- mốc thời gian
  created_by BIGINT UNSIGNED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- MEMORY PHOTOS / MEDIA
CREATE TABLE memory_photos (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  memory_id BIGINT UNSIGNED NOT NULL,
  uploaded_by BIGINT UNSIGNED,
  media_url VARCHAR(1000) NOT NULL,
  thumb_url VARCHAR(1000) NULL,
  caption TEXT,
  taken_at TIMESTAMP NULL,
  location_id BIGINT UNSIGNED NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (memory_id) REFERENCES memories(id) ON DELETE CASCADE,
  FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- LOVE MAP (dùng để hiển thị các điểm trên bản đồ)
CREATE TABLE love_map_points (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  position POINT NOT NULL, -- Dùng POINT thay cho lat/lng
  label VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  INDEX (couple_id),
  SPATIAL INDEX (position)  -- Đúng cú pháp
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- CHALLENGE TEMPLATES
CREATE TABLE challenges (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  description TEXT,
  points INT DEFAULT 0,      -- love score reward
  is_offline TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE challenge_tasks (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  challenge_id BIGINT UNSIGNED NOT NULL,
  seq INT NOT NULL DEFAULT 0,
  text VARCHAR(500),
  requirement JSON NULL, -- mở rộng (ví dụ: photo_count, location_required)
  FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- CHALLENGE INSTANCES (khi couple bắt 1 challenge)
CREATE TABLE challenge_instances (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  challenge_id BIGINT UNSIGNED NOT NULL,
  started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  completed_at TIMESTAMP NULL,
  status ENUM('active','completed','failed') DEFAULT 'active',
  created_by BIGINT UNSIGNED,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE challenge_participants (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  instance_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  completed_tasks JSON NULL, -- store task statuses
  score_awarded INT DEFAULT 0,
  FOREIGN KEY (instance_id) REFERENCES challenge_instances(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- LOVE SCORE LOG (ghi từng thay đổi)
CREATE TABLE love_score_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  changed_by BIGINT UNSIGNED NULL,
  delta INT NOT NULL,
  reason VARCHAR(255),
  meta JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (changed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- MINI GAMES (cơ bản)
CREATE TABLE mini_games (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(100) UNIQUE,
  title VARCHAR(255),
  config JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE game_sessions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  game_id BIGINT UNSIGNED NOT NULL,
  couple_id BIGINT UNSIGNED NOT NULL,
  host_user_id BIGINT UNSIGNED,
  started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  ended_at TIMESTAMP NULL,
  result JSON NULL,
  FOREIGN KEY (game_id) REFERENCES mini_games(id),
  FOREIGN KEY (couple_id) REFERENCES couples(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- MESSAGES + ATTACHMENTS (chat)
CREATE TABLE messages (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  sender_id BIGINT UNSIGNED NOT NULL,
  body TEXT,
  message_type ENUM('text','image','voice','video','system') DEFAULT 'text',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  delivered_at TIMESTAMP NULL,
  read_at TIMESTAMP NULL,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX (couple_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE attachments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  message_id BIGINT UNSIGNED NOT NULL,
  url VARCHAR(1000) NOT NULL,
  mime VARCHAR(100),
  size BIGINT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SECRET LETTERS
CREATE TABLE secret_letters (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  sender_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255),
  body TEXT,
  attachments JSON NULL,
  unlock_at DATETIME NULL,   -- thời điểm mở
  is_opened TINYINT(1) DEFAULT 0,
  opened_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- HEARTBEAT SIGNAL (ghi log)
CREATE TABLE heartbeat_signals (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  sender_id BIGINT UNSIGNED NOT NULL,
  note VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- MOOD TRACKER
CREATE TABLE mood_entries (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  mood ENUM('very_happy','happy','neutral','sad','very_sad') DEFAULT 'neutral',
  mood_score TINYINT, -- optional numeric
  note TEXT,
  created_at DATE DEFAULT (CURRENT_DATE),
  created_at_ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY (couple_id, user_id, created_at) -- 1 mood / day
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- LOVE DIARIES
CREATE TABLE love_diaries (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  author_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255),
  content TEXT,
  visibility ENUM('both','private_to_author') DEFAULT 'both',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE push_subscriptions (
    user_id INT PRIMARY KEY,
    subscription TEXT NOT NULL
);

CREATE TABLE nfc_tags (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tag_uid VARCHAR(128) NOT NULL UNIQUE,   -- UID đọc được từ thẻ NFC
  couple_id BIGINT UNSIGNED NULL,         -- cặp đôi sở hữu thẻ
  owner_gender ENUM('male','female') NULL,
  assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- thời gian tạo bản ghi
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE nfc_scan_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tag_uid VARCHAR(128) NOT NULL,
  couple_id BIGINT UNSIGNED NULL,
  scanned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  location VARCHAR(255) NULL,
  location_name VARCHAR(255) NULL,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


SET FOREIGN_KEY_CHECKS = 0;

-- 1. MESSAGES (Chat / Hộp thư tình realtime)
CREATE TABLE messages (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  sender_id BIGINT UNSIGNED NOT NULL,
  body TEXT,
  message_type ENUM('text','image','voice','video','system') DEFAULT 'text',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  delivered_at TIMESTAMP NULL,
  read_at TIMESTAMP NULL,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX (couple_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. SECRET LETTERS (Thư bí mật hẹn ngày mở)
CREATE TABLE secret_letters (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  sender_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255),
  body TEXT,
  attachments JSON NULL,
  unlock_at DATETIME NULL,   -- thời điểm mở thư
  is_opened TINYINT(1) DEFAULT 0,
  opened_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. HEARTBEAT SIGNALS ("Nhớ em/anh" signal)
CREATE TABLE heartbeat_signals (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  sender_id BIGINT UNSIGNED NOT NULL,
  note VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. MOOD ENTRIES (Theo dõi cảm xúc hàng ngày)
CREATE TABLE mood_entries (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  mood ENUM('very_happy','happy','neutral','sad','very_sad') DEFAULT 'neutral',
  mood_score TINYINT, -- optional numeric
  note TEXT,
  created_at DATE DEFAULT (CURRENT_DATE),
  created_at_ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY (couple_id, user_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. LOVE DIARIES (Nhật ký tình yêu)
CREATE TABLE love_diaries (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  author_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255),
  content TEXT,
  visibility ENUM('both','private_to_author') DEFAULT 'both',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. ANNIVERSARIES (Kỷ niệm & nhắc nhở)
CREATE TABLE anniversaries (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  couple_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255),
  date DATE NOT NULL,
  is_recurring TINYINT(1) DEFAULT 1,
  reminder_days_before INT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (couple_id) REFERENCES couples(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. NOTIFICATIONS (Thông báo đẩy / in-app)
CREATE TABLE notifications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  couple_id BIGINT UNSIGNED NULL,
  type VARCHAR(100),
  payload JSON,
  is_read TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. GAME SESSIONS (Phiên chơi mini game)
CREATE TABLE game_sessions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  game_id BIGINT UNSIGNED NOT NULL,
  couple_id BIGINT UNSIGNED NOT NULL,
  host_user_id BIGINT UNSIGNED,
  started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  ended_at TIMESTAMP NULL,
  result JSON NULL,
  FOREIGN KEY (game_id) REFERENCES mini_games(id),
  FOREIGN KEY (couple_id) REFERENCES couples(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  
  -- Thông tin người nhận hàng
  receiver_name VARCHAR(255) NOT NULL,
  receiver_email VARCHAR(255),
  receiver_address VARCHAR(500),
  receiver_phone VARCHAR(20),
  
  -- Thông tin thẻ Nam
  male_name VARCHAR(255) NOT NULL,
  male_dob DATE,
  male_tag_uid VARCHAR(20),     -- liên kết với nfc_tags, cập nhật khi in
  male_user_id BIGINT UNSIGNED, -- liên kết với bảng users
  
  -- Thông tin thẻ Nữ
  female_name VARCHAR(255) NOT NULL,
  female_dob DATE,
  female_tag_uid VARCHAR(20),     -- liên kết với nfc_tags, cập nhật khi in
  female_user_id BIGINT UNSIGNED, -- liên kết với bảng users
  
  -- Thông tin chung
  anniversary DATE,
  couple_id BIGINT UNSIGNED, -- liên kết với bảng couples
  printed TINYINT(1) DEFAULT 0, -- 0: chưa in, 1: đã in
  
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,            -- Ví dụ: Yêu Xa, Công Nghệ, Kỷ Niệm
    slug VARCHAR(100) NOT NULL UNIQUE,     -- Dùng cho URL SEO: yeu-xa, cong-nghe,...
    color VARCHAR(30) DEFAULT 'pink',      -- Màu chủ đề: pink, purple, rose,...
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,               -- Tiêu đề bài viết
    slug VARCHAR(255) NOT NULL UNIQUE,         -- Dùng cho đường dẫn SEO: /bai-viet/yeu-xa-van-hanh-phuc
    excerpt TEXT,                              -- Đoạn mô tả ngắn (giống trong $posts)
    content LONGTEXT,                          -- Nội dung chi tiết bài viết (HTML)
    thumbnail VARCHAR(255),                    -- Đường dẫn ảnh bìa (img)
    read_time VARCHAR(50) DEFAULT '3 phút đọc',-- Thời gian đọc
    post_date DATE,                            -- Ngày đăng
    category_id INT,                           -- Liên kết với bảng categories
    meta_title VARCHAR(255),                   -- Dùng cho SEO <title>
    meta_description VARCHAR(255),             -- Mô tả SEO
    meta_keywords VARCHAR(255),                -- Từ khóa SEO
    status ENUM('draft','published') DEFAULT 'published',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE seo_config (
    id INT PRIMARY KEY AUTO_INCREMENT,
    meta_title VARCHAR(255) DEFAULT NULL,
    meta_description TEXT DEFAULT NULL,
    keywords VARCHAR(255) DEFAULT NULL,
    og_image VARCHAR(255) DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO seo_config (id) VALUES (1);

CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    site_name VARCHAR(255) DEFAULT NULL,
    contact_email VARCHAR(255) DEFAULT NULL,
    hotline VARCHAR(50) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO settings (id) VALUES (1);






SELECT 
    table_name AS child_table,
    column_name AS fk_column,
    referenced_table_name AS parent_table,
    referenced_column_name AS parent_column
FROM information_schema.key_column_usage
WHERE table_schema = 'love-app'
  AND referenced_table_name IS NOT NULL;






SET FOREIGN_KEY_CHECKS = 1;



-- 1️⃣ Tắt kiểm tra FK
SET FOREIGN_KEY_CHECKS = 0;

-- 2️⃣ Xóa dữ liệu bảng con trước
TRUNCATE TABLE attachments;
TRUNCATE TABLE challenge_participants;
TRUNCATE TABLE challenge_tasks;
TRUNCATE TABLE checkins;
TRUNCATE TABLE couple_members;
TRUNCATE TABLE game_sessions;
TRUNCATE TABLE heartbeat_signals;
TRUNCATE TABLE love_diaries;
TRUNCATE TABLE love_map_points;
TRUNCATE TABLE love_score_logs;
TRUNCATE TABLE memory_photos;
TRUNCATE TABLE messages;
TRUNCATE TABLE mood_entries;
TRUNCATE TABLE nfc_scan_logs;
TRUNCATE TABLE nfc_tags;
TRUNCATE TABLE notifications;
TRUNCATE TABLE secret_letters;
TRUNCATE TABLE anniversaries;
TRUNCATE TABLE couple_streaks;

-- 3️⃣ Xóa dữ liệu bảng cha sau
TRUNCATE TABLE challenges;
TRUNCATE TABLE locations;
TRUNCATE TABLE mini_games;
TRUNCATE TABLE memories;
TRUNCATE TABLE couples;
TRUNCATE TABLE users;

-- 4️⃣ Bật lại kiểm tra FK
SET FOREIGN_KEY_CHECKS = 1;



-- lấy file excel order
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
    o.anniversary
FROM nfc_tags t
JOIN orders o
    ON t.tag_uid = o.male_tag_uid
    OR t.tag_uid = o.female_tag_uid;
