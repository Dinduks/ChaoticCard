<?php

class LangTable
{
    
    public static function save(\Doctrine\DBAL\Connection $db, 
            Models\Lang $lang)
    {
        $query = "INSERT INTO lang(lang)
                  VALUES
                  ('" . sqlite_escape_string($lang->getLang()) . "')";
        $result = $db->executeQuery($query);
        
        return $result;
    }

}
