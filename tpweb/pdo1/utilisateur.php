<?php
    require_once 'ConnectionDB.php';

 class Utilisateur {

    private static $_db ;
    public static function getinstance() {
        if (!isset(self::$_db)) {
        self::$_db = ConnectionBD::getInstance();
        self::init();
    }
    }
    public static function init() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS utilisateur (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255),
                password VARCHAR(255),
                role VARCHAR(5) DEFAULT 'user'
            )";
            self::$_db->exec($sql);
            $sql = "INSERT INTO utilisateur (username, email, password, role) VALUES ('admin', 'admin@insat.tn', 'admin', 'admin')";
            self::$_db->exec($sql);
        } catch(Exception $e) {
            die("creation de utilisateur failed: " . $e->getMessage());
        }
    }
    public static function getUtilisateur($email) {
        $sql = "SELECT * FROM utilisateur WHERE email=:email";
        $req = self::$_db->prepare($sql);
        $req->execute(array("email" => $email));
        $utilisateur = $req->fetch(PDO::FETCH_ASSOC);
        return $utilisateur;
    }
    public static function addUtilisateur($username, $email,$password) {
        $sql = "INSERT INTO utilisateur (username, email, password) VALUES (:username, :email, :password)";
        $req = self::$_db->prepare($sql);
        $req->execute(array("username" => $username, "email" => $email, "password" => $password));
    }
    public static function getUtilisateurById($id) {
        $sql = "SELECT * FROM utilisateur WHERE id=:id";
        $req = self::$_db->prepare($sql);
        $req->execute(array("id" => $id));
        $utilisateur = $req->fetch(PDO::FETCH_ASSOC);
        return $utilisateur;
    }
    
}
?>