<?php
include 'config.php';
$error   = $_GET['error']   ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Gestion Scolaire</title>
    <link rel="stylesheet" href="css/alerts.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <h1>Inscription</h1>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form id="form-register" method="POST" action="actions/auth_action.php">
            <input type="hidden" name="action" value="register">

            <div class="form-group">
                <label for="full_name">Nom complet</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="role">Rôle</label>
                <select id="role" name="role" required>
                    <option value="">-- Choisir --</option>
                    <option value="student">Étudiant</option>
                    <option value="professor">Professeur</option>
                </select>
            </div>

            <button type="submit" class="btn_createaccount">Créer mon compte</button>
        </form>

        <div class="auth-links">
            <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
            <p style="margin-top: 10px;"><a href="index.html">Retour à l'accueil</a></p>
        </div>
    </div>
    <script src="js/alerts.js"></script>
    <script src="js/forms.js"></script>
</body>
</html>
