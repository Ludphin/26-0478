<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apex Precision Auto Care</title>
    <style>
        :root {
            --primary: #e74c3c; /* Racing Red Accent */
            --primary-hover: #c0392b;
            --dark: #2c3e50; /* Deep Charcoal */
            --light: #f4f6f7;
            --card-bg: #ffffff;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.7;
            margin: 0;
            padding: 0;
            background-color: var(--light);
            color: #333;
        }

        /* 1. Navigation Hyperlinks Bar */
        nav {
            background-color: #1a252f;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-container {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: #bdc3c7;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        /* Hero / Header Section */
        header {
            background: linear-gradient(135deg, #1a252f, var(--dark));
            color: white;
            text-align: center;
            padding: 70px 20px;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-bottom: 4px solid var(--primary);
        }

        /* Heading with auto mechanic website name */
        header h1 {
            margin: 0;
            font-size: 2.8rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Subheading describing what the website does */
        header p {
            margin: 15px 0 0 0;
            font-size: 1.2rem;
            color: #bdc3c7;
            font-weight: 300;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px 60px 20px;
        }

        h2.section-title {
            text-align: center;
            color: var(--dark);
            margin-top: 40px;
            margin-bottom: 25px;
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Three Key Service Features Layout */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }

        .feature-card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary);
        }

        .feature-card h3 {
            margin-top: 0;
            color: var(--dark);
        }

        /* 2. Mechanics & Maintenance Services Table Styling */
        .table-container {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            overflow-x: auto;
            margin-bottom: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 14px 15px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--dark);
            color: white;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        /* 3. Image Grid Showcase Layout (Replaces YouTube Video) */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }

        .gallery-item {
            background: var(--card-bg);
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .gallery-caption {
            padding: 15px;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--dark);
            background: #fff;
            border-top: 1px solid #eee;
        }

        /* Four paragraphs container */
        .about-section {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .about-section p {
            margin-bottom: 20px;
            text-align: justify;
            color: #555;
        }

        .about-section p:last-child {
            margin-bottom: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            header h1 { font-size: 1.8rem; }
            header p { font-size: 1rem; }
            .about-section { padding: 20px; }
            .nav-container { flex-direction: column; gap: 10px; }
            .image-gallery { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- 1. Navigation Links -->
    <nav>
        <div class="nav-container">
            <a href="#" class="nav-logo">🔧 Apex Auto Care</a>
            <div class="nav-links">
                <a href="#services">Services</a>
                <a href="#pricing">Pricing</a>
                <a href="#facility">Our Facility</a>
                <a href="#about">About Us</a>
            </div>
        </div>
    </nav>

    <!-- Header containing Title and Subtitle -->
    <header>
        <h1>Apex Precision Auto Care</h1>
        <p>Professional diagnostics, transparent pricing, and precision mechanical repair services.</p>
    </header>

    <div class="container">
        
        <!-- Three Key Features Section -->
        <h2 class="section-title" id="services">Why Drivers Trust Us</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>1. Certified Technicians</h3>
                <p>All structural repairs and digital engine tune-ups are executed by ASE-certified mechanics.</p>
            </div>
            <div class="feature-card">
                <h3>2. Advanced Diagnostics</h3>
                <p>We leverage modern computer interfaces to pinpoint errors quickly and eliminate guesswork.</p>
            </div>
            <div class="feature-card">
                <h3>3. Nationwide Warranty</h3>
                <p>Drive away securely knowing that our qualifying parts and services carry a robust 24-month protection plan.</p>
            </div>
        </div>

        <!-- 2. Standard Maintenance Table -->
        <h2 class="section-title" id="pricing">Common Maintenance & Pricing</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Service Type</th>
                        <th>Estimated Time</th>
                        <th>Includes</th>
                        <th>Price Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Synthetic Oil Change</strong></td>
                        <td>45 Mins</td>
                        <td>5 Quarts Oil, Premium Filter, Fluid Top-Off</td>
                        <td>$75 - $95</td>
                    </tr>
                    <tr>
                        <td><strong>Brake Pad Replacement</strong></td>
                        <td>1.5 Hours</td>
                        <td>Ceramic Pads, Hardware Kit, Component Lubrication</td>
                        <td>$180 - $240</td>
                    </tr>
                    <tr>
                        <td><strong>Engine Diagnostics</strong></td>
                        <td>1 Hour</td>
                        <td>Full Computerized Code Scan, Multi-Point Inspection</td>
                        <td>$90 - $110</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 3. Image Layout Showcase (Replacing YouTube Frame) -->
        <h2 class="section-title" id="facility">Inside Our Workshop</h2>
        <div class="image-gallery">
            <div class="gallery-item">
                <img src="https://images.squarespace-cdn.com/content/v1/63d92a1ea2956a465c1ee468/b156671d-1771-48de-8c36-7d5ca98c3254/20230508_075704.jpg" alt="Clean modern auto shop hydraulic lifts">
                <div class="gallery-caption">Our Service Bays — Clean, organized facilities equipped with precision hydraulic lifts.</div>
            </div>
            <div class="gallery-item">
                <img src="https://www.ettransport.ca/wp-content/uploads/2022/05/Engine-Repair.jpg" alt="Mechanic working on car engine block component">
                <div class="gallery-caption">Precision Engineering — Detailed diagnostics and meticulous repairs under the hood.</div>
            </div>
        </div>

        <!-- Four Paragraphs Section -->
        <h2 class="section-title" id="about">Our Story & Operations</h2>
        <div class="about-section">
            <p><strong>Paragraph 1:</strong> Founded with a commitment to restoring integrity to the auto repair process, Apex Precision Auto Care has grown from a humble two-bay garage into a cutting-edge regional repair center. We understand that your vehicle is a vital extension of your daily life, keeping you safe and connected. That is why our core philosophy centers on transparency, absolute mechanical accuracy, and an unwavering commitment to quality components.</p>

            <p><strong>Paragraph 2:</strong> Our physical workshop features top-tier modern machinery engineered to service domestic, import, and fleet vehicles alike. From automated alignment racks to advanced OBD-II electrical scan systems, we match factory dealership capabilities while offering the personalized care of an independent shop. We take pride in educating our clients about their vehicle health, ensuring no work begins without explicit prior approval.</p>

            <p><strong>Paragraph 3:</strong> Beyond standard engine overhauls and complex brake calibrations, we place heavy emphasis on preventative maintenance. Our historical tracking database monitors your vehicle's specific mileage milestones, ensuring we capture and resolve minor component stress before it morphs into expensive, unexpected roadside failures. We keep full logs of fluid states, belt wear, and tire integrity so you can plan out repairs predictably.</p>

            <p><strong>Paragraph 4:</strong> Ultimately, a mechanics shop is only as durable as the trust it establishes within the local community. We hold ourselves to a strict ethical standard, consistently recycling used fluids responsibly and procuring components from premier, verified parts manufacturers. Thank you for entrusting your vehicle to Apex Precision Auto Care—where we handle your engine as if it were our own.</p>
        </div>

    </div>

</body>
</html>
