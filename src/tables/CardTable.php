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
 * Class linking the card table to the Card model
 * 
 * @category PHP
 * @package  ChaoticCard
 * @author   Samy Dindane <samy@dindane.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/Dinduks/ChaoticCard
 */
class CardTable
{

    /**
     * Load the card (site) info
     *
     * @param Doctrine\DBAL\Connection $db The database object
     * 
     * @return Card A Card object containing all info about the site
     */
    public static function load(Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM card';
        $result = $db->fetchAssoc($sql);

        $card = new Card();
        $card->setId($result['id']);
        $card->setFirstname($result['firstname']);
        $card->setLastname($result['lastname']);
        $card->setProfilepicture($result['profilepicture']);
        $card->setTitle($result['title']);
        $card->setSecondarytitle($result['secondarytitle']);
        $card->setBirthday($result['birthday']);
        $card->setAbout($result['about']);

        return $card;
    }

}
