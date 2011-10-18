<?php

/**
 * Description of DataBase
 *
 * @author Samy
 */
class Database {

    private static $_instance = null;

    public function __construct($db) {
        self::$_instance = $db;
    }

    public static function getInstance() {
        return self::$_instance;
    }

}
