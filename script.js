// Loisirs : sélections statiques, triées par nom ; modifier librement ces quatre listes.
const leisurePhotos = {
  dj: [
    { src: "./img/Loisirs/dj/2B036B01-4782-4EF9-A50B-D3EC9C8B0FCA_1_105_c.webp", alt: "Portrait derrière les platines dans une ambiance bleutée." },
    { src: "./img/Loisirs/dj/43FF6B48-5664-44E7-B979-A9736CA91461_1_102_o.webp", alt: "Installation de mixage et enceinte face à une terrasse." },
    { src: "./img/Loisirs/dj/519A7CFC-EEE8-4BA3-97AC-DB35F6DCCE56_1_105_c.webp", alt: "Platines et table de mixage éclairées en violet." },
  ],
  cuisine: [
    { src: "./img/Loisirs/cuisine/thierry_marx_foodlab.webp", alt: "Deux personnes posant ensemble dans une cuisine." },
    { src: "./img/Loisirs/cuisine/06.webp", alt: "Préparation dressée dans une assiette creuse." },
    { src: "./img/Loisirs/cuisine/08.webp", alt: "Part de pâtisserie dorée sur une planche en bois." },
    { src: "./img/Loisirs/cuisine/09.webp", alt: "Gâteau au glaçage rose en spirale." },
    { src: "./img/Loisirs/cuisine/12.webp", alt: "Plat de viande en sauce et légumes." },
    { src: "./img/Loisirs/cuisine/13.webp", alt: "Assiette de légumes colorés et fromage frais." },
    { src: "./img/Loisirs/cuisine/14.webp", alt: "Pâtisserie garnie de crème et de poudre de cacao." },
    { src: "./img/Loisirs/cuisine/16.webp", alt: "Assiette de pâtes et légumes verts." },
    { src: "./img/Loisirs/cuisine/Poisson en croûte de gros sel.webp", alt: "Poisson entier recouvert d’une croûte de gros sel." },
    
  ],
  voyages: [
    { src: "./img/Loisirs/voyages/90c3d430-22f3-430c-8da6-2329faf5ee0c.webp", alt: "Voyageur dans le hall de l’aéroport d’Ibiza." },
    { src: "./img/Loisirs/voyages/IMG_0740.webp", alt: "Paysage de montagne enneigé sous un ciel bleu." },
    { src: "./img/Loisirs/voyages/IMG_1098.webp", alt: "Scène illuminée et public lors d’une soirée musicale." },
    { src: "./img/Loisirs/voyages/IMG_9560.webp", alt: "Soleil au-dessus de la mer et des îlots." },
    { src: "./img/Loisirs/voyages/Viande rosée et légumes grillés.webp", alt: "Assiette de viande rosée et de légumes grillés." },
  ],
  bricolage: [
    { src: "./img/Loisirs/bricolage/IMG_7046.webp", alt: "Pièce en cours de rénovation, avec outils et escabeau." },
    { src: "./img/Loisirs/bricolage/IMG_7185.webp", alt: "Cuisine aménagée avec meubles en bois et plan de travail." },
    { src: "./img/Loisirs/bricolage/comediens1.webp", alt: "Pièce en travaux avec cloisons et matériel de chantier." },
    { src: "./img/Loisirs/bricolage/comediens4.webp", alt: "Espace de cuisine aménagé avec évier et plan de travail." },
  ],
};

// Sélection provisoire : modifier ici la source, la catégorie, la légende, l’alt et le cadrage.
const cuisinePhotos = [
  {
    "src": "./img/cuisine/production/02.webp",
    "category": "plats",
    "caption": "Préparation en grand plat",
    "alt": "Grand plat de riz jaune garni de crevettes et de coquillages.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/production/10.webp",
    "category": "plats",
    "caption": "Dressage sur assiette allongée",
    "alt": "Pièce de viande nappée de sauce brune et légumes sur une assiette allongée.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/evenementiel/IMG_0851.webp",
    "category": "traiteur",
    "caption": "Présentation du buffet",
    "alt": "Diego Riello en tenue de cuisine derrière un buffet de bouchées et de verrines.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/production/entrée.webp",
    "category": "plats",
    "caption": "Entrée dressée",
    "alt": "Entrée dressée avec une tuile et des traits de sauce verte.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/evenementiel/mariageLesComeΓòáu╠êdiens.webp",
    "category": "patisserie",
    "caption": "Gâteaux de réception",
    "alt": "Plusieurs gâteaux décorés disposés sur une table de réception.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/maitrise/02.webp",
    "category": "traiteur",
    "caption": "Assiettes en série",
    "alt": "Nombreuses assiettes garnies et alignées sur une longue table.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/maitrise/IMG_0752.webp",
    "category": "traiteur",
    "caption": "Mini-burgers",
    "alt": "Mini-burgers garnis et disposés sur un plateau.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/maitrise/foiegras.webp",
    "category": "traiteur",
    "caption": "Préparation en bocaux",
    "alt": "Bocaux étiquetés alignés sur des étagères.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/evenementiel/01.webp",
    "category": "traiteur",
    "caption": "Tables sous une tente",
    "alt": "Tables dressées avec nappes blanches, verres et compositions végétales sous une tente.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/evenementiel/03.webp",
    "category": "traiteur",
    "caption": "Bouchées sur présentoirs",
    "alt": "Petites bouchées disposées sur plusieurs plateaux et présentoirs de buffet.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/evenementiel/mariage.webp",
    "category": "traiteur",
    "caption": "Buffet de réception",
    "alt": "Buffet de réception avec plateaux de bouchées et présentoirs.",
    "position": "50% 50%"
  },
  {
    "src": "./img/cuisine/evenementiel/Cocktail traiteur saumon fdec.webp",
    "category": "traiteur",
    "caption": "Préparation d’un cocktail",
    "alt": "Préparation de bouchées alignées sur un plan de travail.",
    "position": "50% 50%"
  }
];

const mobileLayout = window.matchMedia('(max-width: 767px)');
const panelDialog = document.querySelector('#cvDialog');
const dialogTitle = document.querySelector('#dialogTitle');
const dialogKicker = document.querySelector('#dialogKicker');
const dialogContent = document.querySelector('#dialogContent');
const dialogClose = document.querySelector('.dialog-close');

const imageViewer = document.querySelector('#imageViewer');
const viewerImage = document.querySelector('#viewerImage');
const imageCaption = document.querySelector('#imageCaption');
const imageViewerClose = document.querySelector('.image-viewer__close');

let lastTrigger = null;
let lastMediaTrigger = null;
let unmountDesktop = null;
const sectionClasses = ['projects-dialog', 'skills-dialog', 'cuisine-dialog', 'operations-dialog', 'leisure-dialog'];

// Les templates restent la seule source des contenus professionnels.
function mountPanel(panelName, container) {
  const template = document.querySelector(`#panel-${panelName}`);
  container.replaceChildren(template.content.cloneNode(true));
  const cleanups = [];
  bindCuisineGallery(container);
  bindLeisureGalleries(container, cleanups);
  bindMediaCards(container);
  bindDiplomaGallery(container);
  return () => {
    cleanups.forEach((cleanup) => cleanup());
    container.replaceChildren();
  };
}

function createProfileStatus(short = false) {
  const badge = document.createElement('span');
  badge.className = 'profile-status';
  const label = document.createElement('span');
  const profile = document.querySelector('#panel-profile');
  label.textContent = short ? profile.dataset.statusShort : profile.dataset.status;
  badge.append(label);
  return badge;
}

function openPanel(panelName, trigger) {
  const template = document.querySelector(`#panel-${panelName}`);
  if (!template) return;
  sectionClasses.forEach((name) => panelDialog.classList.toggle(name, template.dataset.dialogClass === name));
  lastTrigger = trigger;
  dialogTitle.textContent = template.dataset.title;
  dialogKicker.textContent = template.dataset.kicker;
  unmountDesktop?.();
  unmountDesktop = mountPanel(panelName, dialogContent);
  panelDialog.querySelector('.profile-status')?.remove();
  if (panelName === 'profile') {
    dialogTitle.after(createProfileStatus());
    if (mobileLayout.matches) {
      const domains = document.createElement('ul');
      domains.className = 'mobile-profile-domains';
      domains.setAttribute('aria-label', 'Domaines professionnels');
      document.querySelector('#panel-contact').content.querySelectorAll('.skill-domain__title').forEach((title) => {
        const item = document.createElement('li');
        item.textContent = title.textContent;
        domains.append(item);
      });
      const body = dialogContent.querySelector('.profile-body');
      body.prepend(domains);
      body.append(dialogContent.querySelector('.profile-cv'));
      dialogContent.querySelector('.profile-contact').remove();
    }
  }
  panelDialog.showModal();
  dialogClose.focus();
}

function clearDesktopPanel() {
  panelDialog.querySelector('.profile-status')?.remove();
  unmountDesktop?.();
  unmountDesktop = null;
}

function closePanel() {
  if (panelDialog.open) panelDialog.close();
  clearDesktopPanel();
}

document.querySelectorAll('[data-panel]').forEach((trigger) => {
  trigger.addEventListener('click', () => openPanel(trigger.dataset.panel, trigger));
});

dialogClose.addEventListener('click', closePanel);

panelDialog.addEventListener('click', (event) => {
  if (event.target !== panelDialog) return;
  const shell = panelDialog.querySelector('.dialog-shell');
  const bounds = shell.getBoundingClientRect();
  const outside = event.clientX < bounds.left || event.clientX > bounds.right
    || event.clientY < bounds.top || event.clientY > bounds.bottom;

  if (outside) closePanel();
});

panelDialog.addEventListener('close', () => {
  // Un événement close tardif ne doit pas effacer une nouvelle ouverture.
  if (panelDialog.open) return;
  clearDesktopPanel();
  if (lastTrigger?.getClientRects().length) lastTrigger.focus();
});

function bindMediaCards(container = dialogContent) {
  container.querySelectorAll('.media-card').forEach((card) => {
    if (card.closest('.leisure-gallery')) return;
    const image = card.querySelector('img');
    if (!image) return;

    card.addEventListener('click', () => {
      lastMediaTrigger = card;
      viewerImage.src = image.currentSrc || image.src;
      viewerImage.alt = image.alt;
      imageCaption.textContent = card.dataset.caption || image.alt;
      imageViewer.showModal();
      imageViewerClose.focus();
    });
  });
}

imageViewerClose.addEventListener('click', () => imageViewer.close());
imageViewer.addEventListener('close', () => {
  if (lastMediaTrigger?.isConnected && !lastMediaTrigger.closest('[hidden]')
    && (panelDialog.open || mobileLayout.matches)) lastMediaTrigger.focus();
  lastMediaTrigger = null;
});

imageViewer.addEventListener('click', (event) => {
  if (event.target === imageViewer) imageViewer.close();
});

const themeToggle = document.querySelector('.theme-toggle');
const themeIcon = themeToggle.querySelector('span');

function applyTheme(lightMode) {
  document.documentElement.classList.toggle('light-office', lightMode);
  themeToggle.setAttribute('aria-pressed', String(lightMode));
  themeToggle.setAttribute('aria-label', lightMode ? 'Activer le thème sombre' : 'Activer le thème clair');
  themeIcon.textContent = lightMode ? '☾' : '☀';
}

applyTheme(initialLightMode);

themeToggle.addEventListener('click', () => {
  const lightMode = !document.documentElement.classList.contains('light-office');
  applyTheme(lightMode);
  try {
    localStorage.setItem('office-theme', lightMode ? 'light' : 'dark');
  } catch (error) {
    // Le thème reste utilisable même si le stockage local est indisponible.
  }
});

const scene = document.querySelector('.scene');
const office = document.querySelector('.office');

// Centre la vue ; sur mobile, le décor reste accessible par défilement horizontal.
function centerOffice() {
  if (mobileLayout.matches) return;
  office.scrollLeft = (scene.offsetWidth - office.clientWidth) / 2;
}

centerOffice();
window.addEventListener('resize', centerOffice);

scene.addEventListener('pointermove', (event) => {
  if (event.pointerType === 'touch') return;
  const bounds = scene.getBoundingClientRect();
  const x = ((event.clientX - bounds.left) / bounds.width) * 100;
  const y = ((event.clientY - bounds.top) / bounds.height) * 100;
  scene.style.setProperty('--mx', `${x}%`);
  scene.style.setProperty('--my', `${y}%`);
});

scene.addEventListener('pointerleave', () => {
  scene.style.setProperty('--mx', '50%');
  scene.style.setProperty('--my', '50%');
});

function bindDiplomaGallery(container = dialogContent) {
  const gallery = container.querySelector('.diploma-gallery');
  if (!gallery) return;
  gallery.querySelectorAll('.diploma-gallery__zoom').forEach((button) => {
    button.addEventListener('click', () => button.closest('.diploma-gallery__card').querySelector('.media-card').click());
  });

}

function bindCuisineGallery(container = dialogContent) {
  const gallery = container.querySelector('.cuisine-gallery');
  if (!gallery) return;
  const grid = gallery.querySelector('.cuisine-gallery__grid');
  // Une même source ne doit apparaître qu’une fois dans la sélection.
  const photos = cuisinePhotos.filter((photo, index, all) => all.findIndex((item) => item.src === photo.src) === index);
  photos.forEach((photo) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'media-card cuisine-gallery__photo';
    button.dataset.caption = photo.caption;
    button.setAttribute('aria-label', `Agrandir : ${photo.caption}`);
    const image = document.createElement('img');
    image.src = photo.src;
    image.alt = photo.alt;
    image.loading = 'lazy';
    image.style.objectPosition = photo.position || '50% 50%';
    button.append(image);
    grid.append(button);
  });
}

function bindLeisureGalleries(container = dialogContent, cleanups = []) {
  container.querySelectorAll('[data-leisure-gallery]').forEach((card) => {
    const photos = leisurePhotos[card.dataset.leisureGallery] || [];
    if (!photos.length) return;
    const gallery = document.createElement('div');
    gallery.className = 'leisure-gallery';
    gallery.setAttribute('role', 'region');
    gallery.setAttribute('aria-label', `Photos — ${card.querySelector('h3').textContent}`);
    const update = () => {
      if (gallery.scrollWidth > gallery.clientWidth + 1) gallery.tabIndex = 0;
      else gallery.removeAttribute('tabindex');
    };
    photos.forEach((photo) => {
      const image = document.createElement('img');
      image.src = photo.src;
      image.alt = photo.alt;
      image.loading = 'lazy';
      image.addEventListener('load', update);
      gallery.append(image);
    });
    card.append(gallery);
    const observer = new ResizeObserver(update);
    observer.observe(gallery);
    cleanups.push(() => observer.disconnect());
    update();
  });
}

// Décor mobile proportionnel ; les mêmes templates alimentent la modale.
const mobileOffice = document.querySelector('.mobile-office');
const themeHome = themeToggle.parentElement;
const themeNextSibling = themeToggle.nextSibling;

function buildMobileProfile() {
  const profile = document.querySelector('#panel-profile');
  document.querySelector('.mobile-portrait').append(profile.content.querySelector('.profile-photo').cloneNode(true));
  document.querySelector('.mobile-profile__name').textContent = profile.dataset.title;
  document.querySelector('.mobile-profile__city').textContent = profile.content.querySelector('address span').textContent.split('·')[0].trim();
  document.querySelector('.mobile-status-slot').append(createProfileStatus(true));
  // Réutiliser les coordonnées du Profil sans dupliquer leurs valeurs.
  const contact = document.querySelector('#panel-mobile-contact').content;
  profile.content.querySelectorAll('.profile-contact a[href^="mailto:"], .profile-contact a[href^="tel:"]').forEach((link) => {
    contact.querySelector('address').append(link.cloneNode(true));
  });
  contact.querySelector('.contact-links').append(profile.content.querySelector('.contact-links a[title="LinkedIn"]').cloneNode(true));
  document.querySelector('.mobile-profile-open').addEventListener('click', (event) => openPanel('profile', event.currentTarget));
  document.querySelector('.mobile-contact-toggle').addEventListener('click', (event) => openPanel('mobile-contact', event.currentTarget));
}

function drawerIcon(panelName) {
  // Trois pictogrammes du modèle Compétences sont réutilisés tels quels.
  const skills = document.querySelector('#panel-contact').content;
  const existing = { cuisine: '.skill-domain--cuisine', operations: '.skill-domain--management', digital: '.skill-domain--digital' };
  if (existing[panelName]) return skills.querySelector(`${existing[panelName]} svg`).cloneNode(true);
  const paths = {
    contact: 'M12 3v3m0 12v3M3 12h3m12 0h3M5.6 5.6l2.1 2.1m8.6 8.6 2.1 2.1M5.6 18.4l2.1-2.1m8.6-8.6 2.1-2.1M17 12a5 5 0 1 1-10 0 5 5 0 0 1 10 0',
    experience: 'M8 7V4h8v3M3 8h18v13H3ZM3 13h18M10 12v3h4v-3',
    diploma: 'm2 8 10-5 10 5-10 5ZM6 11v6l6 4 6-4v-6M22 8v9',
    realisations: 'M12 3v18M3 12h18M5.6 5.6l12.8 12.8M5.6 18.4 18.4 5.6',
  };
  const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  for (const [name, value] of Object.entries({ viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', 'stroke-width': '1.5', 'stroke-linecap': 'round', 'stroke-linejoin': 'round', 'aria-hidden': 'true', focusable: 'false' })) svg.setAttribute(name, value);
  const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
  path.setAttribute('d', paths[panelName]);
  svg.append(path);
  return svg;
}

function buildMobileDrawers() {
  const drawers = document.querySelector('.mobile-drawers');
  const sections = [
    ['contact', 'Compétences'], ['experience', 'Parcours'], ['diploma', 'Diplômes & formations'],
    ['digital', 'Projets numériques'], ['cuisine', 'Cuisine & événementiel'],
    ['operations', 'Management & organisation'], ['realisations', 'Loisirs'],
  ];
  sections.forEach(([panelName, title]) => {
    const toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.className = 'mobile-drawer__toggle';
    toggle.setAttribute('aria-haspopup', 'dialog');
    const label = document.createElement('span');
    label.textContent = title;
    toggle.append(drawerIcon(panelName), label);
    toggle.addEventListener('click', () => openPanel(panelName, toggle));
    drawers.append(toggle);
  });
}

function syncLayout() {
  const focused = document.activeElement;
  const changingSurface = imageViewer.open || panelDialog.open
    || (mobileLayout.matches ? office.contains(focused) : mobileOffice.contains(focused));
  if (imageViewer.open) imageViewer.close();
  closePanel();
  if (mobileLayout.matches) {
    document.querySelector('.mobile-theme-slot').append(themeToggle);
    office.scrollLeft = 0;
  } else {
    themeHome.insertBefore(themeToggle, themeNextSibling);
    centerOffice();
    if (!document.querySelector('[data-office-preload]')) {
      const preload = document.createElement('link');
      preload.rel = 'preload';
      preload.as = 'image';
      preload.dataset.officePreload = '';
      preload.href = document.documentElement.classList.contains('light-office') ? './img/Bureau/bureau2.webp' : './img/Bureau/bureau4.webp';
      document.head.append(preload);
    }
  }
  if (changingSurface) themeToggle.focus({ preventScroll: true });
}

buildMobileProfile();
buildMobileDrawers();
syncLayout();
mobileLayout.addEventListener('change', syncLayout);
