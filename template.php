<?php




session_start();
require_once('dbname.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Vérification du timeout de session (30 minutes d'inactivité)
$timeout_duration = 1800; // 30 minutes
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header('Location: login.php?timeout=1');
    exit();
}
$_SESSION['last_activity'] = time();

// Récupération  des informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$query = $connexion->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(['id' => $user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Accueil - Bienvenue ' . htmlspecialchars($user['prenom']); ?></title>
    <link rel="stylesheet" href="syle/template.css">

</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">🚀 Mon Application</div>
        <div class="navbar-menu">
            <a href="template.php" class="navbar-link">🏠 Accueil</a>
            <a href="profil.php" class="navbar-link">👤 Profil</a>
            <span class="navbar-link" style="cursor: default;">Bonjour, <?php echo htmlspecialchars($user['prenom']); ?></span>
            <a href="logout.php" class="btn-logout">Déconnexion</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-section">
            <div class="user-avatar">
                <?php echo strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)); ?>
            </div>
            <h1 class="welcome-title">Bienvenue, <?php echo htmlspecialchars($user['prenom']); ?> ! 👋</h1>
            <p class="welcome-subtitle">Heureux de vous revoir sur votre espace personnel</p>
        </div>

        <div class="user-info">
            <h3>📋 Vos Informations</h3>
            <div class="user-details">
                <div class="detail-item">
                    <div class="detail-label">Nom</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user['nom']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Prénom</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user['prenom']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Pseudo</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user['pseudo']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
            </div>
        </div>

        <div class="cards-grid">
            <div class="card">
                <div class="card-icon">👤</div>
                <h3 class="card-title">Mon Profil</h3>
                <p class="card-text">
                    Gérez vos informations personnelles, modifiez votre mot de passe et personnalisez votre compte.
                </p>
                <a href="profil.php" class="card-link">Accéder au profil</a>
            </div>

            <div class="card">
                <div class="card-icon">📊</div>
                <h3 class="card-title">Tableau de bord</h3>
                <p class="card-text">
                    Visualisez vos statistiques, suivez votre activité et analysez vos performances.
                </p>
                <a href="#" class="card-link">Voir les statistiques</a>
            </div>

            <div class="card">
                <div class="card-icon">⚙️</div>
                <h3 class="card-title">Paramètres</h3>
                <p class="card-text">
                    Configurez vos préférences, notifications et paramètres de sécurité avancés.
                </p>
                <a href="#" class="card-link">Configurer</a>
            </div>
        </div>

        <div class="stats-section">
            <h2 class="stats-title">📈 Vos Statistiques</h2>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-value">
                        <?php 
                        $days = isset($user['created_at']) && $user['created_at'] ? floor((time() - strtotime($user['created_at'])) / 86400) : 0;
                        echo $days;
                        ?>
                    </div>
                    <div class="stat-label">Jours en tant que membre</div>
                </div>

                <div class="stat-box">
                    <div class="stat-value">
                        <?php echo isset($user['last_login']) && $user['last_login'] ? date('H:i', strtotime($user['last_login'])) : '--:--'; ?>
                    </div>
                    <div class="stat-label">Dernière connexion</div>
                </div>

                <div class="stat-box">
                    <div class="stat-value">100%</div>
                    <div class="stat-label">Profil complété</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
