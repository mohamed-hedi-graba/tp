<?php
require_once("init.php");   
$db = ConnectionBD::getInstance();
$id = $_GET['id'];

try {
    $req = $db->prepare("SELECT * FROM Etudient WHERE id=:id");
    $req->execute(array("id" => $id));
    $student = $req->fetch(PDO::FETCH_ASSOC);
    
    if (count($student) > 0) {
        echo "<h1 style='text-align: center;'>Détails de l'étudiant</h1>";
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Name</th>";
        echo "<th>Birthday</th>";
        echo "<th>Classe</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>".htmlspecialchars($student['id'])."</td>";
        echo "<td>".htmlspecialchars($student['name'])."</td>";
        echo "<td>".htmlspecialchars($student['birthday'])."</td>";
        echo "<td>Gl</td>";
        echo "</tr>";
        echo "</table>";
    } else { 

    } 
} catch(Exception $e) {
    echo "<tr>Error loading data: ".htmlspecialchars($e->getMessage())."</tr>";
}
?>