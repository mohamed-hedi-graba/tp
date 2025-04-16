<?php
require_once 'ConnectionDB.php';
require_once('etudiant.php');
Etudiant::getinstance();
class Section {
    private static $_db ;
    public static function getinstance() {
        if (!isset(self::$_db)) {
        self::$_db = ConnectionBD::getInstance();
        self::init();
    }
    }
    private static function init() {
        $sql = "CREATE TABLE IF NOT EXISTS section (
            id INT PRIMARY KEY AUTO_INCREMENT,
            designation VARCHAR(5) UNIQUE NOT NULL,
            description VARCHAR(255) NOT NULL
        )";
        
        try {
            self::$_db->exec($sql);
        } catch(Exception $e) {
            error_log("Section table creation failed: " . $e->getMessage());
            throw $e;
        }
    }
    public static function getSection($designation) {
        $sql = "SELECT * FROM section WHERE designation=:designation";
        $req = self::$_db->prepare($sql);
        $req->execute(array("designation" => $designation));
        $section = $req->fetch(PDO::FETCH_ASSOC);
        return $section;
    }
    public static function getSectionById($id) {
        $sql = "SELECT * FROM section WHERE id=:id";
        $req = self::$_db->prepare($sql);
        $req->execute(array("id" => $id));
        $section = $req->fetch(PDO::FETCH_ASSOC);
        return $section;
    }
    public static function deleteSection($id) {
        $sql = "DELETE FROM section WHERE id=:id";
        $req = self::$_db->prepare($sql);
        $req->execute(array("id" => $id));
       
    }
    public static function addSection($designation, $description) {
        $sql = "INSERT INTO section (designation, description) VALUES (:designation, :description)";
        $req = self::$_db->prepare($sql);
        $req->execute(array("designation" => $designation, "description" => $description));
    }
    public static function getInscrit($designation) {
        $sql = "SELECT name FROM etudiant WHERE section=:designation";
        $req = self::$_db->prepare($sql);
        $req->execute(array("designation" => $designation));
        $inscrit = $req->fetch(PDO::FETCH_ASSOC);
        return $inscrit;
    }
    public static function updateSection($id,$designation, $description) {
        $sql = "UPDATE section SET description=:description , designation=:designation WHERE id=:id";
        $req = self::$_db->prepare($sql);
        $req->execute(array("designation" => $designation, "description" => $description,"id"=>$id));
    }
    public static function getSections() {
        $sql = "SELECT * FROM section ";
        $req = self::$_db->prepare($sql);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
    
}    
?>