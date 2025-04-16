<?php
session_start();
require_once 'section.php';
Section::getinstance();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    http_response_code(403); 
    die("Access Denied: You don't have permission to view this page.");
}

$error = '';
$success = '';
$id = $_GET['id'];

if (isset($_POST['update'])) {
    $section=Section::getSectionById($id);
    $designation = $_POST['designation'] ?? $section['designation'];
    $description = $_POST['description'] ?? $section['description'];
    try {
        Section::updateSection($id,$designation, $description);
        $success = "Section modifié avec succès.";
    } catch(Exception $e) {
        $error = "Erreur lors de la modification : " . $e->getMessage();
    }
            
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'étudiant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">modifier une étudiant</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">designation de section</label>
                        <input type="text" class="form-control" name="designation" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">description de section</label>
                        <input type="text" class="form-control" name="description" >
                    </div>
                    <button type="submit" name="update" class="btn btn-success">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
