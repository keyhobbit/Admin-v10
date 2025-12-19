-- Create test database
CREATE DATABASE IF NOT EXISTS test_game_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON test_game_cms.* TO 'game_user'@'%';
FLUSH PRIVILEGES;
