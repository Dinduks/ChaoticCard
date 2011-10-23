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
 * Class linking the email table to the Email model
 * 
 * @category PHP
 * @package  ChaoticCard
 * @author   Samy Dindane <samy@dindane.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/Dinduks/ChaoticCard
 */
class EmailTable
{

    /**
     * Get the list of emails
     *
     * @param Doctrine\DBAL\Connection $db The database object
     * 
     * @return Email An array with Email objects
     */
    public static function getAllEmails(Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM email ORDER BY position ASC';
        $result = $db->fetchAll($sql);

        $emails = array();
        foreach ($result as $i => $elem) {
            $emails[] = new Email();
            $emails[$i]->setId($elem['id']);
            $emails[$i]->setEmail($elem['email']);
            $emails[$i]->setPosition($elem['position']);
        }

        return $emails;
    }

}
