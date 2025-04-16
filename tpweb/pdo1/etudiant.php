<?php
require_once 'ConnectionDB.php';
require_once  'section.php';
Section::getinstance();
class etudiant {
    private static $_db;
    public static function getinstance() {
        if (!isset(self::$_db)) {
        self::$_db = ConnectionBD::getInstance();
        self::init();
    }
    }
    public static function init() {
        try {
            $sql= "CREATE TABLE IF NOT EXISTS etudiant (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            birthday DATE NOT NULL,
            image VARCHAR(255),
            section VARCHAR(255) NOT NULL
            )";
            self::$_db->exec($sql);
        } catch(Exception $e) {
            die("creation de etudiant failed: " . $e->getMessage());
        }
    }
    public static function getEtudiant($id) {
        $sql = "SELECT * FROM etudiant WHERE id=:id";
        $req = self::$_db->prepare($sql);
        $req->execute(array("id" => $id));
        $etudiant = $req->fetch(PDO::FETCH_ASSOC);
        return $etudiant;
    }
    public static function deleteEtudiant($id) {
        $sql = "DELETE FROM etudiant WHERE id=:id";
        $req = self::$_db->prepare($sql);
        $req->execute(array("id" => $id));
    }
    public static function addEtudiant($name, $birthday, $image, $section) {
        $sql = "INSERT INTO etudiant (name, birthday, image, section) VALUES (:name, :birthday, :image, :section)";
        $req = self::$_db->prepare($sql);
        $req->execute(array("name" => $name, "birthday" => $birthday, "image" => $image, "section" => $section));
    }
    public static function getEtudiantByName($name) {
        $sql = "SELECT * FROM etudiant WHERE LOWER(name) LIKE LOWER(:name)";        $req = self::$_db->prepare($sql);
        $req->execute(array("name" =>"%".$name."%"));
        $etudiant = $req->fetch(PDO::FETCH_ASSOC);
        return $etudiant;
    }
    public static function updateEtudiant($id, $name, $birthday, $image, $section) {
        $sql = "UPDATE etudiant SET name=:name, birthday=:birthday, image=:image, section=:section WHERE id=:id";
        $req = self::$_db->prepare($sql);
        $req->execute(array("id" => $id, "name" => $name, "birthday" => $birthday, "image" => $image, "section" => $section));
    }
    public static function getEtudiants() {
        $sql = "SELECT * FROM etudiant ";
        $req = self::$_db->prepare($sql); 
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        return $res; 
    }
    
}
?>