<?php
include 'config.php';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Scolaire</title>
    <link rel="stylesheet" href="css/alerts.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <h1>Connexion</h1>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form id="form-login" method="POST" action="actions/auth_action.php">
            <input type="hidden" name="action" value="login">

            <div class="formulair_group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="formulairgroup">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btnconnect">Se connecter</button>
        </form>

        <div class="auth-links">
            <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
            <p style="margin-top: 10px;"><a href="index.html">Retour à l'accueil</a></p>
        </div>
    </div>
    <script src="js/alerts.js"></script>
    <script src="js/forms.js"></script>
</body>
</html>
