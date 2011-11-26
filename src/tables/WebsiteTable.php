<?php

class WebsiteTable
{

    public static function getAllWebsites(\Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM website ORDER BY position ASC';
        $result = $db->fetchAll($sql);

        $websites = array();
        foreach ($result as $i => $elem) {
            $websites[] = new Models\Website();
            $websites[$i]->setId($elem['id']);
            $websites[$i]->setUrl($elem['url']);
            $websites[$i]->setTitle($elem['title']);
            $websites[$i]->setPosition($elem['position']);
        }

        return $websites;
    }

    public static function save(\Doctrine\DBAL\Connection $db, \Models\Website $website)
    {
        $query = "INSERT INTO website(url, title, position)
                VALUES
                ('" .
                sqlite_escape_string($website->getUrl()) . "', '" .
                sqlite_escape_string($website->getTitle()) . "', '" .
                sqlite_escape_string($website->getPosition()) .
                "')";
        $result = $db->executeQuery($query);

        return $result;
    }

}
