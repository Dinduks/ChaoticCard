<?php

class AdminTable {
    
    public static function load(Doctrine\DBAL\Connection $db) {
        $sql = 'SELECT * FROM admin';
        $result = $db->fetchAll($sql);
        
        $admin = new Admin();
        $admin->setId($result['id']);
        $admin->setUsername($result['username']);
        $admin->setPassword($result['password']);
        
        return $admin;
    }
}

?>
