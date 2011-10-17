<?php

/**
 * Description of DataBase
 *
 * @author Samy
 */
class Database {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Database();
        }
        
        return self::$_instance;
    }

}
