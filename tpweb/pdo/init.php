<?php
require_once 'ConnectionDB.php';

$db = ConnectionBD::getInstance();

try {
    $sql = "CREATE TABLE IF NOT EXISTS Etudient (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255),
        birthday DATE
    )";
    $db->exec($sql);
} catch(Exception $e) {
    die("Table creation failed: " . $e->getMessage());
}

try {
    $count = $db->query("SELECT COUNT(*) FROM Etudient")->fetchColumn();
    if ($count == 0) {
        $sql = "INSERT INTO Etudient (name, birthday) VALUES 
                ('Aymen', '1982-02-07'),
                ('Skander', '2018-07-11')";
         $rows = $db->exec($sql);
}
} catch(Exception $e) {
    die("Data insertion failed: " . $e->getMessage());
}
?>