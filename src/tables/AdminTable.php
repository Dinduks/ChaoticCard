<?php

class AdminTable
{

    public static function load(\Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM admin';
        $result = $db->fetchAll($sql);

        $admin = new Admin();
        $admin->setId($result['id']);
        $admin->setUsername($result['username']);
        $admin->setPassword($result['password']);

        return $admin;
    }

    public static function save(\Doctrine\DBAL\Connection $db, \Models\Admin $admin)
    {
        $query = "INSERT INTO admin(username, password)
                VALUES
                ('" . sqlite_escape_string($admin->getUsername()) . "', '" . sha1($admin->getPassword()) . "')";
        $result = $db->executeQuery($query);

        return $result;
    }

}
