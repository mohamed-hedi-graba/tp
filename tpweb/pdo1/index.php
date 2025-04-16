<?php
require_once('utilisateur.php');
Utilisateur::getinstance();

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user = Utilisateur::getUtilisateurById($_SESSION['user_id']);
if ($user['role'] !== 'admin') {
    header('Location: students.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <header>
        <h1>Students Management System</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="students.php">Liste des étudiants</a>
            <a href="sections.php">Liste des sections</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?> to your admin platform!</h1>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>