<?php
session_start();
require_once 'etudiant.php';
etudiant::getinstance();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    http_response_code(403); 
    die("Access Denied: You don't have permission to view this page.");
}

$id = $_GET['id'];
$error = '';
$success = '';

if (isset($_POST['update'])) {
    $etudiant = Etudiant::getEtudiant($id);
    $name = $_POST['name'] ?? $etudiant['name'];
    $birthday = $_POST['birthday'] ?? $etudiant['birthday'];
    $section = $_POST['section'] ?? $etudiant['section'];
    $imageName = $etudiant['image']; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadedName = basename($_FILES['image']['name']);
        $uploadDir = 'images/';
        $targetPath = $uploadDir . $uploadedName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imageName = $uploadedName; 
            } else {
                $error = "Échec du téléchargement de l'image.";
            }
        } else {
            $error = "Type d'image non autorisé (JPG, PNG, GIF uniquement).";
        }
    }

    if (empty($error)) {
        try {
            Etudiant::updateEtudiant($id,$name, $birthday, $imageName, $section);
            $success = "Mise à jour effectuée avec succès.";
        } catch (Exception $e) {
            $error = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
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
                <h4 class="mb-0">insert info you want to be updated</h4>
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
                        <label class="form-label">changer le Nom d'étudiant</label>
                        <input type="text" class="form-control" name="name" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" name="birthday" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <input type="text" class="form-control" name="section" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image de l'étudiant</label>
                        <input type="file" class="form-control" name="image" accept="image/*" >
                    </div>
                    <button type="submit" name="update" class="btn btn-success">update</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
