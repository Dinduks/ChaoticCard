<?php

class PhoneNumberTable
{

    public static function getAllPhoneNumbers(\Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM phonenumber ORDER BY position ASC';
        $result = $db->fetchAll($sql);

        $phoneNumbers = array();
        foreach ($result as $i => $elem) {
            $phoneNumbers[] = new Models\Phonenumber();
            $phoneNumbers[$i]->setId($elem['id']);
            $phoneNumbers[$i]->setPhonenumber($elem['phonenumber']);
            $phoneNumbers[$i]->setPosition($elem['position']);
        }
        
        return $phoneNumbers;
    }
    
    public static function save(\Doctrine\DBAL\Connection $db, 
            Models\Phonenumber $phoneNumber)
    {
        $query = "INSERT INTO phonenumber(phonenumber, position)
                  VALUES
                  ('" . 
                  sqlite_escape_string($phoneNumber->getPhoneNumber()) . "', '" . 
                  sqlite_escape_string($phoneNumber->getPosition()) . 
                  "')";
        $result = $db->executeQuery($query);
        
        return $result;
    }

}
