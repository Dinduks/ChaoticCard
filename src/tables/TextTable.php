<?php

class TextTable
{

    public static function getText(Doctrine\DBAL\Connection $db, $lang, $category)
    {
        $sql = "SELECT t.id, t.text FROM content c
                LEFT JOIN lang l ON c.lang_id = l.id
                LEFT JOIN text t ON c.text_id = t.id
                WHERE l.lang = '$lang'
                AND t.category = '$category'";
        $result = $db->fetchAll($sql);

        $text = new Text();
        $text->setId($result[0]['id']);
        $text->setText($result[0]['text']);

        return $text;
    }

}
