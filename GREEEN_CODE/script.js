/**
 * Ce script ajoute les interactions principales du site :
 * - un menu burger pour le mobile ;
 * - un thème sombre mémorisé dans le navigateur ;
 * - un bloc de commande injecté dynamiquement dans la page.
 */

// Lecture immédiate du thème sauvegardé pour réappliquer l'apparence choisie au rechargement.
let theme = localStorage.getItem('theme');
if (theme === 'dark') {
  document.body.classList.add('dark');
}
 


// Les manipulations DOM sont lancées une fois la structure HTML complètement disponible.
document.addEventListener('DOMContentLoaded', () => {

  // Points d'ancrage dans lesquels le script injecte ou pilote des éléments.
  const header = document.querySelector('header');
  const nav = document.querySelector('nav');


  // Création du bouton burger directement en JavaScript pour ne l'afficher que si le script est actif.
  const burger = document.createElement('button');
  burger.type = 'button';
  burger.textContent = 'MENU ☰';
  burger.className = 'burger';
  burger.setAttribute('aria-label', 'Ouvrir le menu');
  header.appendChild(burger);


  // Le clic ajoute ou retire la classe .active qui contrôle l'ouverture du menu mobile.
  burger.addEventListener('click', () => {
    nav.classList.toggle('active');
  });

  // Un clic sur un lien du menu referme la navigation pour revenir au contenu.
  nav.addEventListener('click', (e) => {
    if (e.target.closest('a, li')) {
      nav.classList.remove('active');
    }
  });


  // Un clic à l'extérieur du menu et du bouton ferme aussi la navigation ouverte.
  document.addEventListener('click', (e) => {
    if (!nav.contains(e.target) && !burger.contains(e.target)) {
      nav.classList.remove('active');
    }
  });


  // Le bouton de thème est ajouté dans le footer pour ne pas surcharger le header.
  let modeSombre = document.createElement('button');
  let footer = document.querySelector('footer');
  footer.style.display = 'flex';
  modeSombre.innerHTML = "🌓";
  footer.appendChild(modeSombre);

  // La classe .dark modifie l'apparence, puis le choix est mémorisé dans localStorage.
  modeSombre.addEventListener('click', () => {
    document.body.classList.toggle('dark');

    if (document.body.classList.contains('dark')) {
      localStorage.setItem('theme', 'dark');
    } else {
      localStorage.setItem('theme', 'light');
    }
  });

  // Construction dynamique d'un bloc promotionnel placé juste après la section principale.
  let section1 = document.querySelector('#section1');
  let commande = document.createElement('div');
  let commandeBouton = document.createElement('button')
  commande.className = 'commande';
  commande.style.background = 'rgb(225, 146, 0)';
    commande.style.marginInline = '50px'
  commande.style.display = 'flex';
  commande.style.flexDirection = 'column';
  commande.style.justifyContent = 'center';
  commande.style.alignItems = 'center';

  let commandeTitre = document.createElement('h2');
  commandeTitre.textContent = 'Découvrez notre catalogue et commandez en ligne';

  commandeBouton.textContent = 'Commander';
  commandeBouton.style.background = '#5A0A0A'
  commandeBouton.style.color = "whitesmoke";
  commandeBouton.style.border = '1px solid whitesmoke';
  commandeBouton.style.width = '100px';
  commandeBouton.style.height = '40px';
  commandeBouton.style.marginBottom = '10px';
  commande.appendChild(commandeTitre);
  commande.appendChild(commandeBouton);
  section1.after(commande);

  // Prototype conservé en commentaire : ancienne tentative de tableau d'avis généré en JS.
  /*
  let commentaires = document.createElement('table');
  let bandeau = document.createElement('thead');
  let enTete = document.createElement('tr');
  let user = document.createElement('th');
  let etoile = document.createElement('th');
  let avis = document.createElement('th');
  user.textContent = 'Utilisateur';
  etoile.textContent = 'Note';
  avis.textContent = 'Avis';

  enTete.appendChild(user);
  enTete.appendChild(etoile);
  enTete.appendChild(avis);
  bandeau.appendChild(enTete);
  commentaires.appendChild(bandeau);
  section1.appendChild(commentaires);


  for (i = 0 ; i < tableauAvis.length ; i++ ){
    let avisClient = document.createElement('tr');
    let userClient = document.createElement('td');
    let etoileClient = document.createElement('td');
    let commentaireClient = document.createElement('td');
    userClient.textContent = 'zdqsHJHKH';
    etoileClient.textContent = 'jhhJHKHK';
    commentaireClient.textContent = 'GYGYGYGFUI';

    avisClient.appendChild(userClient);
    avisClient.appendChild(etoileClient);
    avisClient.appendChild(commentaireClient);

    commentaires.appendChild(avisClient);
  }
*/
});






