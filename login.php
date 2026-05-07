<?php
include 'config.php';
$error = '';

if(isset($_POST['action']) && $_POST['action'] === 'login'){
    $email    = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $error = "Email et mot de passe requis";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if(!$user){
            $error = "Email non trouvé";
        } elseif($user['role'] !== 'admin' && $user['status'] !== 'approved'){
            $error = "Compte non approuvé par l'admin";
        } elseif(verifyPassword($password, $user['password']) || $password === $user['password']){
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['email']     = $user['email'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            if($user['role'] === 'admin')        header("Location: admin.php");
            elseif($user['role'] === 'professor') header("Location: professor.php");
            else                                  header("Location: student.php");
            exit();
        } else {
            $error = "Mot de passe incorrect";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Scolaire</title>
    <link rel="stylesheet" href="../css/alerts.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <h1>Connexion</h1>

        <?php if($error){ ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php } ?>

        <form method="POST">
            <input type="hidden" name="action" value="login">
            <div class="formulair_group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="formulairgroup">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit" class="btnconnect">Se connecter</button>
        </form>

        <div class="auth-links">
            <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
            <p style="margin-top: 10px;"><a href="../index.html">Retour à l'accueil</a></p>
        </div>
    </div>
    <script src="../js/alerts.js"></script>
    <script src="../js/forms.js"></script>
</body>
</html>
