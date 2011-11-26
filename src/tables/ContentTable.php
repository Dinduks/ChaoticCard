<?php

class ContentTable
{
    
    public static function save(\Doctrine\DBAL\Connection $db, 
            Models\Content $content)
    {
        $query = "INSERT INTO content(langId, textId)
                  VALUES
                  ('" . $content->getLangId() . "', '" . $content->getTextId() . "')";
        $result = $db->executeQuery($query);
        
        return $result;
    }

}
