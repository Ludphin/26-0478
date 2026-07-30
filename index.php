<?php
// Public home page. Everything below the header comes out of MySQL.

require __DIR__ . "/includes/helpers.php";
require __DIR__ . "/includes/db.php";
require __DIR__ . "/includes/queries.php";

$settings = get_settings($pdo);
$gallery  = get_gallery_images($pdo);
$products = get_products($pdo);
$videos   = get_videos($pdo);

$registerFlash = take_flash("register");
$contactFlash  = take_flash("contact");

// Re-fill the forms after a rejected submission.
$regOld = $_SESSION["register_old"] ?? [];
$conOld = $_SESSION["contact_old"] ?? [];
unset($_SESSION["register_old"], $_SESSION["contact_old"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($settings["company_name"] ?? "Turbo Company") ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- NAVIGATION BAR -->
    <header>
        <div class="logo-area">
            <h1>🚗 <?= e($settings["company_name"] ?? "Turbo Company") ?></h1>
            <p><?= e($settings["tagline"] ?? "") ?></p>
        </div>
        <nav>
            <a href="#about">About</a>
            <a href="#products">Products</a>
            <a href="#prices">Prices</a>
            <a href="#gallery">Gallery</a>
            <a href="#video">Video</a>
            <a href="#register">Register</a>
            <a href="#contact">Contact</a>
            <a href="admin/login.php">Admin</a>
        </nav>
    </header>

    <!-- MAIN CONTENT SECTIONS -->
    <main>

        <!-- ABOUT SECTION -->
        <section id="about" class="feature-card" style="max-width: 900px; margin: 40px auto; text-align: center;">
            <h2>About <?= e($settings["company_name"] ?? "Turbo Company") ?></h2>
            <p><?= e($settings["about_text"] ?? "") ?></p>
        </section>

        <!-- WHY CHOOSE US / PRODUCTS SECTION -->
        <section id="products">
            <h2>Why Choose Us?</h2>
            <div class="features-container">
                <div class="feature-card">
                    <h3>✅ Genuine Parts</h3>
                    <p>Original Japanese spare parts.</p>
                </div>
                <div class="feature-card">
                    <h3>🚚 Fast Delivery</h3>
                    <p>Delivery across Kenya.</p>
                </div>
                <div class="feature-card">
                    <h3>💰 Affordable Prices</h3>
                    <p>Competitive prices for every customer.</p>
                </div>
            </div>
        </section>

        <!-- GALLERY SECTION (rows from gallery_images) -->
        <section id="gallery">
            <h2>Gallery</h2>
            <div class="image-grid">
                <?php foreach ($gallery as $image): ?>
                <div class="image-card">
                    <img src="<?= e($image["file_path"]) ?>" alt="<?= e($image["alt_text"]) ?>">
                    <p><?= e($image["caption"]) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- VIDEO SECTION (rows from videos) -->
        <section id="video" style="text-align: center; margin: 40px 0;">
            <h2>Behind the Craft &amp; Collection Reels</h2>
            <div class="features-container">
                <?php foreach ($videos as $video): ?>
                <div class="feature-card" style="min-width: 320px; padding: 15px;">
                    <h3><?= e($video["title"]) ?></h3>
                    <div class="video-wrapper">
                        <iframe src="https://www.youtube.com/embed/<?= e(rawurlencode($video["youtube_id"])) ?>"
                                title="<?= e($video["title"]) ?>" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- PRICES SECTION (rows from products) -->
        <section id="prices" style="max-width: 800px; margin: 0 auto; padding: 20px;">
            <h2>Price List</h2>
            <div class="feature-card" style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--text-plum); color: var(--text-plum); font-weight: bold;">
                            <th style="padding: 10px;">Item</th>
                            <th style="padding: 10px;">Category</th>
                            <th style="padding: 10px;">Material</th>
                            <th style="padding: 10px;">Price (KSh)</th>
                            <th style="padding: 10px;">Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <td style="padding: 10px;"><?= e($product["name"]) ?></td>
                            <td style="padding: 10px;"><?= e($product["category_name"] ?? "-") ?></td>
                            <td style="padding: 10px;"><?= e($product["material"] ?? "-") ?></td>
                            <td style="padding: 10px;"><?= ksh($product["price"]) ?></td>
                            <td style="padding: 10px;">
                                <?= (int) $product["stock"] > 0 ? "In stock (" . (int) $product["stock"] . ")" : "Out of stock" ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- REGISTER FORM SECTION -->
        <section id="register" style="max-width: 500px; margin: 40px auto; padding: 20px;">
            <form action="register.php" method="post">
                <h2>Join the family and unlock exclusive deals! ✨</h2>

                <?php if ($registerFlash): ?>
                <p class="flash flash-<?= e($registerFlash["type"]) ?>"><?= e($registerFlash["message"]) ?></p>
                <?php endif; ?>

                <?= csrf_field() ?>

                <label style="display: block; margin-top: 10px; font-weight: 600;">Full Name *</label>
                <input type="text" name="full_name" placeholder="e.g. ludphin wainaina" required
                       value="<?= e($regOld["fullName"] ?? "") ?>"
                       style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">

                <label style="display: block; margin-top: 15px; font-weight: 600;">Email Address *</label>
                <input type="email" name="email" placeholder="e.g. turbo@gmail.com" required
                       value="<?= e($regOld["email"] ?? "") ?>"
                       style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">

                <label style="display: block; margin-top: 15px; font-weight: 600;">Phone Number *</label>
                <input type="tel" name="phone" placeholder="e.g. 0788 945 632" required
                       value="<?= e($regOld["phone"] ?? "") ?>"
                       style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">

                <label style="display: block; margin-top: 15px; font-weight: 600;">Gender *</label>
                <select name="gender" required
                        style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">
                    <option value="">Select...</option>
                    <?php foreach (["Female", "Male", "Prefer not to say"] as $option): ?>
                    <option value="<?= e($option) ?>" <?= ($regOld["gender"] ?? "") === $option ? "selected" : "" ?>>
                        <?= e($option) ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" style="width: 100%; background: var(--plum-header); color: white; border: none; padding: 12px; margin-top: 20px; border-radius: 25px; font-weight: bold; cursor: pointer;">Register</button>
            </form>
        </section>

        <!-- CONTACT SECTION -->
        <section id="contact" style="max-width: 600px; margin: 40px auto; text-align: center;">
            <h2>Contact Us</h2>
            <div class="feature-card" style="margin-bottom: 15px;">
                <p>📞 <strong>Call / WhatsApp:</strong></p>
                <p>
                    <a href="tel:<?= e(str_replace(" ", "", $settings["contact_phone"] ?? "")) ?>"
                       style="color: var(--text-plum); font-weight: bold;">
                        <?= e($settings["contact_phone"] ?? "") ?>
                    </a>
                </p>
            </div>
            <div class="feature-card" style="margin-bottom: 15px;">
                <p>✉️ <strong>Email:</strong></p>
                <p><?= e($settings["contact_email"] ?? "") ?></p>
            </div>
            <div class="feature-card" style="margin-bottom: 25px;">
                <p>📍 <strong>Location:</strong></p>
                <p><?= e($settings["location"] ?? "") ?></p>
            </div>

            <form action="contact.php" method="post" style="text-align: left;">
                <h2 style="margin-top: 0;">Send us a message</h2>

                <?php if ($contactFlash): ?>
                <p class="flash flash-<?= e($contactFlash["type"]) ?>"><?= e($contactFlash["message"]) ?></p>
                <?php endif; ?>

                <?= csrf_field() ?>

                <label style="display: block; margin-top: 10px; font-weight: 600;">Name *</label>
                <input type="text" name="name" required value="<?= e($conOld["name"] ?? "") ?>"
                       style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">

                <label style="display: block; margin-top: 15px; font-weight: 600;">Email *</label>
                <input type="email" name="email" required value="<?= e($conOld["email"] ?? "") ?>"
                       style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">

                <label style="display: block; margin-top: 15px; font-weight: 600;">Phone</label>
                <input type="tel" name="phone" value="<?= e($conOld["phone"] ?? "") ?>"
                       style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;">

                <label style="display: block; margin-top: 15px; font-weight: 600;">Message *</label>
                <textarea name="message" rows="4" required
                          style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc;"><?= e($conOld["message"] ?? "") ?></textarea>

                <button type="submit" style="width: 100%; background: var(--plum-header); color: white; border: none; padding: 12px; margin-top: 20px; border-radius: 25px; font-weight: bold; cursor: pointer;">Send Message</button>
            </form>
        </section>

    </main>

    <!-- AUTOMATIC POP-UP MODAL -->
    <div class="popup-overlay" id="premiumPopup">
        <div class="popup-box">
            <h2>Premium Japanese Spare Parts</h2>
            <p>We supply quality spare parts for Toyota, Nissan, Subaru, Mazda, Honda and Mitsubishi.</p>
            <button class="popup-btn" onclick="closePopup()">Register Today</button>
            <button class="close-x" onclick="closePopup()">✕</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
