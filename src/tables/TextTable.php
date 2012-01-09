<?php

use Models\Text;

class TextTable
{

    public static function getText(\Doctrine\DBAL\Connection $db, $lang, $category)
    {
        $sql = "SELECT t.id, t.text FROM content c
                LEFT JOIN lang l ON c.lang_id = l.id
                LEFT JOIN text t ON c.text_id = t.id
                WHERE l.lang = '$lang'
                AND t.category = '$category'";
        $result = $db->fetchAssoc($sql);

        if (empty($result)) {
            return new Text();
        } else {
            $text = new Text();
            $text->setId($result['id']);
            $text->setText($result['text']);
            return $text;
        }
    }
    
    public static function save(\Doctrine\DBAL\Connection $db, Text $text)
    {
        $query = "INSERT INTO text(text, category)
                  VALUES
                  ('" . $text->getText() . "', '" . $text->getCategory() . "')";
        $result = $db->executeQuery($query);
        
        return $result;
    }

}
