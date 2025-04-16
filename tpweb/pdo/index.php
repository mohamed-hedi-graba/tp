<?php
require_once("init.php");
$db = ConnectionBD::getInstance();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Table</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .info {
        display: inline-block;
        padding: 10px 20px;
        background-color:rgb(68, 158, 255);
        color: white;
        text-decoration: none;
        border-radius: 50%;
        font-weight: bold;
        font-family: Arial, sans-serif;
    }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Liste des etudiants</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Birthday</th>
            <th>details</th>
        </tr>
        <?php
        try {
            $resp = $db->query("SELECT * FROM Etudient");
            $students = $resp->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($students) > 0) {
                foreach ($students as $row) {
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($row['id'])."</td>";
                    echo "<td>".htmlspecialchars($row['name'])."</td>";
                    echo "<td>".htmlspecialchars($row['birthday'])."</td>";
                    echo "<td><a href='/détailEtudiant.php?id=".htmlspecialchars($row['id'])."' class='info'>i</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' style='text-align: center;'>No students found</td></tr>";
            }
        } catch(Exception $e) {
            echo "<tr><td colspan='3' style='text-align: center; color: red;'>Error loading data: ".htmlspecialchars($e->getMessage())."</td></tr>";
        }
        ?>
    </table>
</body>
</html>