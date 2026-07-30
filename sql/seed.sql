-- Turbo Company - starting data (the content the static site used to hard-code)
-- Run after schema.sql:
--   mysql -h 127.0.0.1 -P 3307 -u root --protocol=TCP < sql/seed.sql

USE turbo_company;

-- ---------------------------------------------------------------
-- Categories
-- ---------------------------------------------------------------
INSERT INTO categories (name, slug, description, sort_order) VALUES
  ('Engine Components', 'engine',     'Pistons, gaskets, belts and engine internals.', 1),
  ('Gearboxes',         'gearbox',    'Manual and automatic gearbox spares.',          2),
  ('Turbo Systems',     'turbo',      'Turbo chargers, intercoolers and pipework.',    3),
  ('Brake Systems',     'brakes',     'Brake pads, discs, callipers and fluid.',       4),
  ('Batteries',         'battery',    'Maintenance-free batteries for all models.',    5),
  ('Suspension Spares', 'suspension', 'Shocks, springs, bushes and arms.',             6);

-- ---------------------------------------------------------------
-- Price list
-- The first three rows are the ones the static price table showed.
-- ---------------------------------------------------------------
INSERT INTO products (category_id, name, material, price, stock, image, sort_order) VALUES
  ((SELECT id FROM categories WHERE slug = 'brakes'),     'Brake Pads',       'Ceramic',       3500.00, 40, 'images/brakes.jpg',     1),
  ((SELECT id FROM categories WHERE slug = 'engine'),     'Spark Plugs',      'Iridium',       1800.00, 120,'images/engine.jpg',     2),
  ((SELECT id FROM categories WHERE slug = 'engine'),     'Oil Filter',       'Standard',      2400.00, 85, 'images/engine.jpg',     3),
  ((SELECT id FROM categories WHERE slug = 'turbo'),      'Turbo Charger',    'Steel Alloy',  45000.00, 6,  'images/turbo.jpg',      4),
  ((SELECT id FROM categories WHERE slug = 'battery'),    'Car Battery 12V',  'Lead Acid',    12500.00, 25, 'images/battery.jpg',    5),
  ((SELECT id FROM categories WHERE slug = 'suspension'), 'Shock Absorber',   'Gas Filled',    8900.00, 32, 'images/suspension.jpg', 6),
  ((SELECT id FROM categories WHERE slug = 'gearbox'),    'Gearbox Oil Seal', 'Rubber',        1500.00, 60, 'images/gearbox.jpg',    7),
  ((SELECT id FROM categories WHERE slug = 'brakes'),     'Brake Disc',       'Cast Iron',     6200.00, 18, 'images/brakes.jpg',     8);

-- ---------------------------------------------------------------
-- Gallery
-- ---------------------------------------------------------------
INSERT INTO gallery_images (category_id, file_path, alt_text, caption, sort_order) VALUES
  ((SELECT id FROM categories WHERE slug = 'engine'),     'images/engine.jpg',     'Engine Components', 'Engine Components', 1),
  ((SELECT id FROM categories WHERE slug = 'gearbox'),    'images/gearbox.jpg',    'Gearbox Spares',    'Gearboxes',         2),
  ((SELECT id FROM categories WHERE slug = 'turbo'),      'images/turbo.jpg',      'Turbo Chargers',    'Turbo Systems',     3),
  ((SELECT id FROM categories WHERE slug = 'brakes'),     'images/brakes.jpg',     'Brake Systems',     'Brake Pads & Discs',4),
  ((SELECT id FROM categories WHERE slug = 'battery'),    'images/battery.jpg',    'Batteries',         'Batteries',         5),
  ((SELECT id FROM categories WHERE slug = 'suspension'), 'images/suspension.jpg', 'Suspension Parts',  'Suspension Spares', 6);

-- ---------------------------------------------------------------
-- Videos (swap youtube_id for the real clips)
-- ---------------------------------------------------------------
INSERT INTO videos (title, youtube_id, sort_order) VALUES
  ('Behind the Craft',   'dQw4w9WgXcQ', 1),
  ('New Collection Reel','dQw4w9WgXcQ', 2);

-- ---------------------------------------------------------------
-- Editable site copy
-- ---------------------------------------------------------------
INSERT INTO site_settings (setting_key, setting_value, label) VALUES
  ('company_name',  'Turbo Company', 'Company name'),
  ('tagline',       'Your Trusted Supplier of Genuine Japanese Spare Parts', 'Header tagline'),
  ('about_text',    'Turbo Company imports genuine Japanese spare parts for all major vehicle brands. We provide affordable prices, quality products, and excellent customer service.', 'About paragraph'),
  ('contact_phone', '+254 788 945 632', 'Call / WhatsApp number'),
  ('contact_email', 'turbo@gmail.com',  'Contact email'),
  ('location',      'Nairobi, Kenya',   'Location');

-- ---------------------------------------------------------------
-- Admin account
-- username: admin   password: turbo2026
-- Change it after first login (the hash below is bcrypt of turbo2026).
-- ---------------------------------------------------------------
INSERT INTO admins (username, password_hash, full_name) VALUES
  ('admin', '$2y$10$cFnXknopKoXibUFjK3JkSuB.9YFz1hAkVKp7ov3m8ade3QrlVz3U6', 'Site Administrator');
