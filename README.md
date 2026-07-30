# Turbo Company — MySQL + PHP

The site now reads its content from a MySQL database instead of hard-coded HTML,
and the registration and contact forms save real rows.

## Setup (local, XAMPP)

1. Create the database and load the starting content:

   ```bash
   mysql -h 127.0.0.1 -P 3307 -u root --protocol=TCP < sql/create_database.sql
   mysql -h 127.0.0.1 -P 3307 -u root --protocol=TCP turbo_company < sql/schema.sql
   mysql -h 127.0.0.1 -P 3307 -u root --protocol=TCP turbo_company < sql/seed.sql
   ```

   (Under a stock XAMPP install the port is usually `3306` — adjust the command
   and `includes/config.php` to match.)

2. Check the credentials in the **local** half of `includes/config.php`.

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
| `sql/create_database.sql` | Creates the local database (not needed on shared hosting) |
| `sql/schema.sql` | Table definitions — re-runnable, drops and recreates |
| `sql/seed.sql` | Categories, products, gallery, videos, site copy, admin user |
| `includes/config.php` | Database credentials, local and live |
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

## Publishing on InfinityFree

InfinityFree runs PHP 8.3 and MySQL, which is all this site needs. Two of its
rules shape the steps below:

- **It names your database for you.** You get `if0_<account>_<name>` and no
  permission to run `CREATE DATABASE`. That is why `sql/schema.sql` has no
  `CREATE DATABASE`/`USE` line — it imports into whichever database you have
  selected.
- **Free accounts can't reach MySQL from outside the hosting server.** Your
  laptop, Workbench and DBeaver will all be refused, so imports and edits go
  through their phpMyAdmin.

### 1. Create the account and the database

1. Sign up at <https://www.infinityfree.com/> and create a hosting account,
   choosing a free subdomain (e.g. `turbocompany.rf.gd`). Give DNS a few
   minutes to come up.
2. Control Panel → **MySQL Databases** → create a database called `turbo`.
   Note the four values it shows you:

   | Setting | Looks like |
   | --- | --- |
   | Host | `sql301.infinityfree.com` |
   | Database | `if0_00000000_turbo` |
   | Username | `if0_00000000` |
   | Password | your control-panel account password |

   If the password is ever refused, reset it from the **Client Area**, not the
   Control Panel.

### 2. Load the tables

Control Panel → **phpMyAdmin** → select `if0_00000000_turbo` → **Import**:

1. Import `sql/schema.sql`.
2. Import `sql/seed.sql`.

### 3. Upload the site

Upload the contents of this folder into **`htdocs/`** — via the File Manager,
or FTP to `ftpupload.net` (port 21) with the FTP details from the Control Panel.

- Upload `index.php`, `register.php`, `contact.php`, `style.css`, `script.js`,
  `.htaccess`, and the `images/`, `includes/` and `admin/` folders.
- **Don't upload `sql/`.** It is only needed for the import, and `seed.sql`
  contains the admin password hash.
- Make sure your FTP client is showing hidden files, or it will silently skip
  the `.htaccess` files.

### 4. Fill in the credentials

Edit `includes/config.php` **on the server** and put the four values from step 1
into the `else` branch. Leave the local half alone — the file picks a branch
based on the hostname, so the same file keeps working on XAMPP.

Don't commit the live password back to GitHub; this repository is public.

### 5. Lock it down

1. Log in at `/admin/login.php` with **admin / turbo2026** and change the
   password immediately (see below) — the default is in the public repo.
2. Control Panel → **Free SSL Certificate** → issue and install one, so the
   admin login isn't sent over plain HTTP.

### Known limits

- `mail()` is disabled on the free plan. Nothing here sends email; contact form
  messages are read in the admin dashboard instead.
- There are hourly limits on queries and CPU. Fine for a portfolio site.
- InfinityFree shows a JavaScript check to non-browser traffic, so `curl` and
  uptime robots may see a challenge page rather than the site.

## Changing content

Edit rows in MySQL (phpMyAdmin or the CLI) and the site updates immediately —
add a product to `products`, a photo to `gallery_images`, or change the phone
number in `site_settings`.

To change the admin password:

```bash
php -r 'echo password_hash("your-new-password", PASSWORD_DEFAULT), "\n";'
```

then `UPDATE admins SET password_hash = '<the hash>' WHERE username = 'admin';`
