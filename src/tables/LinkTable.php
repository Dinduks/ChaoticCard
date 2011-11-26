<?php

class LinkTable
{

    public static function getAllLinks(\Doctrine\DBAL\Connection $db)
    {
        $query = 'SELECT * FROM link ORDER BY position ASC';
        $result = $db->fetchAll($query);

        $links = array();
        foreach ($result as $i => $elem) {
            $links[] = new Models\Link();
            $links[$i]->setId($elem['id']);
            $links[$i]->setUrl($elem['url']);
            $links[$i]->setTitle($elem['title']);
            $links[$i]->setIcon($elem['icon']);
            $links[$i]->setPosition($elem['position']);
        }

        return $links;
    }

    public static function save(\Doctrine\DBAL\Connection $db, \Models\Link $link)
    {
        $query = "INSERT INTO link(url, title, icon, position)
                  VALUES
                  ('" . 
                  sqlite_escape_string($link->getUrl()) . "', '" . 
                  sqlite_escape_string($link->getTitle()) . "', '" . 
                  sqlite_escape_string($link->getIcon()) . "', '" . 
                  sqlite_escape_string($link->getPosition()) . 
                  "')";
        $result = $db->executeQuery($query);

        return $result;
    }

}
