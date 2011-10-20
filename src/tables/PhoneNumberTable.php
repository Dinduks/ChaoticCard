<?php

class PhoneNumberTable {

    public static function getAllPhoneNumbers(Doctrine\DBAL\Connection $db) {
        $sql = 'SELECT * FROM phonenumber';
        $result = $db->fetchAll($sql);

        $phoneNumbers = array();
        foreach ($phoneNumbers as $i => $elem) {
            $phoneNumbers[] = new PhoneNumber();
            $phoneNumbers[$i]->setId($elem['id']);
            $phoneNumbers[$i]->setPhonenumber($elem['phonenumber']);
        }

        return $phoneNumbers;
    }

}
