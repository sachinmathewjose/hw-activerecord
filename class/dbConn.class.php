<?php
//definition for connection
define('DATABASE', 'sj555');
define('USERNAME', 'sj555');
define('PASSWORD', 'mYSZqqZ9S');
define('CONNECTION', 'sql2.njit.edu');

class dbConn {
    protected static $db;

    private function __construct() {

        try {
            self::$db = new PDO( 'mysql:host='.CONNECTION.';dbname='.DATABASE,USERNAME,PASSWORD);
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exception) {
            echo "Connection Error: " . $exception->getMessage();
        }
    }

    static function getconnection() {
        if(!self::$db) {
            new dbConn();
        }
        return self::$db;
    }
}
?>