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
 * Class linking the link table to the Link model
 * 
 * @category PHP
 * @package  ChaoticCard
 * @author   Samy Dindane <samy@dindane.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/Dinduks/ChaoticCard
 */
class LinkTable
{

    /**
     * Get the list of links
     *
     * @param Doctrine\DBAL\Connection $db The database object
     * 
     * @return Link An array with Link objects
     */
    public static function getAllLinks(Doctrine\DBAL\Connection $db)
    {
        $query = 'SELECT * FROM link';
        $result = $db->fetchAll($query);

        $links = array();
        foreach ($result as $i => $elem) {
            $links[] = new Link();
            $links[$i]->setId($elem['id']);
            $links[$i]->setUrl($elem['url']);
            $links[$i]->setTitle($elem['title']);
            $links[$i]->setIcon($elem['icon']);
            $links[$i]->setPosition($elem['position']);
        }

        return $links;
    }

}
