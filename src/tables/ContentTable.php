<?php

class ContentTable
{
    
    public static function save(\Doctrine\DBAL\Connection $db, 
            Models\Content $content)
    {
        $query = "INSERT INTO content(lang_id, text_id)
                  VALUES
                  ('" . $content->getLangId() . "', '" . $content->getTextId() . "')";
        $result = $db->executeQuery($query);
        
        return $result;
    }

}
