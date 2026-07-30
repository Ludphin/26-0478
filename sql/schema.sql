-- Turbo Company - database schema
--
-- Deliberately has no CREATE DATABASE / USE line, so it imports into whatever
-- database is already selected. Shared hosts such as InfinityFree name the
-- database for you (if0_00000000_turbo) and don't grant CREATE DATABASE.
--
-- Locally:  mysql -h 127.0.0.1 -P 3307 -u root --protocol=TCP turbo_company < sql/schema.sql
--           (run sql/create_database.sql first if the database doesn't exist)
-- Hosted:   phpMyAdmin -> pick the database -> Import -> choose this file

-- Dropped child-first so the script can be re-run from scratch.
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS gallery_images;
DROP TABLE IF EXISTS videos;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS site_settings;


-- ---------------------------------------------------------------
-- Catalogue
-- ---------------------------------------------------------------

CREATE TABLE categories (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(80)  NOT NULL UNIQUE,
  slug        VARCHAR(80)  NOT NULL UNIQUE,
  description VARCHAR(255) DEFAULT NULL,
  sort_order  INT          NOT NULL DEFAULT 0,
  created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE products (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT            DEFAULT NULL,
  name        VARCHAR(120)   NOT NULL,
  material    VARCHAR(80)    DEFAULT NULL,
  -- KSh, stored to 2dp. DECIMAL, never FLOAT: money must not drift.
  price       DECIMAL(10, 2) NOT NULL,
  stock       INT            NOT NULL DEFAULT 0,
  image       VARCHAR(160)   DEFAULT NULL,
  is_active   TINYINT(1)     NOT NULL DEFAULT 1,
  sort_order  INT            NOT NULL DEFAULT 0,
  created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE SET NULL,
  INDEX idx_products_active (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE gallery_images (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT          DEFAULT NULL,
  file_path   VARCHAR(160) NOT NULL,
  alt_text    VARCHAR(160) NOT NULL,
  caption     VARCHAR(120) NOT NULL,
  sort_order  INT          NOT NULL DEFAULT 0,
  is_active   TINYINT(1)   NOT NULL DEFAULT 1,
  CONSTRAINT fk_gallery_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE videos (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  title      VARCHAR(120) NOT NULL,
  -- The YouTube ID only (e.g. dQw4w9WgXcQ); the embed URL is built in PHP.
  youtube_id VARCHAR(32)  NOT NULL,
  sort_order INT          NOT NULL DEFAULT 0,
  is_active  TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------
-- Visitor-generated data
-- ---------------------------------------------------------------

CREATE TABLE registrations (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  full_name  VARCHAR(120) NOT NULL,
  -- UNIQUE so the same person can't join the list twice; register.php
  -- turns the resulting duplicate-key error into a friendly message.
  email      VARCHAR(160) NOT NULL UNIQUE,
  phone      VARCHAR(30)  NOT NULL,
  gender     ENUM('Female', 'Male', 'Prefer not to say') NOT NULL,
  ip_address VARCHAR(45)  DEFAULT NULL,
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE contact_messages (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(120) NOT NULL,
  email      VARCHAR(160) NOT NULL,
  phone      VARCHAR(30)  DEFAULT NULL,
  message    TEXT         NOT NULL,
  is_read    TINYINT(1)   NOT NULL DEFAULT 0,
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_messages_unread (is_read, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ---------------------------------------------------------------
-- Admin + editable site content
-- ---------------------------------------------------------------

CREATE TABLE admins (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  username      VARCHAR(50)  NOT NULL UNIQUE,
  -- password_hash() output, never the password itself.
  password_hash VARCHAR(255) NOT NULL,
  full_name     VARCHAR(120) DEFAULT NULL,
  last_login_at DATETIME     DEFAULT NULL,
  created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Key/value store for the bits of copy that change often (phone, email,
-- address, tagline) so they aren't hard-coded in the markup.
CREATE TABLE site_settings (
  setting_key   VARCHAR(60)  PRIMARY KEY,
  setting_value TEXT         NOT NULL,
  label         VARCHAR(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
