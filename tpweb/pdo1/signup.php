<?php
require_once('utilisateur.php');
Utilisateur::getinstance();
session_start();

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    if (Utilisateur::getUtilisateur($email)) {
        $error = "Cet utilisateur existe déjà.";
    } else {
        Utilisateur::addUtilisateur($username, $email, $password);
        $user = Utilisateur::getUtilisateur($email);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];  
        header('Location: index.php');
        exit;
    }
}
if (isset($_POST['go_to_login'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-3">Inscription</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger mb-3"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="mb-3">
            <div class="mb-3">
                <input type="text" class="form-control" name="email" placeholder="Email d'utilisateur" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            </div>
            <button type="submit" name="signup" class="btn btn-primary">S'inscrire</button>
        </form>
        
        <form method="post">
            <button type="submit" name="go_to_login" class="btn btn-link">Déjà un compte? Se connecter</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>