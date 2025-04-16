<?php
require_once 'SessionManager.php';
$session = SessionManager::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $session->destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$visitCount = $session->incrementVisitCount();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Sessions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            background-color: #f8f9fa;
            border-left: 5px solid #007bff;
        }
        button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur notre plateforme</h1>
    
    <div class="message">
        <?php if ($session->isFirstVisit()): ?>
            <p>Bienvenue à notre plateforme.</p>
        <?php else: ?>
            <p>Merci pour votre fidélité, c'est votre <?= htmlspecialchars($visitCount) ?>ème visite.</p>
        <?php endif; ?>
    </div>
    
    <form method="post">
        <button type="submit" name="reset">Réinitialiser la session</button>
    </form>
</body>
</html>