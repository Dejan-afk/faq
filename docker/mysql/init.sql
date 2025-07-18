CREATE DATABASE IF NOT EXISTS faq_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS faq_app_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'faq_user'@'%' IDENTIFIED BY 'neo';

GRANT ALL PRIVILEGES ON faq_app.* TO 'faq_user'@'%';
GRANT ALL PRIVILEGES ON faq_app_testing.* TO 'faq_user'@'%';

FLUSH PRIVILEGES;
