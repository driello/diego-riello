 <?php
// index.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device‑width, initial‑scale=1.0">
  <title>TALENTYS | Show your talent, shape the future</title>
  <link rel="stylesheet" href="./assets/css/main.css">
</head>
<body class="page">
  <?php include __DIR__ . '/partials/header.php'; ?>

  <main class="main-content">
    <!-- Section Slides -->
    <section class="slides">
      <div class="slides__container" id="slidesContainer">
        <!-- Slide 1 — Hero -->
        <div class="slides__slide slides__slide--hero">
          <div class="slides__content container">
            <img src="/assets/img/logo‑talentys.png" alt="Talentys Logo" class="slides__hero-logo">
            <h1 class="slides__hero-tagline">Show your talent, shape the future.</h1>
          </div>
        </div>
        <!-- Slide 2 — Le concept -->
        <div class="slides__slide">
          <div class="slides__content container">
            <h2 class="slides__title">Le concept</h2>
            <img src="/assets/img/infographic-placeholder.png" alt="Infographique" class="slides__img">
            <p class="slides__text">Une plateforme innovante pour connecter talents et opportunités.</p>
          </div>
        </div>
        <!-- Slide 3 — CV virtuel interactif -->
        <div class="slides__slide">
          <div class="slides__content container">
            <h2 class="slides__title">CV virtuel interactif</h2>
            <img src="/assets/img/desk‑v1‑placeholder.png" alt="Capture bureau v1" class="slides__img">
            <a class="button button--primary slides__btn" href="#demo">Accéder à la démo</a>
          </div>
        </div>
        <!-- Slide 4 — Connexion des talents -->
        <div class="slides__slide">
          <div class="slides__content container">
            <h2 class="slides__title">Connexion des talents et recruteurs</h2>
            <img src="/assets/img/connection‑placeholder.png" alt="Candidats ↔ recruteurs" class="slides__img">
            <p class="slides__text">Une passerelle fluide entre profils et entreprises.</p>
          </div>
        </div>
        <!-- Slide 5 — Espace recruteur -->
        <div class="slides__slide">
          <div class="slides__content container">
            <h2 class="slides__title">Espace recruteur</h2>
            <img src="/assets/img/maquette‑construction.png" alt="Maquette en construction" class="slides__img">
            <p class="slides__text">Bientôt disponible : gestion complète des talents.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Section Fonctionnalités -->
    <section class="features container">
      <h2 class="features__heading">Nos fonctionnalités</h2>
      <div class="features__grid">
        <div class="feature-card" id="create-candidate">
          <h3 class="feature-card__title">Créer mon profil candidat</h3>
          <p class="feature-card__text">Mettez en valeur votre parcours et vos compétences.</p>
        </div>
        <div class="feature-card" id="create-recruiter">
          <h3 class="feature-card__title">Créer un espace recruteur</h3>
          <p class="feature-card__text">Trouvez, gérez et engagez les talents en un clic.</p>
        </div>
        <div class="feature-card" id="demo">
          <h3 class="feature-card__title">Accéder au bureau démo (V1/V2)</h3>
          <p class="feature-card__text">Explorez la plateforme en version démo dès maintenant.</p>
        </div>
        <div class="feature-card" id="contact-card">
          <h3 class="feature-card__title">Contact Talentys</h3>
          <p class="feature-card__text">Besoin d’assistance ou d’informations ? Nous sommes là.</p>
        </div>
      </div>
    </section>

    <!-- Section Formulaire de contact -->
    <section id="contact" class="contact container">
      <h2 class="contact__heading">Nous contacter</h2>
      <form class="contact__form" id="contactForm" novalidate>
        <div class="contact__field">
          <label for="name">Nom</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="contact__field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="contact__field">
          <label for="message">Message</label>
          <textarea id="message" name="message" rows="4" required></textarea>
        </div>
        <button class="button button--primary contact__btn" type="submit">Envoyer</button>
      </form>
    </section>

  </main>

  <?php include __DIR__ . '/partials/footer.php'; ?>

  <script src="./assets/js/main.js"></script>
</body>
</html>
