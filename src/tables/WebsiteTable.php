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
 * Class linking the website table to the Website model
 * 
 * @category PHP
 * @package  ChaoticCard
 * @author   Samy Dindane <samy@dindane.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/Dinduks/ChaoticCard
 */
class WebsiteTable
{

    /**
     * Get the list of websites
     * 
     * @param Doctrine\DBAL\Connection $db The database object
     * 
     * @return Website An array with Website objects
     */
    public static function getAllWebsites(Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM website ORDER BY position ASC';
        $result = $db->fetchAll($sql);

        $websites = array();
        foreach ($websites as $i => $elem) {
            $websites[] = new Website();
            $websites[$i]->setId($elem['id']);
            $websites[$i]->setUrl($elem['url']);
            $websites[$i]->setTitle($elem['title']);
            $websites[$i]->setPosition($elem['position']);
        }

        return $websites;
    }

}
