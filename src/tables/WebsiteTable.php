<?php

class WebsiteTable {

    public static function getAllWebsites(Doctrine\DBAL\Connection $db) {
        $sql = 'SELECT * FROM website';
        $result = $db->fetchAll($sql);
        
        $websites = array();
        foreach ($websites as $i=>$elem) {
            $websites[] = new Website();
            $websites[$i]->setId($elem['id']);
            $websites[$i]->setUrl($elem['url']);
            $websites[$i]->setTitle($elem['title']);
            $websites[$i]->setPosition($elem['position']);
        }
        
        return $websites;
    }

}
