/* =========================================================
   JEU DU PENDU (version DOM)
   - Pas de prompt() => pas de blocage navigateur
   - Pas de reload => on bloque le submit du form
   - Images synchronisées avec le nombre d'erreurs
   Dépend de motsmots.js : global "wordsArray"
   ========================================================= */

(() => {
  /* ---------------------------
     1) Sécurité : dictionnaire
     --------------------------- */
  if (!Array.isArray(wordsArray) || wordsArray.length === 0) {
    console.error("wordsArray introuvable/vide : vérifie motsmots.js");
    return; // on stoppe proprement si le dictionnaire n'est pas chargé
  }

  /* ---------------------------
     2) Constantes du jeu
     --------------------------- */
  const ERREURS_MAX = 7; // on a 7 erreurs possibles (0 → 7)

  // IMPORTANT : le nom du dossier doit être EXACT (IMG vs img)
  const IMAGES = [
    "IMG/pendu7.png", // 0 erreur
    "IMG/pendu6.png",
    "IMG/pendu5.png",
    "IMG/pendu4.png",
    "IMG/pendu3.png",
    "IMG/pendu2.png",
    "IMG/pendu1.png",
    "IMG/pendu0.png"  // 7 erreurs (perdu)
  ];

  /* ---------------------------
     3) Récupération du DOM
     --------------------------- */
  const imgEl = document.getElementById("penduImg");
  const motEl = document.getElementById("motCache");
  const infosEl = document.getElementById("infos");
  const msgEl = document.getElementById("message");

  const formEl = document.getElementById("formLettre");
  const inputEl = document.getElementById("lettre");
  const btnRejouer = document.getElementById("btnRejouer");

  /* ---------------------------
     4) État du jeu
     --------------------------- */
  let motADeviner = "";            // mot choisi au hasard
  let erreurs = 0;                 // compteur d'erreurs (0..7)
  const lettresTrouvees = new Set(); // lettres correctes
  const lettresRatees = new Set();   // lettres incorrectes

  /* ---------------------------
     5) Fonctions utilitaires
     --------------------------- */

  // Choisit un mot au hasard dans wordsArray
  function choisirMot() {
    const index = Math.floor(Math.random() * wordsArray.length);
    return String(wordsArray[index]).trim().toLowerCase();
  }

  // Construit l’affichage du mot avec "_" et lettres trouvées
  function construireMotMasque() {
    let resultat = "";

    for (let i = 0; i < motADeviner.length; i++) {
      const lettre = motADeviner[i];

      // Si la lettre a été trouvée, on l'affiche, sinon "_"
      resultat += lettresTrouvees.has(lettre) ? lettre : "_";
    }

    // Pour le confort visuel : on espace les caractères
    return resultat.split("").join(" ");
  }

  // Met à jour l’image selon le nombre d’erreurs
  function majImage() {
    // On borne au cas où (sécurité)
    const idx = Math.min(Math.max(erreurs, 0), ERREURS_MAX);

    // Si l'image est introuvable, on le log (pratique pour debug)
    imgEl.onerror = () => {
      console.error("Image introuvable :", IMAGES[idx]);
      msgEl.textContent = "Erreur : image introuvable (vérifie le dossier IMG et les noms).";
    };

    imgEl.src = IMAGES[idx];
  }

  // Met à jour toutes les infos affichées
  function render(message = "") {
    motEl.textContent = construireMotMasque();

    const ratees = [...lettresRatees].sort().join(", ");
    infosEl.textContent = `Erreurs : ${erreurs}/${ERREURS_MAX} — Lettres ratées : ${ratees || "∅"}`;

    msgEl.textContent = message;

    majImage();
  }

  // Vérifie si toutes les lettres du mot sont trouvées
  function estGagne() {
    for (let i = 0; i < motADeviner.length; i++) {
      const lettre = motADeviner[i];
      if (!lettresTrouvees.has(lettre)) return false;
    }
    return true;
  }

  // Fin de partie : on bloque la saisie et on montre "Rejouer"
  function finDePartie(message) {
    inputEl.disabled = true;
    formEl.querySelector('button[type="submit"]').disabled = true;
    btnRejouer.style.display = "inline-block";
    render(message);
  }

  // Remise à zéro du jeu
  function reset() {
    motADeviner = choisirMot();
    erreurs = 0;
    lettresTrouvees.clear();
    lettresRatees.clear();

    inputEl.disabled = false;
    formEl.querySelector('button[type="submit"]').disabled = false;
    btnRejouer.style.display = "none";

    inputEl.value = "";
    inputEl.focus();

    render("Bonne chance !");
  }

  /* ---------------------------
     6) Événements (pas de reload)
     --------------------------- */

  formEl.addEventListener("submit", (e) => {
    e.preventDefault(); // ✅ empêche le rechargement de page (cause #1 du “reload”)

    // On récupère la valeur saisie
    const raw = (inputEl.value || "").toLowerCase().trim();
    inputEl.value = ""; // on vide direct le champ
    inputEl.focus();

    // Validation : 1 seule lettre a-z
    if (!/^[a-z]$/.test(raw)) {
      render("Entre une seule lettre (a-z).");
      return;
    }

    // Si déjà tentée
    if (lettresTrouvees.has(raw) || lettresRatees.has(raw)) {
      render("Lettre déjà testée.");
      return;
    }

    // Bonne lettre
    if (motADeviner.includes(raw)) {
      lettresTrouvees.add(raw);

      // Victoire ?
      if (estGagne()) {
        finDePartie(`Bravo ! Le mot était : "${motADeviner}".`);
      } else {
        render("Bien joué !");
      }

      return;
    }

    // Mauvaise lettre
    lettresRatees.add(raw);
    erreurs++;

    // Défaite ?
    if (erreurs >= ERREURS_MAX) {
      finDePartie(`Perdu… Le mot était : "${motADeviner}".`);
      return;
    }

    render("Raté, essaie encore.");
  });

  btnRejouer.addEventListener("click", reset);

  /* ---------------------------
     7) Démarrage
     --------------------------- */
  reset();
})();
