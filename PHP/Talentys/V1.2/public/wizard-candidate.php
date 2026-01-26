<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'candidate') {
  header("Location: login.php");
  exit;
}

// Récup utilisateur (on en aura besoin plus tard)
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
  echo "Utilisateur introuvable.";
  exit;
}

// Étape courante (0 = choix structure, 1–6 = wizard)
$step = isset($_GET['step']) ? (int) $_GET['step'] : 0;
if ($step < 0) {
  $step = 0;
}
if ($step > 6) {
  $step = 6;
}
// Récup diplômes (on commence par le premier)
$diplomaStmt = $pdo->prepare("SELECT * FROM candidate_diplomas WHERE user_id = ? ORDER BY position ASC, id ASC");
$diplomaStmt->execute([$_SESSION['user_id']]);
$diplomas = $diplomaStmt->fetchAll(PDO::FETCH_ASSOC);
$firstDiploma = $diplomas[0] ?? null;

// Récup expériences (on commence par la première)
$expStmt = $pdo->prepare("SELECT * FROM candidate_experiences WHERE user_id = ? ORDER BY position ASC, id ASC");
$expStmt->execute([$_SESSION['user_id']]);
$experiences = $expStmt->fetchAll(PDO::FETCH_ASSOC);
$firstExperience = $experiences[0] ?? null;

// Récup projets (on commence par le premier)
$projStmt = $pdo->prepare("SELECT * FROM candidate_projects WHERE user_id = ? ORDER BY position ASC, id ASC");
$projStmt->execute([$_SESSION['user_id']]);
$projects = $projStmt->fetchAll(PDO::FETCH_ASSOC);
$firstProject = $projects[0] ?? null;


// --- PROFIL CANDIDAT + SAUVEGARDE ÉTAPE 1 ---

// Récup profil candidat s'il existe
$profileStmt = $pdo->prepare("SELECT * FROM candidate_profile WHERE user_id = ?");
$profileStmt->execute([$_SESSION['user_id']]);
$profile = $profileStmt->fetch(PDO::FETCH_ASSOC);



// Traitement du formulaire Étape 1 (profil de base)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 1) {
  $headline = trim($_POST['headline'] ?? '');
  $cityRegion = trim($_POST['city_region'] ?? '');
  $mobility = $_POST['mobility'] ?? null;
  $availabilityType = $_POST['availability_type'] ?? null;
  $availabilityDate = $_POST['availability_date'] ?? null;

  // Si le type de dispo n'est pas "date", on ignore la date
  if ($availabilityType !== 'date') {
    $availabilityDate = null;
  }

  if ($profile) {
    // UPDATE
    $sql = "UPDATE candidate_profile 
                SET headline = :headline,
                    city_region = :city_region,
                    mobility = :mobility,
                    availability_type = :availability_type,
                    availability_date = :availability_date
                WHERE user_id = :user_id";
  } else {
    // INSERT
    $sql = "INSERT INTO candidate_profile 
                (headline, city_region, mobility, availability_type, availability_date, user_id)
                VALUES (:headline, :city_region, :mobility, :availability_type, :availability_date, :user_id)";
  }

  $stmtSave = $pdo->prepare($sql);
  $stmtSave->execute([
    ':headline' => $headline !== '' ? $headline : null,
    ':city_region' => $cityRegion !== '' ? $cityRegion : null,
    ':mobility' => $mobility ?: null,
    ':availability_type' => $availabilityType ?: null,
    ':availability_date' => $availabilityDate ?: null,
    ':user_id' => $_SESSION['user_id'],
  ]);

  // On recharge sur l'étape 2 après sauvegarde
  header('Location: wizard-candidate.php?step=2');
  exit;
}
// Traitement du formulaire Étape 2 (infos clés)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 2) {
  $contactEmail = trim($_POST['contact_email'] ?? '');
  $contactPhone = trim($_POST['contact_phone'] ?? '');
  $contactLinkedin = trim($_POST['contact_linkedin'] ?? '');
  $contactWebsite = trim($_POST['contact_website'] ?? '');
  $miniBio = trim($_POST['mini_bio'] ?? '');
  $skill1 = trim($_POST['skill_1'] ?? '');
  $skill2 = trim($_POST['skill_2'] ?? '');
  $skill3 = trim($_POST['skill_3'] ?? '');
  $videoUrl = trim($_POST['video_url'] ?? '');

  if ($profile) {
    // UPDATE
    $sql = "UPDATE candidate_profile
                SET contact_email    = :contact_email,
                    contact_phone    = :contact_phone,
                    contact_linkedin = :contact_linkedin,
                    contact_website  = :contact_website,
                    mini_bio         = :mini_bio,
                    skill_1          = :skill_1,
                    skill_2          = :skill_2,
                    skill_3          = :skill_3,
                    video_url        = :video_url
                WHERE user_id = :user_id";
  } else {
    // INSERT si jamais le profil n'existe pas encore
    $sql = "INSERT INTO candidate_profile
                (contact_email, contact_phone, contact_linkedin, contact_website,
                 mini_bio, skill_1, skill_2, skill_3, video_url, user_id)
                VALUES
                (:contact_email, :contact_phone, :contact_linkedin, :contact_website,
                 :mini_bio, :skill_1, :skill_2, :skill_3, :video_url, :user_id)";
  }

  $stmtSave2 = $pdo->prepare($sql);
  $stmtSave2->execute([
    ':contact_email' => $contactEmail !== '' ? $contactEmail : null,
    ':contact_phone' => $contactPhone !== '' ? $contactPhone : null,
    ':contact_linkedin' => $contactLinkedin !== '' ? $contactLinkedin : null,
    ':contact_website' => $contactWebsite !== '' ? $contactWebsite : null,
    ':mini_bio' => $miniBio !== '' ? $miniBio : null,
    ':skill_1' => $skill1 !== '' ? $skill1 : null,
    ':skill_2' => $skill2 !== '' ? $skill2 : null,
    ':skill_3' => $skill3 !== '' ? $skill3 : null,
    ':video_url' => $videoUrl !== '' ? $videoUrl : null,
    ':user_id' => $_SESSION['user_id'],
  ]);

  // Redirection vers l'étape 3 après sauvegarde
  header('Location: wizard-candidate.php?step=3');
  exit;
}

// Traitement du formulaire Étape 3 (diplômes – multi-lignes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 3) {
  $diplomasPost = $_POST['diplomas'] ?? [];

  if (!is_array($diplomasPost)) {
    $diplomasPost = [];
  }

  // On supprime tous les anciens diplômes de ce candidat
  $pdo->prepare("DELETE FROM candidate_diplomas WHERE user_id = ?")
    ->execute([$_SESSION['user_id']]);

  // On prépare une seule fois la requête d'insert
  $sql = "INSERT INTO candidate_diplomas
              (user_id, title, school, years, location, note, position)
          VALUES
              (:user_id, :title, :school, :years, :location, :note, :position)";
  $stmtSave3 = $pdo->prepare($sql);

  $position = 1;

  foreach ($diplomasPost as $dipPost) {
    if (!is_array($dipPost)) {
      continue;
    }

    $title = isset($dipPost['title']) ? trim($dipPost['title']) : '';
    $school = isset($dipPost['school']) ? trim($dipPost['school']) : '';
    $years = isset($dipPost['years']) ? trim($dipPost['years']) : '';
    $location = isset($dipPost['location']) ? trim($dipPost['location']) : '';
    $note = isset($dipPost['note']) ? trim($dipPost['note']) : '';

    // On considère qu'il y a un diplôme seulement s'il y a au moins un titre ou une école
    $hasDiploma = ($title !== '' || $school !== '');

    if (!$hasDiploma) {
      continue;
    }

    $stmtSave3->execute([
      ':user_id' => $_SESSION['user_id'],
      ':title' => $title !== '' ? $title : null,
      ':school' => $school !== '' ? $school : null,
      ':years' => $years !== '' ? $years : null,
      ':location' => $location !== '' ? $location : null,
      ':note' => $note !== '' ? $note : null,
      ':position' => $position,
    ]);

    $position++;
  }

  // Redirection vers l'étape 4 après sauvegarde
  header('Location: wizard-candidate.php?step=4');
  exit;
}



// Traitement du formulaire Étape 4 (expériences – multi-lignes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 4) {
  $experiencesPost = $_POST['experiences'] ?? [];

  if (!is_array($experiencesPost)) {
    $experiencesPost = [];
  }

  // On nettoie d'abord toutes les anciennes expériences
  $pdo->prepare("DELETE FROM candidate_experiences WHERE user_id = ?")
    ->execute([$_SESSION['user_id']]);

  // Prépare une seule fois la requête d'insert
  $sql = "INSERT INTO candidate_experiences
              (user_id, title, company, contract_type, start_month, end_month, is_current, summary, position)
          VALUES
              (:user_id, :title, :company, :contract_type, :start_month, :end_month, :is_current, :summary, :position)";
  $stmtSave4 = $pdo->prepare($sql);

  $position = 1;

  foreach ($experiencesPost as $expPost) {
    if (!is_array($expPost)) {
      continue;
    }

    $title = isset($expPost['title']) ? trim($expPost['title']) : '';
    $company = isset($expPost['company']) ? trim($expPost['company']) : '';
    $contractType = isset($expPost['contract_type']) ? trim($expPost['contract_type']) : '';
    $startMonth = isset($expPost['start_date']) ? trim($expPost['start_date']) : '';
    $endMonth = isset($expPost['end_date']) ? trim($expPost['end_date']) : '';
    $isCurrent = !empty($expPost['current']) ? 1 : 0;
    $summary = isset($expPost['summary']) ? trim($expPost['summary']) : '';

    // On considère qu'il y a une expérience seulement s'il y a au moins un titre ou une entreprise
    $hasExperience = ($title !== '' || $company !== '');

    if (!$hasExperience) {
      continue;
    }

    $stmtSave4->execute([
      ':user_id' => $_SESSION['user_id'],
      ':title' => $title !== '' ? $title : null,
      ':company' => $company !== '' ? $company : null,
      ':contract_type' => $contractType !== '' ? $contractType : null,
      ':start_month' => $startMonth !== '' ? $startMonth : null,
      ':end_month' => $endMonth !== '' ? $endMonth : null,
      ':is_current' => $isCurrent,
      ':summary' => $summary !== '' ? $summary : null,
      ':position' => $position,
    ]);

    $position++;
  }

  // Redirection vers l'étape 5 après sauvegarde
  header('Location: wizard-candidate.php?step=5');
  exit;
}

// Traitement du formulaire Étape 5 (réalisations & projets – multi-lignes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 5) {
  $projectsPost = $_POST['projects'] ?? [];

  if (!is_array($projectsPost)) {
    $projectsPost = [];
  }

  // On supprime tous les anciens projets de ce candidat
  $pdo->prepare("DELETE FROM candidate_projects WHERE user_id = ?")
    ->execute([$_SESSION['user_id']]);

  // Prépare une seule fois la requête d'insert
  $sql = "INSERT INTO candidate_projects
              (user_id, title, type, description, link, position)
          VALUES
              (:user_id, :title, :type, :description, :link, :position)";
  $stmtSave5 = $pdo->prepare($sql);

  $position = 1;

  foreach ($projectsPost as $projPost) {
    if (!is_array($projPost)) {
      continue;
    }

    $title = isset($projPost['title']) ? trim($projPost['title']) : '';
    $type = isset($projPost['type']) ? trim($projPost['type']) : '';
    $description = isset($projPost['description']) ? trim($projPost['description']) : '';
    $link = isset($projPost['link']) ? trim($projPost['link']) : '';

    // On considère qu'il y a un projet seulement s'il y a au moins un champ rempli
    $hasProject = ($title !== '' || $type !== '' || $description !== '' || $link !== '');

    if (!$hasProject) {
      continue;
    }

    $stmtSave5->execute([
      ':user_id' => $_SESSION['user_id'],
      ':title' => $title !== '' ? $title : null,
      ':type' => $type !== '' ? $type : null,
      ':description' => $description !== '' ? $description : null,
      ':link' => $link !== '' ? $link : null,
      ':position' => $position,
    ]);

    $position++;
  }

  // Redirection vers l'étape 6
  header('Location: wizard-candidate.php?step=6');
  exit;
}


// Traitement du formulaire Étape 6 (pièces jointes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 6) {
  
  $userId = (int) $_SESSION['user_id'];
  $uploadDir = __DIR__ . '/../uploads/candidate' . $userId . '/';

  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
  }

  // Types de fichiers attendus
  $fileFields = [
    'cv_file' => 'cv',
    'cover_letter_file' => 'cover_letter',
    'portfolio_file' => 'portfolio'
  ];

  foreach ($fileFields as $inputName => $fileType) {
    if (
      isset($_FILES[$inputName]) &&
      $_FILES[$inputName]['error'] === UPLOAD_ERR_OK
    ) {
      $tmpName = $_FILES[$inputName]['tmp_name'];
      $originalName = basename($_FILES[$inputName]['name']);
      $size = (int) $_FILES[$inputName]['size'];
      $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

      $allowedExt = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
      if (!in_array($ext, $allowedExt, true) || $size > 5 * 1024 * 1024) {
        // Log simple si fichier rejeté
        error_log("Upload rejeté ($fileType) : extension ou taille invalide.");
        continue;
      }

      $newFileName = $fileType . '_' . time() . '.' . $ext;
      $targetPath = $uploadDir . $newFileName;

      if (move_uploaded_file($tmpName, $targetPath)) {
        // Fallback si mime_content_type non dispo
        $mimeType = function_exists('mime_content_type')
          ? mime_content_type($targetPath)
          : 'application/octet-stream';

        // Chemin web relatif depuis les pages (desk-candidate.php dans /pages)
        $relativePath = '../uploads/candidates/' . $userId . '/' . $newFileName;

        // Supprime l'ancien fichier de ce type
        $deleteStmt = $pdo->prepare("
          DELETE FROM candidate_files
          WHERE user_id = ? AND type = ?
        ");
        $deleteStmt->execute([$userId, $fileType]);

        // Enregistre le nouveau
        $insertStmt = $pdo->prepare("
          INSERT INTO candidate_files (user_id, type, file_path, original_name, mime_type, size)
          VALUES (?, ?, ?, ?, ?, ?)
        ");
        $insertStmt->execute([
          $userId,
          $fileType,
          $relativePath,
          $originalName,
          $mimeType,
          $size
        ]);

        error_log("Upload OK ($fileType) : " . $relativePath);
      } else {
        error_log("Échec move_uploaded_file pour $fileType");
      }
    } else {
      // Si pas de fichier fourni ou erreur PHP d’upload
      if (!empty($_FILES[$inputName]['error'])) {
        error_log("Erreur upload ($fileType) : code " . $_FILES[$inputName]['error']);
      }
    }
  }

  header('Location: desk-candidate.php?success=1');
  exit;
}



// Config titres / sous-titres
$stepTitles = [
  0 => "Choisis la structure de ton bureau Talentys",
  1 => "Étape 1 sur 6 — Photo & identité",
  2 => "Étape 2 sur 6 — Infos clés",
  3 => "Étape 3 sur 6 — Diplômes & formations",
  4 => "Étape 4 sur 6 — Expériences",
  5 => "Étape 5 sur 6 — Réalisations & projets",
  6 => "Étape 6 sur 6 — Dossier & pièces jointes",
];

$stepSubtitles = [
  0 => "Tu pourras changer de structure plus tard, rien n’est définitif.",
  1 => "On commence par ta carte de visite Talentys.",
  2 => "Ces informations apparaîtront en haut de ton bureau.",
  3 => "Ajoute les diplômes que tu veux afficher sur ton bureau.",
  4 => "Ajoute jusqu’à 3 expériences récentes ou importantes.",
  5 => "Ajoute jusqu’à 3 projets qui montrent ce que tu sais faire.",
  6 => "Ajoute ton CV et les documents que tu veux partager.",
];

// Progression (approximative pour l’instant)
$progressPercent = [
  0 => 0,
  1 => 15,
  2 => 30,
  3 => 45,
  4 => 60,
  5 => 80,
  6 => 100,
][$step];
?>

<?php include_once('../partials/header.php'); ?>

<main>
  <section class="form-section appear">
    <div class="form-card">

      <!-- Header wizard : titre + lien quitter -->
      <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:16px;">
        <div>
          <h2 style="margin-bottom:6px;">
            <?= htmlspecialchars($stepTitles[$step]) ?>
          </h2>
          <p style="margin:0; opacity:0.85;">
            <?= htmlspecialchars($stepSubtitles[$step]) ?>
          </p>
        </div>

        <div>
          <a href="dashboard-candidate.php" class="btn btn-text">
            Quitter et reprendre plus tard
          </a>
        </div>
      </div>

      <!-- Barre de progression -->
      <?php if ($step > 0): ?>
        <div style="margin-bottom:16px;">
          <div style="display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:4px;">
            <span>Progression</span>
            <span><?= $progressPercent ?>%</span>
          </div>
          <div style="width:100%; height:6px; background:rgba(255,255,255,0.1); border-radius:999px; overflow:hidden;">
            <div style="width:<?= $progressPercent ?>%; height:100%; background:#39c2ff;"></div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Stepper 1–6 -->
      <ol
        style="display:flex; gap:8px; flex-wrap:wrap; list-style:none; padding:0; margin:0 0 20px 0; font-size:0.85rem;">
        <?php
        $labels = [
          1 => 'Identité',
          2 => 'Infos clés',
          3 => 'Diplômes',
          4 => 'Expériences',
          5 => 'Réalisations',
          6 => 'Dossier',
        ];
        foreach ($labels as $num => $label):
          $class = '';
          if ($step === 0) {
            $class = 'wizard-step-disabled';
          } elseif ($num < $step) {
            $class = 'wizard-step-done';
          } elseif ($num === $step) {
            $class = 'wizard-step-active';
          } else {
            $class = 'wizard-step-disabled';
          }
          ?>
          <li class="<?= $class ?>">
            <span><?= $num ?>. <?= htmlspecialchars($label) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>

      <!-- Contenu de l’étape -->
      <div class="wizard-step-content" style="margin-bottom:24px;">
        <?php if ($step === 0): ?>
          <!-- Étape 0 : choix de structure -->
          <p style="margin-bottom:16px;">
            Choisis un modèle de bureau. Tu pourras en changer plus tard.
          </p>

          <div class="wizard-presets" style="display:grid; gap:16px;">
            <div class="wizard-preset-card">
              <h3>Essentiel</h3>
              <p>Pour aller à l’essentiel rapidement.</p>
              <ul>
                <li>👤 Photo & identité</li>
                <li>💼 Expériences</li>
                <li>📂 Dossier & contact</li>
              </ul>
            </div>

            <div class="wizard-preset-card wizard-preset-active">
              <div style="font-size:0.75rem; opacity:0.8; margin-bottom:4px;">Recommandé</div>
              <h3>Standard</h3>
              <p>La version complète de ton bureau.</p>
              <ul>
                <li>👤 Photo &amp; identité</li>
                <li>ℹ️ Infos clés</li>
                <li>🎓 Diplômes</li>
                <li>💼 Expériences</li>
                <li>🏆 Réalisations</li>
                <li>📂 Dossier &amp; pièces jointes</li>
              </ul>
            </div>

            <div class="wizard-preset-card">
              <h3>Avancé</h3>
              <p>Plus de sections, plus de détails.</p>
              <ul>
                <li>Tout le contenu Standard</li>
                <li>+ Soft skills</li>
                <li>+ Projets personnels</li>
              </ul>
            </div>
          </div>

        <?php elseif ($step === 1): ?>
          <!-- Étape 1 : Photo & identité -->
          <form id="wizard-step1-form" class="wizard-form" method="post" action="wizard-candidate.php?step=1"
            enctype="multipart/form-data">

            <!-- Bloc photo (placeholder pour l’instant) -->
            <section style="margin-bottom: 20px;">
              <h3 style="margin-bottom: 8px;">Photo de profil</h3>
              <p style="margin-top: 0; margin-bottom: 10px; opacity: 0.8;">
                Une photo nette et cadrée visage. Tu pourras la changer plus tard.
              </p>

              <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                <div
                  style="width:72px; height:72px; border-radius:50%; background:rgba(255,255,255,0.06); display:flex; align-items:center; justify-content:center; font-size:1.4rem;">
                  🙂
                </div>
                <div>
                  <label class="btn btn-outline">
                    Importer une photo
                    <input type="file" name="photo" accept="image/*" style="display:none;">
                  </label>
                  <p style="margin:6px 0 0 0; font-size:0.8rem; opacity:0.75;">
                    Format carré recommandé, max 2 Mo.
                  </p>
                </div>
              </div>
            </section>

            <!-- Bloc identité -->
            <section style="margin-bottom: 20px;">
              <h3 style="margin-bottom: 8px;">Identité</h3>

              <div style="display:flex; flex-direction:column; gap:10px;">
                <div>
                  <label for="first_name">Prénom</label>
                  <input id="first_name" name="first_name" type="text" class="input" placeholder="ex : Diego"
                    value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
                </div>

                <div>
                  <label for="last_name">Nom</label>
                  <input id="last_name" name="last_name" type="text" class="input" placeholder="ex : Riello"
                    value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
                </div>

                <div>
                  <label for="headline">Titre affiché sur le bureau</label>
                  <input id="headline" name="headline" type="text" class="input"
                    placeholder="ex : Développeur web & web mobile"
                    value="<?= htmlspecialchars($profile['headline'] ?? '') ?>">
                  <p style="margin:4px 0 0 0; font-size:0.8rem; opacity:0.75%;">
                    Ce titre s’affichera sous ton nom sur le bureau.
                  </p>
                </div>
              </div>
            </section>

            <!-- Bloc localisation & mobilité -->
            <section style="margin-bottom: 20px;">
              <h3 style="margin-bottom: 8px;">Localisation & mobilité</h3>

              <div style="display:flex; flex-direction:column; gap:10px;">
                <div>
                  <label for="city_region">Ville / région</label>
                  <input id="city_region" name="city_region" type="text" class="input"
                    placeholder="ex : Béziers, Occitanie"
                    value="<?= htmlspecialchars($profile['city_region'] ?? ($user['city'] ?? '')) ?>">
                </div>

                <div>
                  <label for="mobility">Mobilité</label>
                  <select id="mobility" name="mobility" class="input">
                    <option value="">Sélectionner…</option>
                    <option value="locale" <?= isset($profile['mobility']) && $profile['mobility'] === 'locale' ? 'selected' : '' ?>>Locale</option>
                    <option value="regionale" <?= isset($profile['mobility']) && $profile['mobility'] === 'regionale' ? 'selected' : '' ?>>Régionale</option>
                    <option value="nationale" <?= isset($profile['mobility']) && $profile['mobility'] === 'nationale' ? 'selected' : '' ?>>Nationale</option>
                    <option value="internationale" <?= isset($profile['mobility']) && $profile['mobility'] === 'internationale' ? 'selected' : '' ?>>Internationale</option>
                  </select>
                </div>
              </div>
            </section>

            <!-- Bloc disponibilité -->
            <section>
              <h3 style="margin-bottom: 8px;">Disponibilité</h3>

              <div style="display:flex; flex-direction:column; gap:10px;">
                <div>
                  <label for="availability_type">Type de disponibilité</label>
                  <select id="availability_type" name="availability_type" class="input">
                    <option value="">Sélectionner…</option>
                    <option value="immediate" <?= isset($profile['availability_type']) && $profile['availability_type'] === 'immediate' ? 'selected' : '' ?>>Immédiate</option>
                    <option value="date" <?= isset($profile['availability_type']) && $profile['availability_type'] === 'date' ? 'selected' : '' ?>>À partir du…</option>
                    <option value="stage" <?= isset($profile['availability_type']) && $profile['availability_type'] === 'stage' ? 'selected' : '' ?>>Stage</option>
                    <option value="alternance" <?= isset($profile['availability_type']) && $profile['availability_type'] === 'alternance' ? 'selected' : '' ?>>Alternance</option>
                    <option value="autre" <?= isset($profile['availability_type']) && $profile['availability_type'] === 'autre' ? 'selected' : '' ?>>Autre</option>
                  </select>
                </div>

                <div>
                  <label for="availability_date">Date de disponibilité (si applicable)</label>
                  <input id="availability_date" name="availability_date" type="date" class="input"
                    value="<?= htmlspecialchars($profile['availability_date'] ?? '') ?>">
                </div>

                <p style="margin:4px 0 0 0; font-size:0.8rem; opacity:0.75;">
                  Ces informations seront visibles par les recruteurs sur ton bureau.
                </p>
              </div>
            </section>

          </form>

        <?php elseif ($step === 2): ?>
          <!-- Étape 2 : Infos clés -->
          <form id="wizard-step2-form" class="wizard-form" method="post" action="wizard-candidate.php?step=2">
            <input id="contact_email" name="contact_email" type="email" class="input"
              placeholder="ex : prenom.nom@email.com"
              value="<?= htmlspecialchars($profile['contact_email'] ?? ($user['email'] ?? '')) ?>">

            <input id="contact_phone" name="contact_phone" type="text" class="input" placeholder="ex : 06 12 34 56 78"
              value="<?= htmlspecialchars($profile['contact_phone'] ?? '') ?>">

            <input id="contact_linkedin" name="contact_linkedin" type="url" class="input"
              placeholder="ex : https://www.linkedin.com/in/…"
              value="<?= htmlspecialchars($profile['contact_linkedin'] ?? '') ?>">

            <input id="contact_website" name="contact_website" type="url" class="input"
              placeholder="ex : https://monportfolio.dev"
              value="<?= htmlspecialchars($profile['contact_website'] ?? '') ?>">

            <textarea id="mini_bio" name="mini_bio" class="input" rows="4"
              placeholder="ex : Après 20 ans dans la restauration, je me reconvertis dans le développement web…"><?= htmlspecialchars($profile['mini_bio'] ?? '') ?></textarea>
            <input id="skill_1" name="skill_1" type="text" class="input" placeholder="ex : PHP"
              value="<?= htmlspecialchars($profile['skill_1'] ?? '') ?>">

            <input id="skill_2" name="skill_2" type="text" class="input" placeholder="ex : JavaScript"
              value="<?= htmlspecialchars($profile['skill_2'] ?? '') ?>">

            <input id="skill_3" name="skill_3" type="text" class="input" placeholder="ex : Gestion de projet"
              value="<?= htmlspecialchars($profile['skill_3'] ?? '') ?>">
            <input id="video_url" name="video_url" type="url" class="input" placeholder="ex : https://youtu.be/..."
              value="<?= htmlspecialchars($profile['video_url'] ?? '') ?>">


          </form>

        <?php elseif ($step === 3): ?>
          <!-- Étape 3 : Diplômes & formations (jusqu'à 3) -->
          <form id="wizard-step3-form" class="wizard-form" method="post" action="wizard-candidate.php?step=3">
            <section style="margin-bottom: 16px;">
              <h3 style="margin-bottom: 8px;">Diplômes &amp; formations</h3>
              <p style="margin-top: 0; margin-bottom: 10px; opacity: 0.8;">
                Ajoute jusqu’à 3 diplômes ou formations que tu veux mettre en avant.
              </p>
            </section>

            <?php
            for ($i = 0; $i < 3; $i++):
              $dip = $diplomas[$i] ?? null;
              ?>
              <section class="diploma-card"
                style="padding:14px 16px; border-radius:10px; background:rgba(255,255,255,0.03); margin-bottom: 12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                  <h3 style="margin:0; font-size:0.95rem;">
                    Diplôme / formation n°<?= $i + 1 ?>
                  </h3>
                  <span style="font-size:0.8rem; opacity:0.7;">
                    Optionnel
                  </span>
                </div>

                <div style="display:flex; flex-direction:column; gap:10px;">

                  <div>
                    <label for="diplomas_<?= $i ?>_title">Intitulé du diplôme / formation</label>
                    <input id="diplomas_<?= $i ?>_title" name="diplomas[<?= $i ?>][title]" type="text" class="input"
                      placeholder="ex : Titre Pro Développeur Web &amp; Web Mobile"
                      value="<?= htmlspecialchars($dip['title'] ?? '') ?>">
                  </div>

                  <div>
                    <label for="diplomas_<?= $i ?>_school">Établissement / organisme</label>
                    <input id="diplomas_<?= $i ?>_school" name="diplomas[<?= $i ?>][school]" type="text" class="input"
                      placeholder="ex : BeWeb – École Régionale du Numérique"
                      value="<?= htmlspecialchars($dip['school'] ?? '') ?>">
                  </div>

                  <div>
                    <label for="diplomas_<?= $i ?>_years">Année(s)</label>
                    <input id="diplomas_<?= $i ?>_years" name="diplomas[<?= $i ?>][years]" type="text" class="input"
                      placeholder="ex : 2025–2026" value="<?= htmlspecialchars($dip['years'] ?? '') ?>">
                  </div>

                  <div>
                    <label for="diplomas_<?= $i ?>_location">Lieu</label>
                    <input id="diplomas_<?= $i ?>_location" name="diplomas[<?= $i ?>][location]" type="text" class="input"
                      placeholder="ex : Béziers, Occitanie" value="<?= htmlspecialchars($dip['location'] ?? '') ?>">
                  </div>

                  <div>
                    <label for="diplomas_<?= $i ?>_note">Note / contexte</label>
                    <textarea id="diplomas_<?= $i ?>_note" name="diplomas[<?= $i ?>][note]" class="input" rows="2"
                      placeholder="ex : Reconversion vers les métiers du numérique."><?= htmlspecialchars($dip['note'] ?? '') ?></textarea>
                  </div>

                </div>
              </section>
            <?php endfor; ?>

          </form>

        <?php elseif ($step === 4): ?>
          <!-- Étape 4 : Expériences (jusqu'à 3) -->
          <form id="wizard-step4-form" class="wizard-form" method="post" action="wizard-candidate.php?step=4">
            <section style="margin-bottom: 16px;">
              <h3 style="margin-bottom: 8px;">Expériences</h3>
              <p style="margin-top: 0; margin-bottom: 10px; opacity: 0.8;">
                Ajoute jusqu’à 3 expériences récentes ou importantes.
              </p>
            </section>

            <?php
            // On prépare jusqu'à 3 lignes
            for ($i = 0; $i < 3; $i++):
              $exp = $experiences[$i] ?? null;
              ?>
              <section class="experience-card"
                style="padding:14px 16px; border-radius:10px; background:rgba(255,255,255,0.03); margin-bottom: 12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                  <h3 style="margin:0; font-size:0.95rem;">
                    Expérience n°<?= $i + 1 ?>
                  </h3>
                  <span style="font-size:0.8rem; opacity:0.7;">
                    Optionnelle
                  </span>
                </div>

                <div style="display:flex; flex-direction:column; gap:10px;">

                  <div>
                    <label for="experiences_<?= $i ?>_title">Intitulé du poste</label>
                    <input id="experiences_<?= $i ?>_title" name="experiences[<?= $i ?>][title]" type="text" class="input"
                      placeholder="ex : Manager de magasin" value="<?= htmlspecialchars($exp['title'] ?? '') ?>">
                  </div>

                  <div>
                    <label for="experiences_<?= $i ?>_company">Entreprise</label>
                    <input id="experiences_<?= $i ?>_company" name="experiences[<?= $i ?>][company]" type="text"
                      class="input" placeholder="ex : Lidl" value="<?= htmlspecialchars($exp['company'] ?? '') ?>">
                  </div>

                  <div>
                    <label for="experiences_<?= $i ?>_contract_type">Type de contrat</label>
                    <select id="experiences_<?= $i ?>_contract_type" name="experiences[<?= $i ?>][contract_type]"
                      class="input">
                      <?php $ct = $exp['contract_type'] ?? ''; ?>
                      <option value="">Sélectionner…</option>
                      <option value="cdi" <?= $ct === 'cdi' ? 'selected' : '' ?>>CDI</option>
                      <option value="cdd" <?= $ct === 'cdd' ? 'selected' : '' ?>>CDD</option>
                      <option value="stage" <?= $ct === 'stage' ? 'selected' : '' ?>>Stage</option>
                      <option value="alternance" <?= $ct === 'alternance' ? 'selected' : '' ?>>Alternance</option>
                      <option value="freelance" <?= $ct === 'freelance' ? 'selected' : '' ?>>Freelance</option>
                      <option value="autre" <?= $ct === 'autre' ? 'selected' : '' ?>>Autre</option>
                    </select>
                  </div>

                  <div style="display:flex; flex-wrap:wrap; gap:10px;">
                    <div style="flex:1; min-width:120px;">
                      <label for="experiences_<?= $i ?>_start">Début</label>
                      <input id="experiences_<?= $i ?>_start" name="experiences[<?= $i ?>][start_date]" type="month"
                        class="input" value="<?= htmlspecialchars($exp['start_month'] ?? '') ?>">
                    </div>

                    <div style="flex:1; min-width:120px;">
                      <label for="experiences_<?= $i ?>_end">Fin</label>
                      <input id="experiences_<?= $i ?>_end" name="experiences[<?= $i ?>][end_date]" type="month"
                        class="input" value="<?= htmlspecialchars($exp['end_month'] ?? '') ?>">
                    </div>
                  </div>

                  <div>
                    <label style="display:flex; align-items:center; gap:6px; font-size:0.9rem;">
                      <input id="experiences_<?= $i ?>_current" name="experiences[<?= $i ?>][current]" type="checkbox"
                        value="1" <?= !empty($exp['is_current']) ? 'checked' : '' ?>>
                      Poste actuel
                    </label>
                  </div>

                  <div>
                    <label for="experiences_<?= $i ?>_summary">Résumé</label>
                    <textarea id="experiences_<?= $i ?>_summary" name="experiences[<?= $i ?>][summary]" class="input"
                      rows="3"
                      placeholder="ex : Gestion d’équipe, indicateurs, organisation opérationnelle du magasin…"><?= htmlspecialchars($exp['summary'] ?? '') ?></textarea>
                  </div>

                </div>
              </section>
            <?php endfor; ?>

          </form>



        <?php elseif ($step === 5): ?>
          <!-- Étape 5 : Réalisations & projets (jusqu'à 3) -->
          <form id="wizard-step5-form" class="wizard-form" method="post" action="wizard-candidate.php?step=5">

            <section style="margin-bottom: 16px;">
              <h3 style="margin-bottom: 8px;">Réalisations &amp; projets</h3>
              <p style="margin-top: 0; margin-bottom: 10px; opacity: 0.8;">
                Ajoute jusqu’à 3 projets qui montrent ce que tu sais faire.
              </p>
              <p style="margin:6px 0 0 0; font-size:0.8rem; opacity:0.75;">
                Concentre-toi sur tes projets les plus parlants (pro, formation, perso, freelance…).
              </p>
            </section>

            <?php
            for ($i = 0; $i < 3; $i++):
              $proj = $projects[$i] ?? null;
              ?>
              <section class="project-card"
                style="padding:14px 16px; border-radius:10px; background:rgba(255,255,255,0.03); margin-bottom: 12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                  <h3 style="margin:0; font-size:0.95rem;">
                    Projet n°<?= $i + 1 ?>
                  </h3>
                  <span style="font-size:0.8rem; opacity:0.7;">
                    Optionnel
                  </span>
                </div>

                <div style="display:flex; flex-direction:column; gap:10px;">

                  <div>
                    <label for="projects_<?= $i ?>_title">Titre du projet</label>
                    <input id="projects_<?= $i ?>_title" name="projects[<?= $i ?>][title]" type="text" class="input"
                      placeholder="ex : Escape Game Apéro Béziers" value="<?= htmlspecialchars($proj['title'] ?? '') ?>">
                  </div>

                  <div>
                    <label for="projects_<?= $i ?>_type">Type de projet</label>
                    <select id="projects_<?= $i ?>_type" name="projects[<?= $i ?>][type]" class="input">
                      <?php $pt = $proj['type'] ?? ''; ?>
                      <option value="">Sélectionner…</option>
                      <option value="pro" <?= $pt === 'pro' ? 'selected' : '' ?>>Professionnel</option>
                      <option value="formation" <?= $pt === 'formation' ? 'selected' : '' ?>>Formation / scolaire</option>
                      <option value="perso" <?= $pt === 'perso' ? 'selected' : '' ?>>Personnel</option>
                      <option value="freelance" <?= $pt === 'freelance' ? 'selected' : '' ?>>Freelance</option>
                      <option value="autre" <?= $pt === 'autre' ? 'selected' : '' ?>>Autre</option>
                    </select>
                  </div>

                  <div>
                    <label for="projects_<?= $i ?>_description">Description courte</label>
                    <textarea id="projects_<?= $i ?>_description" name="projects[<?= $i ?>][description]" class="input"
                      rows="3"
                      placeholder="Contexte, ton rôle, ce que ce projet montre de toi…"><?= htmlspecialchars($proj['description'] ?? '') ?></textarea>
                  </div>

                  <div>
                    <label for="projects_<?= $i ?>_link">Lien vers le projet</label>
                    <input id="projects_<?= $i ?>_link" name="projects[<?= $i ?>][link]" type="url" class="input"
                      placeholder="ex : https://monprojet.dev ou GitHub / vidéo / PDF"
                      value="<?= htmlspecialchars($proj['link'] ?? '') ?>">
                  </div>

                </div>
              </section>
            <?php endfor; ?>

          </form>


        <?php elseif ($step === 6): ?>
          <!-- Étape 6 : Dossier & pièces jointes -->
          <form id="wizard-step6-form" class="wizard-form" method="post" action="wizard-candidate.php?step=6"
            enctype="multipart/form-data">
            <div class="form-group">
              <label for="cv_file">CV principal (PDF/DOC, max 5 Mo)</label>
              <input type="file" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx">
            </div>

            <div class="form-group">
              <label for="cover_letter_file">Lettre de motivation</label>
              <input type="file" name="cover_letter_file" id="cover_letter_file" accept=".pdf,.doc,.docx">
            </div>

            <div class="form-group">
              <label for="portfolio_file">Portfolio / autres documents (PDF / images)</label>
              <input type="file" name="portfolio_file" id="portfolio_file" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary">
                Enregistrer mes documents
              </button>
            </div>

          </form>
        <?php endif; ?>







        <!-- Navigation bas de page -->
        <div style="display:flex; justify-content:space-between; gap:12px;">
          <div>
            <?php if ($step > 0): ?>
              <a href="wizard-candidate.php?step=<?= $step - 1 ?>" class="btn btn-outline">
                ← Précédent
              </a>
            <?php endif; ?>
          </div>

          <div>
            <?php if ($step === 1): ?>
              <button type="submit" form="wizard-step1-form" class="btn btn-primary">
                Continuer →
              </button>
            <?php elseif ($step === 2): ?>
              <button type="submit" form="wizard-step2-form" class="btn btn-primary">
                Continuer →
              </button>
            <?php elseif ($step === 3): ?>
              <button type="submit" form="wizard-step3-form" class="btn btn-primary">
                Continuer →
              </button>
            <?php elseif ($step === 4): ?>
              <!-- Étape 4 : submit formulaire 4 -->
              <button type="submit" form="wizard-step4-form" class="btn btn-primary">
                Continuer →
              </button>
            <?php elseif ($step === 5): ?>
              <!-- Étape 5 : submit formulaire 5 -->
              <button type="submit" form="wizard-step5-form" class="btn btn-primary">
                Continuer →
              </button>

            <?php elseif ($step === 6): ?>
              <button type="submit" form="wizard-step6-form" class="btn btn-primary">
                Terminer et voir mon bureau
              </button>


            <?php else: ?>
              <a href="wizard-candidate.php?step=1" class="btn btn-primary">
                Commencer →
              </a>
            <?php endif; ?>

          </div>


        </div>

      </div>

    </div>
  </section>
</main>

<?php include_once('../partials/footer.php'); ?>