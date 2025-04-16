<?php
include 'Etudiant.php'; // si la classe est dans un fichier séparé, sinon copier la classe ici

// Création des étudiants
$etudiants = [
    new Etudiant("Aymen", [11, 13, 18, 7, 10, 13, 2, 5, 1]),
    new Etudiant("Skander", [15, 9, 8, 16,10,15,6,8.5,11.25])
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultat des Étudiants</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">

<h1>Résultat des Étudiants</h1>

<?php
foreach ($etudiants as $etudiant) {
    echo "<div style='margin-bottom: 30px; border-bottom: 1px solid #ccc; padding-bottom: 20px;'>";
    $etudiant->afficherNotes();
    $etudiant->afficherAdmission();
    echo "</div>";
}
?>

</body>
</html>
