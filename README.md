<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>26-0478 | School Project</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Serif+4:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --ink: #1a1208;
      --cream: #f5f0e8;
      --gold: #c8962a;
      --rust: #b84c1e;
      --light: #faf7f2;
    }

    body {
      background-color: var(--light);
      color: var(--ink);
      font-family: 'Source Serif 4', Georgia, serif;
      font-weight: 300;
      line-height: 1.8;
    }

    header {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 4rem 2rem;
      background: var(--cream);
      border-bottom: 2px solid var(--ink);
    }

    .badge {
      font-size: 0.7rem;
      letter-spacing: 0.3em;
      text-transform: uppercase;
      color: var(--rust);
      border: 1px solid var(--rust);
      padding: 0.35rem 1rem;
      margin-bottom: 2.5rem;
      animation: fadeUp 0.8s ease forwards;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-weight: 900;
      font-size: clamp(3.5rem, 10vw, 8rem);
      line-height: 1;
      color: var(--ink);
      animation: fadeUp 0.9s ease forwards 0.3s;
      opacity: 0;
    }

    h1 span { color: var(--gold); font-style: italic; }

    .subheading {
      margin-top: 2rem;
      font-size: clamp(1rem, 2.5vw, 1.25rem);
      font-style: italic;
      color: #5a4a35;
      max-width: 560px;
      animation: fadeUp 0.9s ease forwards 0.5s;
      opacity: 0;
    }

    main {
      max-width: 780px;
      margin: 0 auto;
      padding: 6rem 2rem 8rem;
    }

    .section-label {
      font-size: 0.68rem;
      letter-spacing: 0.35em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 3rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .section-label::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--gold);
      opacity: 0.4;
    }

    .paragraph-block {
      margin-bottom: 3.5rem;
      padding-left: 1.5rem;
      border-left: 3px solid transparent;
      transition: border-color 0.3s ease;
    }

    .paragraph-block:hover { border-left-color: var(--gold); }

    .paragraph-block h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--rust);
      margin-bottom: 0.75rem;
    }

    .paragraph-block p {
      font-size: 1.05rem;
      color: #3d3022;
      line-height: 1.9;
    }

    footer {
      text-align: center;
      padding: 2.5rem 1rem;
      background: var(--ink);
      color: var(--cream);
      font-size: 0.8rem;
      letter-spacing: 0.1em;
    }

    footer span { color: var(--gold); }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(30px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <header>
    <div class="badge">University of Dunaújváros &nbsp;·&nbsp; 2025–2026</div>
    <h1>Project <span>26-0478</span></h1>
    <p class="subheading">An academic exploration presented as part of the Computer Science Engineering programme.</p>
  </header>

  <main>
    <div class="section-label">About This Project</div>

    <div class="paragraph-block">
      <h2>Introduction</h2>
      <p>This project was developed as part of the Computer Science Engineering curriculum at the University of Dunaújváros. It represents a structured effort to apply theoretical knowledge gained throughout the academic year into a practical, real-world context. The aim is to demonstrate understanding of core computing concepts through focused research and implementation.</p>
    </div>

    <div class="paragraph-block">
      <h2>Objectives</h2>
      <p>The primary objective of this project is to analyse, design, and present a solution to a defined problem within the scope of the course. Through careful planning and methodical execution, the project seeks to highlight the student's ability to think critically, manage tasks independently, and communicate findings in a clear and professional manner.</p>
    </div>

    <div class="paragraph-block">
      <h2>Methodology</h2>
      <p>Research for this project was carried out using a combination of academic references, practical exercises, and guided coursework materials. Each phase of the project followed a structured workflow — from initial concept and research, through development and testing, to final documentation and presentation. This approach ensured consistent progress and quality throughout.</p>
    </div>

    <div class="paragraph-block">
      <h2>Conclusion</h2>
      <p>Completing this project provided valuable insight into both the technical and analytical demands of computer science. It reinforced the importance of precision, logical thinking, and iterative improvement. The experience gained here will serve as a strong foundation for more advanced coursework and future professional development in the field of engineering and technology.</p>
    </div>
  </main>

  <footer>
    &copy; 2026 &nbsp;<span>26-0478</span>&nbsp; · University of Dunaújváros · All rights reserved.
  </footer>

</body>
</html>
