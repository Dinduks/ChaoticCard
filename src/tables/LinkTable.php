<?php

class LinkTable
{

    public static function getAllLinks(\Doctrine\DBAL\Connection $db)
    {
        $query = 'SELECT * FROM link ORDER BY position ASC';
        $result = $db->fetchAll($query);

        $links = array();
        foreach ($result as $i => $elem) {
            $links[] = new Link();
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
                  $link->getUrl() . "', '" . 
                  $link->getTitle() . "', '" . 
                  $link->getIcon() . "', '" . 
                  $link->getPosition() . 
                  "')";
        $result = $db->executeQuery($query);

        return $result;
    }

}
