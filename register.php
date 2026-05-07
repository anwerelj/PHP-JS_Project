<?php
include 'config.php';
$error   = '';
$success = '';

if(isset($_POST['action']) && $_POST['action'] === 'register'){
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $role      = $_POST['role'];

    if(empty($full_name) || empty($email) || empty($password) || empty($role)){
        $error = "Tous les champs sont requis";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Email invalide";
    } elseif(strlen($password) < 6){
        $error = "Le mot de passe doit contenir au moins 6 caractères";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if($stmt->get_result()->num_rows > 0){
            $error = "Cet email est déjà utilisé";
        } else {
            $hashed = hashPassword($password);
            $stmt = $conn->prepare("INSERT INTO users (email, password, full_name, role, status) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->bind_param("ssss", $email, $hashed, $full_name, $role);
            if($stmt->execute()){
                $success = "Inscription réussie! En attente d'approbation.";
            } else {
                $error = "Erreur lors de l'inscription";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Gestion Scolaire</title>
    <link rel="stylesheet" href="../css/alerts.css">
    <link rel="stylesheet" href="../css/forms.css">
    <link rel="stylesheet" href="../css/register.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <h1>Inscription</h1>

        <?php if($error){ ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php } ?>
        <?php if($success){ ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php } ?>

        <form method="POST">
            <input type="hidden" name="action" value="register">
            <div class="form-group">
                <label for="full_name">Nom complet</label>
                <input type="text" id="full_name" name="full_name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select id="role" name="role">
                    <option value="">-- Choisir --</option>
                    <option value="student">Étudiant</option>
                    <option value="professor">Professeur</option>
                </select>
            </div>
            <button type="submit" class="btn_createaccount">Créer mon compte</button>
        </form>

        <div class="auth-links">
            <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
            <p style="margin-top: 10px;"><a href="../index.html">Retour à l'accueil</a></p>
        </div>
    </div>
    <script src="../js/alerts.js"></script>
    <script src="../js/forms.js"></script>
</body>
</html>
