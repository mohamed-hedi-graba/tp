<?php
class ConnectionBD {
    private static $_dbhost = "db";
    private static $_usrname = "root";
    private static $_password = "password";
    private static $_dbname = "tp";
    private static $_bdd = null;
    
    private function __construct() {
        try {
            $conn = new PDO(
                'mysql:host='.self::$_dbhost,
                self::$_usrname, 
                self::$_password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
            
            $conn->exec("CREATE DATABASE IF NOT EXISTS ".self::$_dbname." 
                           CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            self::$_bdd = new PDO(
                'mysql:host='.self::$_dbhost.';dbname='.self::$_dbname,
                self::$_usrname, 
                self::$_password,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch(PDOException $e) {
            die('Error: '.$e->getMessage());  
        }
    }
    
    public static function getInstance() {
        if(!self::$_bdd) {
            new ConnectionBD(); 
        }
        return (self::$_bdd);
    }
    
}
?>