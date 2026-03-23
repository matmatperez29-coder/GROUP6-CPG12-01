-- ============================================
-- Run this in phpMyAdmin → urbanpulse_db → SQL
-- ============================================

-- Step 1: Add 'admin' to the role column
ALTER TABLE users 
MODIFY COLUMN role ENUM('reader','author','admin') DEFAULT 'reader';

-- Step 2: Create article submissions table
CREATE TABLE IF NOT EXISTS article_submissions (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  author_id    INT NOT NULL,
  title        VARCHAR(255) NOT NULL,
  category     ENUM('technology','sports','entertainment','worldnews') NOT NULL,
  summary      TEXT NOT NULL,
  body         LONGTEXT NOT NULL,
  image_url    VARCHAR(500) DEFAULT '',
  status       ENUM('pending','approved','declined') DEFAULT 'pending',
  decline_reason TEXT DEFAULT NULL,
  submitted_at DATETIME DEFAULT NOW(),
  reviewed_at  DATETIME DEFAULT NULL,
  reviewed_by  INT DEFAULT NULL,
  FOREIGN KEY (author_id)  REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Step 3: Make yourself an admin (replace 'your_username' with your actual username)
UPDATE users SET role = 'admin' WHERE username = 'admin';

-- Step 4: Add an example author account for testing
-- (skip if you already have test accounts)
INSERT IGNORE INTO users (username, email, password, name, role, avatar_color) VALUES
('author1', 'author1@urbanpulse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sample Author', 'author', '#0066cc');
-- Default password for author1: password
