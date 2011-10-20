<?php

class LinkTable {

    public static function getAllLinks(Doctrine\DBAL\Connection $db) {
        $query = 'SELECT * FROM link';
        $result = $db->fetchAll($query);
        
        $links = array();
        foreach ($result as $i=>$elem) {
            $links[] = new Link();
            $links[$i]->setId($elem['id']);
            $links[$i]->setUrl($elem['url']);
            $links[$i]->setTitle($elem['title']);
            $links[$i]->setIcon($elem['icon']);
            $links[$i]->setPosition($elem['position']);
        }
        
        return $links;
    }

}
