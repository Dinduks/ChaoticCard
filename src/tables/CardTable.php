<?php

class CardTable {

    public static function load(Doctrine\DBAL\Connection $db) {
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
