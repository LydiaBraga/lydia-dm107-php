<?php 

require "config.php";

class Banco {
    protected static $db;

    private function __construct() {
        try {
            $host = HOST;
            $dbName = BANCO;
            $user = USER;
            $pass = PASS;
            
            $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            self::$db = new NotORM($pdo);
        } catch(PDOException $e) {
            print "Error ao conectar no banco de dados! " . $e->getMessage();
            die();
        }
    }
    public static function getConnection() {
        if (!self::$db) {
            new Banco();
        }

        return self::$db;
    }
}
?>