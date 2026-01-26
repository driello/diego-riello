// main.js
document.addEventListener('DOMContentLoaded', () => {
  // Drag & scroll horizontal for slides container
  const slider = document.getElementById('slidesContainer');
  let isDown = false;
  let startX;
  let scrollLeft;

  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    slider.classList.add('active');
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  });
  slider.addEventListener('mouseleave', () => {
    isDown = false;
    slider.classList.remove('active');
  });
  slider.addEventListener('mouseup', () => {
    isDown = false;
    slider.classList.remove('active');
  });
  slider.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 2; // scroll speed multiplier
    slider.scrollLeft = scrollLeft - walk;
  });

  // IntersectionObserver for fade‑in animations
  const faders = document.querySelectorAll('.slides__slide, .feature-card, .contact__heading, .contact__form');
  const options = {
    threshold: 0.2
  };

  const appearOnScroll = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('appear');
      observer.unobserve(entry.target);
    });
  }, options);

  faders.forEach(fader => {
    appearOnScroll.observe(fader);
  });

  // Simple form validation
  const form = document.getElementById('contactForm');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const message = form.message.value.trim();

    if (name === '' || email === '' || message === '') {
      alert('Veuillez remplir tous les champs.');
      return;
    }
    // simple email regex
    const emailReg = /\S+@\S+\.\S+/;
    if (!emailReg.test(email)) {
      alert('Veuillez entrer une adresse email valide.');
      return;
    }

    alert('Merci pour votre message ! Nous vous répondrons bientôt.');
    form.reset();
  });
});
