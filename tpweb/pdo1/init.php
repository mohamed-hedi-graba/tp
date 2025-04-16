<?php
/*require_once 'ConnectionDB.php';

$db = ConnectionBD::getInstance();

try {
    $sql = "CREATE TABLE IF NOT EXISTS utilisateur (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(255) UNIQUE NOT NULL,
        email VARCHAR(255),
        password VARCHAR(255),
        role VARCHAR(5) DEFAULT 'user'
    )";
    $db->exec($sql);
    $sql = "INSERT INTO utilisateur (username, email, password, role) VALUES ('admin', 'admin@insat.tn', 'admin', 'admin')";
    $db->exec($sql);
} catch(Exception $e) {
    die("creation de utilisateur failed: " . $e->getMessage());
}

try {
    $sql= "CREATE TABLE IF NOT EXISTS etudiant (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    birthday DATE NOT NULL,
    image VARCHAR(255),
    section VARCHAR(255) NOT NULL
    )";
    $db->exec($sql);
} catch(Exception $e) {
    die("creation de etudiant failed: " . $e->getMessage());
}
try {
    $sql= "CREATE TABLE IF NOT EXISTS section(
    id INT PRIMARY KEY AUTO_INCREMENT,
    designation VARCHAR(5) UNIQUE NOT NULL,
    description VARCHAR(255) NOT NULL
    )";
    $db->exec($sql);
}catch (Exception $e) {
    die("creation de table failed: " . $e->getMessage());
}*/
?>