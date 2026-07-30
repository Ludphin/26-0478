# Turbo Company — MySQL + PHP

The site now reads its content from a MySQL database instead of hard-coded HTML,
and the registration and contact forms save real rows.

## Setup

1. Create the database and load the starting content:

   ```bash
   mysql -h 127.0.0.1 -P 3307 -u root --protocol=TCP < sql/schema.sql
   mysql -h 127.0.0.1 -P 3307 -u root --protocol=TCP < sql/seed.sql
   ```

   (Under a stock XAMPP install the port is usually `3306` — adjust the command
   and `includes/db.php` to match.)

2. Check the credentials at the top of `includes/db.php` — `$host`, `$port`,
   `$dbname`, `$user`, `$pass`.

3. Serve the folder:

   ```bash
   php -S 127.0.0.1:8000        # from this directory
   ```

   or copy/symlink it into `htdocs` and browse to `http://localhost/26-0478/`.

4. Open `http://127.0.0.1:8000/index.php`.
   Admin area: `/admin/login.php` — **admin / turbo2026** (change this).

## Files

| File | Purpose |
| --- | --- |
| `sql/schema.sql` | Table definitions — re-runnable, drops and recreates |
| `sql/seed.sql` | Categories, products, gallery, videos, site copy, admin user |
| `includes/db.php` | PDO connection |
| `includes/helpers.php` | Session, CSRF, escaping, flash messages |
| `includes/queries.php` | Read queries for the public pages |
| `index.php` | Home page, rendered from the database |
| `register.php` | Validates and saves the registration form |
| `contact.php` | Validates and saves the contact form |
| `admin/login.php` `admin/logout.php` `admin/auth.php` | Admin authentication |
| `admin/index.php` | Dashboard: registrations, messages, catalogue |

## Tables

| Table | Holds |
| --- | --- |
| `categories` | Part categories (engine, gearbox, turbo, brakes, battery, suspension) |
| `products` | Price list — name, material, price, stock, image, category |
| `gallery_images` | Gallery tiles — file path, alt text, caption |
| `videos` | YouTube IDs for the video section |
| `registrations` | Visitors who signed up (email is `UNIQUE`) |
| `contact_messages` | Messages from the contact form, with a read flag |
| `admins` | Admin logins — bcrypt hashes only, never plain passwords |
| `site_settings` | Editable copy: phone, email, location, tagline, about text |

## Notes on how it's written

- All SQL goes through **prepared statements** (`PDO`, `ATTR_EMULATE_PREPARES => false`),
  so user input can't be injected.
- Every value printed into the page goes through `e()` (`htmlspecialchars`),
  so a `<script>` typed into a form is displayed as text, not run.
- Both forms carry a **CSRF token** checked before anything is written.
- Admin passwords are stored with `password_hash()` and checked with
  `password_verify()`.
- Prices are `DECIMAL(10,2)`, not `FLOAT`, so money doesn't drift.

## Changing content

Edit rows in MySQL (phpMyAdmin or the CLI) and the site updates immediately —
add a product to `products`, a photo to `gallery_images`, or change the phone
number in `site_settings`.

To change the admin password:

```bash
php -r 'echo password_hash("your-new-password", PASSWORD_DEFAULT), "\n";'
```

then `UPDATE admins SET password_hash = '<the hash>' WHERE username = 'admin';`
