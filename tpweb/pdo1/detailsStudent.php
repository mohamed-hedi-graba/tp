<?php
require_once('etudiant.php');
Etudiant::getinstance();
$id = $_GET['id'];

try {
    $student = Etudiant::getEtudiant($id);
    
    if (count($student) > 0) {
        echo "<h1 style='text-align: center;'>Détails de l'étudiant</h1>";
        echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Photo</th>";
        echo "<th>Name</th>";
        echo "<th>Birthday</th>";
        echo "<th>Classe</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>".htmlspecialchars($student['id'])."</td>";
        echo "<td><img src='" . htmlspecialchars('images/' . $student['image']) . "' alt='profile' style='width: 100px; height: auto; border-radius: 50%;'></td>";
        echo "<td>".htmlspecialchars($student['name'])."</td>";
        echo "<td>".htmlspecialchars($student['birthday'])."</td>";
        echo "<td>".htmlspecialchars($student['section'])."</td>";
        echo "</tr>";
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>No student found</p>";
    } 
} catch(Exception $e) {
    echo "<p style='color: red; text-align: center;'>Error loading data: ".htmlspecialchars($e->getMessage())."</p>";
}
?>