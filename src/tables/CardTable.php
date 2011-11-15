<?php

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
        $card->setBirthday($result['birthday']);

        return $card;
    }

}
