<?php

/**
 * This file is part of the ChaoticCard package.
 *
 * PHP version 5
 * 
 * @category PHP
 * @package  ChaoticCard
 * @author   Samy Dindane <samy@dindane.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/Dinduks/ChaoticCard
 */

/**
 * Class linking the phonenumber table to the Phonenumber model
 * 
 * @category PHP
 * @package  ChaoticCard
 * @author   Samy Dindane <samy@dindane.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/Dinduks/ChaoticCard
 */
class PhoneNumberTable
{

    /**
     * Get the list of phone numbers
     * 
     * @param Doctrine\DBAL\Connection $db The database object
     * 
     * @return Phonenumber An array with Phonenumber Objects
     * 
     */
    public static function getAllPhoneNumbers(Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM phonenumber ORDER BY position ASC';
        $result = $db->fetchAll($sql);

        $phoneNumbers = array();
        foreach ($phoneNumbers as $i => $elem) {
            $phoneNumbers[] = new Phonenumber();
            $phoneNumbers[$i]->setId($elem['id']);
            $phoneNumbers[$i]->setPhonenumber($elem['phonenumber']);
            $phoneNumbers[$i]->setPosition($elem['position']);
        }

        return $phoneNumbers;
    }

}
