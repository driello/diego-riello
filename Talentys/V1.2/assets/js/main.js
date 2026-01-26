// DRAG TO SCROLL SLIDES
const slider = document.getElementById('slide-wrapper');

let isDown = false;
let startX;
let scrollLeft;

if (slider) {
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
    const walk = (x - startX) * 2; // Vitesse
    slider.scrollLeft = scrollLeft - walk;
  });
}

// APPEAR ON SCROLL
const appearElements = document.querySelectorAll('.appear');

const appearOptions = {
  threshold: 0.2,
  rootMargin: "0px 0px -50px 0px"
};

const appearOnScroll = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    entry.target.classList.add('visible');
    observer.unobserve(entry.target);
  });
}, appearOptions);

appearElements.forEach(el => {
  appearOnScroll.observe(el);
});

// BASIC FRONT VALIDATION (regex email, mot de passe)
function validateEmail(email) {
  const re = /^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/;
  return re.test(email);
}

function validatePassword(password) {
  const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%&*])[A-Za-z\d!@#$%&*]{10,}$/;
  return re.test(password);
}

// Exemples d'utilisation (tu peux les intégrer aux formulaires plus tard)
/*
const form = document.querySelector('form');
form.addEventListener('submit', e => {
  const email = form.email.value;
  const password = form.password.value;
  if (!validateEmail(email) || !validatePassword(password)) {
    e.preventDefault();
    alert('Email ou mot de passe invalide');
  }
});
*/
