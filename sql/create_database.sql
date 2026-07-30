-- Local development only.
--
-- On shared hosting you don't need this: the control panel creates the
-- database for you and picks its name.
--
--   mysql -h 127.0.0.1 -P 3307 -u root --protocol=TCP < sql/create_database.sql

CREATE DATABASE IF NOT EXISTS turbo_company
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
