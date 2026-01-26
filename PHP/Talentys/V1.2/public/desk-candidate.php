<?php
session_start();
require_once '../config/db.php';

$viewerId = (int) ($_SESSION['user_id'] ?? 0);
$viewerRole = (string) ($_SESSION['user_role'] ?? '');

if ($viewerId <= 0 || !in_array($viewerRole, ['candidate', 'recruiter'], true)) {
    header("Location: login.php");
    exit;
}

$isRecruiterView = ($viewerRole === 'recruiter');

$targetUserId = $isRecruiterView
    ? (int) ($_GET['user_id'] ?? 0)
    : $viewerId;

if ($isRecruiterView && $targetUserId <= 0) {
    http_response_code(400);
    echo "Paramètre user_id manquant.";
    exit;
}

// Récupération données utilisateur (candidat ciblé)
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$targetUserId]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur introuvable.";
    exit;
}

// Profil candidat
$profileStmt = $pdo->prepare("SELECT * FROM candidate_profile WHERE user_id = ?");
$profileStmt->execute([$targetUserId]);
$profile = $profileStmt->fetch(PDO::FETCH_ASSOC);

// Diplômes candidat
$diplomaStmt = $pdo->prepare("SELECT * FROM candidate_diplomas WHERE user_id = ? ORDER BY position ASC, id ASC");
$diplomaStmt->execute([$targetUserId]);
$diplomas = $diplomaStmt->fetchAll(PDO::FETCH_ASSOC);

// Expériences candidat
$expStmt = $pdo->prepare("SELECT * FROM candidate_experiences WHERE user_id = ? ORDER BY position ASC, id ASC");
$expStmt->execute([$targetUserId]);
$experiences = $expStmt->fetchAll(PDO::FETCH_ASSOC);

// Projets candidat
$projStmt = $pdo->prepare("SELECT * FROM candidate_projects WHERE user_id = ? ORDER BY position ASC, id ASC");
$projStmt->execute([$targetUserId]);
$projects = $projStmt->fetchAll(PDO::FETCH_ASSOC);

// Fichiers candidat
$userId = $targetUserId;

$fileStmt = $pdo->prepare("
  SELECT type, original_name, file_path
  FROM candidate_files
  WHERE user_id = ?
");
$fileStmt->execute([$userId]);

$candidateFiles = $fileStmt->fetchAll(PDO::FETCH_ASSOC);
$filesByType = [];

foreach ($candidateFiles as $file) {
    $filesByType[$file['type']] = $file;
}
?>



<?php include_once('../partials/header.php'); ?>

<style>
    /* === Bureau Talentys candidat === */

    .desk-page {
        min-height: calc(100vh - 80px);
        padding: 16px;
        background: #050811;
        color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .desk-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
        background: #0b0f17;
    }

    .desk-background {
        position: absolute;
        inset: 0;
        background: url("./bureau.png") center/cover no-repeat;
        filter: brightness(0.95);
    }

    /* Barre du haut : retour + actions */
    .desk-top-bar {
        position: absolute;
        inset-inline: 0;
        top: 10px;
        padding: 0 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 20;
        pointer-events: none;
    }

    .desk-top-left,
    .desk-top-right {
        display: flex;
        align-items: center;
        gap: 8px;
        pointer-events: auto;
    }

    .desk-badge-preview {
        font-size: 0.95rem;
        padding: 4px 8px;
        border-radius: 999px;
        background: rgba(0, 200, 255, 0.18);
        border: 1px solid rgba(0, 200, 255, 0.4);
    }

    .btn-ghost-small {
        border: none;
        border-radius: 999px;
        padding: 6px 12px;
        background: rgba(0, 0, 0, 0.55);
        color: #f5f5f5;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-ghost-small:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    /* Zones cliquables sur le bureau */
    .desk-hotspots {
        position: absolute;
        inset: 0;
        z-index: 10;
    }

    .desk-zone {
        position: absolute;
        padding: 6px 10px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(4px);
        color: #f5f5f5;
        font-size: 0.8rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
    }

    .desk-zone:hover {
        transform: translateY(-1px) scale(1.02);
        background: rgba(0, 0, 0, 0.55);
        box-shadow: 0 0 14px rgba(0, 200, 255, 0.5);
    }

    /* Positions approximatives (à ajuster selon ton image) */
    .zone-identite {
        top: 25%;
        left: 44%;
        font-size: 1.2rem;

    }

    .zone-infos {
        bottom: 46%;
        left: 50%;
        font-size: 1.2rem;

    }

    .zone-diplomes {
        bottom: 25%;
        left: 33%;
        font-size: 1.2rem;

    }

    .zone-experiences {
        bottom: 25%;
        right: 27%;
        font-size: 1.2rem;
    }

    .zone-realisations {
        top: 39%;
        right: 10%;
        font-size: 1.2rem;
    }

    .zone-dossier {
        bottom: 42%;
        right: 14%;
        font-size: 1.2rem;
    }

    /* Overlay foncé derrière le panneau */
    .talentys-panel-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease;
        z-index: 900;
    }

    /* Panneau bas sombre */
    .talentys-panel {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        max-height: 70vh;
        background: #0e1218;
        color: #f5f5f5;
        border-radius: 16px 16px 0 0;
        box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.6);
        transform: translateY(100%);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
        z-index: 910;
        display: flex;
        flex-direction: column;
    }

    .talentys-panel.is-visible {
        transform: translateY(0);
        opacity: 1;
    }

    .talentys-panel-overlay.is-visible {
        opacity: 1;
        visibility: visible;
    }

    .talentys-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .talentys-panel-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
    }

    .talentys-panel-close {
        background: none;
        border: none;
        color: #f5f5f5;
        font-size: 1.1rem;
        cursor: pointer;
    }

    .talentys-panel-body {
        padding: 14px 18px;
        overflow-y: auto;
        flex: 1;
        font-size: 0.95rem;
    }

    .talentys-panel-footer {
        padding: 10px 18px 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    @media (max-width: 768px) {
        .desk-wrapper {
            max-width: 100%;
            aspect-ratio: 9 / 16;
        }

        .talentys-panel {
            max-height: 80vh;
        }
    }

    /* Couche globale entretien (par-dessus le bureau) */
    #interview-layer {
        position: fixed;
        inset: 0;
        pointer-events: none;
        /* les clics seront activés seulement sur ce qu'on veut */
        z-index: 1000;
    }

    /* Masque complet du mode entretien tant qu'il n'est pas actif */
    .interview-hidden {
        display: none;
    }

    /* Overlay assombrissant */
    #interview-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.18);
    }

    /* Visio principale en mode Face-à-face */
    #interview-video-main {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 70vw;
        max-width: 960px;
        aspect-ratio: 16 / 9;
        transform: translate(-50%, -50%);
        border-radius: 14px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        pointer-events: auto;
    }

    #interview-remote-video,
    #interview-self-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Self-view en petit, par-dessus la visio principale */
    #interview-self-video.interview-self-view {
        position: absolute;
        width: 120px;
        height: 68px;
        bottom: 12px;
        right: 12px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    /* Barre de contrôle */
    #interview-controls {
        position: absolute;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(8px);
        pointer-events: auto;
    }

    .interview-btn {
        width: 40px;
        height: 40px;
        border-radius: 999px;
        border: none;
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 18px;
        cursor: pointer;
    }

    .interview-btn:hover {
        transform: scale(1.06);
    }

    /* === Mode exploration : visio flottante === */
    body.interview-exploration #interview-overlay {
        display: none;
        /* plus d'assombrissement du bureau */
    }

    body.interview-exploration #interview-video-main {
        top: 16px;
        right: 16px;
        left: auto;
        bottom: auto;
        width: 220px;
        max-width: none;
        aspect-ratio: 16 / 9;
        transform: none;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.45);
    }

    /* Bureau verrouillé en mode Face-à-face */
    body.interview-locked .desk-zone {
        pointer-events: none;
        opacity: 0.45;
        /* optionnel, pour montrer que c’est verrouillé */
    }
</style>

<main>
    <section class="desk-page appear">
        <div class="desk-wrapper">
            <div class="desk-background"></div>

            <!-- Barre du haut -->
            <div class="desk-top-left">
                <?php if ($isRecruiterView): ?>
                    <a href="../recruiter/search.php" class="btn-ghost-small">← Retour à la recherche</a>
                <?php else: ?>
                    <a href="dashboard-candidate.php" class="btn-ghost-small">← Retour au dashboard</a>
                <?php endif; ?>
            </div>

            <div class="desk-top-right">
                <span class="desk-badge-preview" id="preview-badge"
                    style="<?= $isRecruiterView ? 'display:inline-flex;' : 'display:none;' ?>">
                    <?= $isRecruiterView ? 'Vue recruteur' : 'Mode prévisualisation recruteur' ?>
                </span>

                <?php if (!$isRecruiterView): ?>
                    <a href="wizard-candidate.php?step=1" class="btn-ghost-small">✏️ Modifier mon bureau</a>
                    <button type="button" class="btn-ghost-small" id="preview-toggle">👁️ Prévisualiser comme
                        recruteur</button>
                    <button type="button" class="btn-ghost-small" id="interview-test-toggle">🎥 Mode entretien
                        (test)</button>
                <?php endif; ?>
            </div>


            <!-- Zones cliquables -->
            <div class="desk-hotspots">
                <button type="button" class="desk-zone zone-identite" data-panel-title="Profil & identité"
                    data-panel-template="profil"
                    data-panel-body="Ici s’afficheront ton nom, ton titre, ta ville, ta mobilité et ta disponibilité.">
                    👤 Profil &amp; identité
                </button>


                <button type="button" class="desk-zone zone-infos" data-panel-title="Infos clés"
                    data-panel-template="infos"
                    data-panel-body="Email, téléphone, LinkedIn, site perso, mini bio et compétences clés viendront ici.">
                    ℹ️ Infos clés
                </button>


                <button type="button" class="desk-zone zone-diplomes" data-panel-title="Diplômes & formations"
                    data-panel-template="diplomes"
                    data-panel-body="Tes principaux diplômes et formations seront affichés dans cette section.">
                    🎓 Diplômes
                </button>


                <button type="button" class="desk-zone zone-experiences" data-panel-title="Expériences"
                    data-panel-template="experiences"
                    data-panel-body="Tes expériences récentes ou importantes seront listées ici.">
                    💼 Expériences
                </button>


                <button type="button" class="desk-zone zone-realisations" data-panel-title="Réalisations & projets"
                    data-panel-template="realisations"
                    data-panel-body="Tes projets clés (pro, formation, perso) apparaîtront dans cette zone.">
                    🏆 Réalisations
                </button>
                <?php
                function file_public_url(string $path): string
                {
                    // ../uploads/candidates/1/cv_xxx.pdf  ->  /uploads/candidates/1/cv_xxx.pdf
                    $clean = str_replace('..', '', $path);
                    $clean = '/' . ltrim($clean, '/');
                    return BASE_URL . $clean;
                }
                ?>

                <button type="button" class="desk-zone zone-dossier" data-panel-title="Dossier & pièces jointes"
                    data-panel-body="<?=
                        htmlspecialchars(
                            (isset($filesByType['cv'])
                                ? '📄 <a href="' . file_public_url($filesByType['cv']['file_path']) . '" target=_blank>' . $filesByType['cv']['original_name'] . '</a><br>'
                                : '📄 CV : aucun<br>'
                            )
                            .
                            (isset($filesByType['cover_letter'])
                                ? '✉️ <a href="' . file_public_url($filesByType['cover_letter']['file_path']) . '" target=_blank>' . $filesByType['cover_letter']['original_name'] . '</a><br>'
                                : '✉️ Lettre : aucune<br>'
                            )
                            .
                            (isset($filesByType['portfolio'])
                                ? '🖼️ <a href="' . file_public_url($filesByType['portfolio']['file_path']) . '" target=_blank>' . $filesByType['portfolio']['original_name'] . '</a>'
                                : '🖼️ Portfolio : aucun'
                            )
                        );
                    ?>">
                    📂 Dossier
                </button>



            </div>
        </div>
    </section>
    <!-- Contenu pré-rendu pour le panneau "Profil & identité" -->
    <div id="panel-profil-content" style="display:none;">
        <h3 style="margin-top:0; margin-bottom:6px;">
            <?= htmlspecialchars(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''))) ?>
        </h3>

        <?php if (!empty($profile['headline'])): ?>
            <p style="margin:0 0 10px 0; opacity:0.9;">
                <?= htmlspecialchars($profile['headline']) ?>
            </p>
        <?php endif; ?>

        <div style="font-size:0.9rem; opacity:0.9; margin-bottom:10px;">
            <?php
            // Ville
            $cityText = $profile['city_region'] ?? ($user['city'] ?? null);
            if (!empty($cityText)): ?>
                <div>📍 <?= htmlspecialchars($cityText) ?></div>
            <?php endif; ?>

            <?php
            // Mobilité
            $mobilityLabels = [
                'locale' => 'Mobilité locale',
                'regionale' => 'Mobilité régionale',
                'nationale' => 'Mobilité nationale',
                'internationale' => 'Mobilité internationale',
            ];
            if (!empty($profile['mobility'])):
                $mobilityLabel = $mobilityLabels[$profile['mobility']] ?? null;
                if ($mobilityLabel): ?>
                    <div>🚗 <?= htmlspecialchars($mobilityLabel) ?></div>
                <?php endif;
            endif; ?>

            <?php
            // Disponibilité
            $availabilityText = null;
            if (!empty($profile['availability_type'])) {
                switch ($profile['availability_type']) {
                    case 'immediate':
                        $availabilityText = "Disponible immédiatement";
                        break;
                    case 'date':
                        $dateTxt = !empty($profile['availability_date'])
                            ? date('d/m/Y', strtotime($profile['availability_date']))
                            : '';
                        $availabilityText = "Disponible à partir du " . $dateTxt;
                        break;
                    case 'stage':
                        $availabilityText = "Recherche un stage";
                        break;
                    case 'alternance':
                        $availabilityText = "Recherche une alternance";
                        break;
                    case 'autre':
                        $availabilityText = "Disponibilité à préciser";
                        break;
                }
            }

            if ($availabilityText): ?>
                <div>⏱️ <?= htmlspecialchars($availabilityText) ?></div>
            <?php endif; ?>
        </div>

        <p style="margin:0; font-size:0.85rem; opacity:0.75;">
            Ces informations viennent de ton wizard. Tu pourras les modifier à tout moment.
        </p>
    </div>
    <!-- Contenu pré-rendu pour le panneau "Infos clés" -->
    <div id="panel-infos-content" style="display:none;">
        <h3 style="margin-top:0; margin-bottom:8px;">Infos clés</h3>

        <div style="font-size:0.9rem; margin-bottom:10px;">
            <?php if (!empty($profile['contact_email']) || !empty($user['email'])): ?>
                <div>
                    📧
                    <strong>Email :</strong>
                    <?= htmlspecialchars($profile['contact_email'] ?? $user['email']) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($profile['contact_phone'])): ?>
                <div>
                    📱
                    <strong>Téléphone :</strong>
                    <?= htmlspecialchars($profile['contact_phone']) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($profile['contact_linkedin'])): ?>
                <div>
                    💼
                    <strong>LinkedIn :</strong>
                    <a href="<?= htmlspecialchars($profile['contact_linkedin']) ?>" target="_blank" rel="noopener"
                        style="color:#39c2ff;">
                        Voir le profil
                    </a>
                </div>
            <?php endif; ?>

            <?php if (!empty($profile['contact_website'])): ?>
                <div>
                    🌐
                    <strong>Site :</strong>
                    <a href="<?= htmlspecialchars($profile['contact_website']) ?>" target="_blank" rel="noopener"
                        style="color:#39c2ff;">
                        <?= htmlspecialchars($profile['contact_website']) ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($profile['mini_bio'])): ?>
            <div style="margin-bottom:10px;">
                <h4 style="margin:0 0 4px 0; font-size:0.9rem;">Mini bio</h4>
                <p style="margin:0; opacity:0.9;">
                    <?= nl2br(htmlspecialchars($profile['mini_bio'])) ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (!empty($profile['skill_1']) || !empty($profile['skill_2']) || !empty($profile['skill_3'])): ?>
            <div style="margin-bottom:10px;">
                <h4 style="margin:0 0 4px 0; font-size:0.9rem;">Compétences clés</h4>
                <ul style="margin:0; padding-left:18px; font-size:0.9rem;">
                    <?php if (!empty($profile['skill_1'])): ?>
                        <li><?= htmlspecialchars($profile['skill_1']) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($profile['skill_2'])): ?>
                        <li><?= htmlspecialchars($profile['skill_2']) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($profile['skill_3'])): ?>
                        <li><?= htmlspecialchars($profile['skill_3']) ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($profile['video_url'])): ?>
            <div>
                <h4 style="margin:0 0 4px 0; font-size:0.9rem;">Vidéo de présentation</h4>
                <a href="<?= htmlspecialchars($profile['video_url']) ?>" target="_blank" rel="noopener"
                    style="color:#39c2ff;">
                    ▶️ Ouvrir la vidéo
                </a>
            </div>
        <?php endif; ?>

        <p style="margin-top:12px; font-size:0.8rem; opacity:0.75;">
            Ces informations sont issues de l’étape “Infos clés” du wizard.
        </p>
    </div>
    <!-- Contenu pré-rendu pour le panneau "Diplômes & formations" -->
    <div id="panel-diplomes-content" style="display:none;">
        <h3 style="margin-top:0; margin-bottom:8px;">Diplômes &amp; formations</h3>

        <?php if (!empty($diplomas)): ?>
            <ul style="margin:0; padding-left:18px; font-size:0.9rem;">
                <?php foreach ($diplomas as $diploma): ?>
                    <li style="margin-bottom:8px;">
                        <div style="font-weight:600;">
                            <?= htmlspecialchars($diploma['title'] ?? 'Diplôme') ?>
                        </div>

                        <?php if (!empty($diploma['school']) || !empty($diploma['years'])): ?>
                            <div style="opacity:0.9;">
                                <?php if (!empty($diploma['school'])): ?>
                                    <?= htmlspecialchars($diploma['school']) ?>
                                <?php endif; ?>
                                <?php if (!empty($diploma['years'])): ?>
                                    — <?= htmlspecialchars($diploma['years']) ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($diploma['location'])): ?>
                            <div style="font-size:0.85rem; opacity:0.85;">
                                📍 <?= htmlspecialchars($diploma['location']) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($diploma['note'])): ?>
                            <div style="font-size:0.85rem; opacity:0.9; margin-top:2px;">
                                <?= nl2br(htmlspecialchars($diploma['note'])) ?>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="margin:0; opacity:0.85;">
                Aucun diplôme n’a encore été ajouté dans le wizard.
            </p>
        <?php endif; ?>

        <p style="margin-top:12px; font-size:0.8rem; opacity:0.75;">
            Ces informations sont issues de l’étape “Diplômes &amp; formations” du wizard.
        </p>
    </div>

    <!-- Contenu pré-rendu pour le panneau "Expériences" -->
    <div id="panel-experiences-content" style="display:none;">
        <h3 style="margin-top:0; margin-bottom:8px;">Expériences</h3>

        <?php if (!empty($experiences)): ?>
            <ul style="margin:0; padding-left:18px; font-size:0.9rem;">
                <?php
                $contractLabels = [
                    'cdi' => 'CDI',
                    'cdd' => 'CDD',
                    'stage' => 'Stage',
                    'alternance' => 'Alternance',
                    'freelance' => 'Freelance',
                    'autre' => 'Autre'
                ];
                ?>
                <?php foreach ($experiences as $exp): ?>
                    <li style="margin-bottom:10px;">
                        <div style="font-weight:600;">
                            <?= htmlspecialchars($exp['title'] ?? 'Poste') ?>
                        </div>

                        <?php if (!empty($exp['company']) || !empty($exp['contract_type'])): ?>
                            <div style="opacity:0.9;">
                                <?php if (!empty($exp['company'])): ?>
                                    <?= htmlspecialchars($exp['company']) ?>
                                <?php endif; ?>
                                <?php if (!empty($exp['contract_type'])): ?>
                                    —
                                    <?= htmlspecialchars($contractLabels[$exp['contract_type']] ?? $exp['contract_type']) ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($exp['start_month']) || !empty($exp['end_month']) || !empty($exp['is_current'])): ?>
                            <div style="font-size:0.85rem; opacity:0.85;">
                                📅
                                <?php if (!empty($exp['start_month'])): ?>
                                    <?= htmlspecialchars(substr($exp['start_month'], 0, 7)) ?>
                                <?php endif; ?>
                                <?php if (!empty($exp['end_month']) && empty($exp['is_current'])): ?>
                                    → <?= htmlspecialchars(substr($exp['end_month'], 0, 7)) ?>
                                <?php elseif (!empty($exp['is_current'])): ?>
                                    → Aujourd’hui
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($exp['summary'])): ?>
                            <div style="font-size:0.85rem; opacity:0.9; margin-top:2px;">
                                <?= nl2br(htmlspecialchars($exp['summary'])) ?>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="margin:0; opacity:0.85;">
                Aucune expérience n’a encore été ajoutée dans le wizard.
            </p>
        <?php endif; ?>

        <p style="margin-top:12px; font-size:0.8rem; opacity:0.75;">
            Ces informations viennent de l’étape “Expériences” du wizard.
        </p>
    </div>

    <!-- Contenu pré-rendu pour le panneau "Réalisations & projets" -->
    <div id="panel-realisations-content" style="display:none;">
        <h3 style="margin-top:0; margin-bottom:8px;">Réalisations &amp; projets</h3>

        <?php if (!empty($projects)): ?>
            <ul style="margin:0; padding-left:18px; font-size:0.9rem;">
                <?php foreach ($projects as $project): ?>
                    <li style="margin-bottom:10px;">
                        <div style="font-weight:600;">
                            <?= htmlspecialchars($project['title'] ?? 'Projet') ?>
                        </div>

                        <?php if (!empty($project['type'])): ?>
                            <div style="font-size:0.85rem; opacity:0.9;">
                                <?php
                                $typeLabels = [
                                    'pro' => 'Projet professionnel',
                                    'formation' => 'Projet de formation',
                                    'perso' => 'Projet personnel',
                                    'freelance' => 'Projet freelance',
                                    'autre' => 'Autre projet'
                                ];
                                ?>
                                <?= htmlspecialchars($typeLabels[$project['type']] ?? $project['type']) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($project['description'])): ?>
                            <div style="font-size:0.85rem; opacity:0.9; margin-top:2px;">
                                <?= nl2br(htmlspecialchars($project['description'])) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($project['link'])): ?>
                            <div style="margin-top:4px;">
                                🔗
                                <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" rel="noopener"
                                    style="color:#39c2ff;">
                                    Voir le projet
                                </a>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="margin:0; opacity:0.85;">
                Aucun projet n’a encore été ajouté dans le wizard.
            </p>
        <?php endif; ?>

        <p style="margin-top:12px; font-size:0.8rem; opacity:0.75;">
            Ces informations viennent de l’étape “Réalisations &amp; projets” du wizard.
        </p>
    </div>

    <!-- Overlay + panneau bas générique -->
    <div class="talentys-panel-overlay" id="talentys-panel-overlay"></div>

    <div class="talentys-panel" id="talentys-panel">
        <div class="talentys-panel-header">
            <h2 class="talentys-panel-title" id="talentys-panel-title">
                Section
            </h2>
            <button class="talentys-panel-close" id="talentys-panel-close" aria-label="Fermer">
                ✕
            </button>
        </div>

        <div class="talentys-panel-body" id="talentys-panel-body">
            <p>Ceci est un panneau de test. Le contenu sera remplacé par les données de ton wizard.</p>
        </div>

        <div class="talentys-panel-footer" id="talentys-panel-footer">
            <!-- Rien pour l’instant côté candidat -->
        </div>
    </div>
</main>
<!-- Couche ENTRETlEN Talentys -->
<div id="interview-layer" class="interview-hidden">
    <!-- Overlay assombrissant le bureau en mode Face-à-face / Retour visio -->
    <div id="interview-overlay"></div>

    <!-- Visio principale (face-à-face) -->
    <div id="interview-video-main">
        <video id="interview-remote-video" autoplay playsinline></video>
        <video id="interview-self-video" class="interview-self-view" autoplay muted playsinline></video>
    </div>

    <!-- Barre de contrôle visio -->
    <div id="interview-controls">
        <button class="interview-btn" data-action="mic">🎙️</button>
        <button class="interview-btn" data-action="cam">🎥</button>
        <button class="interview-btn" data-action="toggle-view">🖥️</button>
        <button class="interview-btn" data-action="leave">❌</button>
    </div>
</div>

<script>
    // Panneau bas
    const panel = document.getElementById('talentys-panel');
    const overlay = document.getElementById('talentys-panel-overlay');
    const closeBtn = document.getElementById('talentys-panel-close');
    const panelTitle = document.getElementById('talentys-panel-title');
    const panelBody = document.getElementById('talentys-panel-body');

    function openTalentysPanel(title, bodyHtml) {
        panelTitle.textContent = title;
        panelBody.innerHTML = bodyHtml;
        panel.classList.add('is-visible');
        overlay.classList.add('is-visible');
    }


    function closeTalentysPanel() {
        panel.classList.remove('is-visible');
        overlay.classList.remove('is-visible');
    }

    closeBtn.addEventListener('click', closeTalentysPanel);
    overlay.addEventListener('click', closeTalentysPanel);

    document.querySelectorAll('.desk-zone').forEach(zone => {
        zone.addEventListener('click', () => {
            const title = zone.dataset.panelTitle || 'Section';
            const body = zone.dataset.panelBody || '';
            const templateKey = zone.dataset.panelTemplate;

            let html = '';

            if (templateKey) {
                const tpl = document.getElementById('panel-' + templateKey + '-content');
                if (tpl) {
                    html = tpl.innerHTML;
                } else {
                    html = '<p>Contenu à venir.</p>';
                }
            } else if (body.trim()) {
                // Si body contient déjà du HTML (liens, <br>, listes…), on l’injecte tel quel
                const hasHtmlTags = /<\/?[a-z][\s\S]*>/i.test(body);
                html = hasHtmlTags ? body : '<p>' + body + '</p>';
            } else {
                html = '<p>Contenu à venir.</p>';
            }

            openTalentysPanel(title, html);
        });
    });


    // Mode prévisualisation
    const previewToggle = document.getElementById('preview-toggle');
    const previewBadge = document.getElementById('preview-badge');

    let isPreview = <?= $isRecruiterView ? 'true' : 'false' ?>;

    if (previewBadge && isPreview) {
        previewBadge.style.display = 'inline-flex';
    }

    if (previewToggle && previewBadge) {
        previewToggle.addEventListener('click', () => {
            isPreview = !isPreview;
            if (isPreview) {
                previewBadge.style.display = 'inline-flex';
                previewToggle.textContent = 'Quitter la prévisualisation';
            } else {
                previewBadge.style.display = 'none';
                previewToggle.textContent = '👁️ Prévisualiser comme recruteur';
            }
        });
    }

    // ==== MODE ENTRETIEN (TEST) ====
    const interviewLayer = document.getElementById('interview-layer');
    const interviewTestToggle = document.getElementById('interview-test-toggle');
    let isInterviewMode = false;

    if (interviewLayer && interviewTestToggle) {
        interviewTestToggle.addEventListener('click', () => {
            isInterviewMode = !isInterviewMode;

            if (isInterviewMode) {
                interviewLayer.classList.remove('interview-hidden');
                interviewTestToggle.textContent = '❌ Quitter mode entretien (test)';
            } else {
                interviewLayer.classList.add('interview-hidden');
                interviewTestToggle.textContent = '🎥 Mode entretien (test)';
            }
        });
    }
    // ==== BASCULE VISIO <-> BUREAU (MAQUETTE) ====
    const interviewToggleViewBtn = document.querySelector('#interview-controls [data-action="toggle-view"]');
    let isExplorationView = false;

    if (interviewToggleViewBtn) {
        interviewToggleViewBtn.addEventListener('click', () => {
            // On ne bascule la vue que si le mode entretien est actif
            if (interviewLayer.classList.contains('interview-hidden')) {
                return;
            }

            isExplorationView = !isExplorationView;

            if (isExplorationView) {
                document.body.classList.add('interview-exploration');
                // (texte provisoire pour debug, tu pourras retirer plus tard)
                interviewToggleViewBtn.textContent = '⬅️ Retour visio';
            } else {
                document.body.classList.remove('interview-exploration');
                interviewToggleViewBtn.textContent = '🖥️';
            }
        });
    }

</script>

<?php include_once('../partials/footer.php'); ?>