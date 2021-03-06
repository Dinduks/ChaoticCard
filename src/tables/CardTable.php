<?php

class CardTable
{

    public static function load(\Doctrine\DBAL\Connection $db)
    {
        $sql = 'SELECT * FROM card';
        $result = $db->fetchAssoc($sql);

        $card = new Models\Card();
        $card->setId($result['id']);
        $card->setFirstname($result['firstname']);
        $card->setLastname($result['lastname']);
        $card->setProfilepicture($result['profilepicture']);
        $card->setTitle($result['title']);
        $card->setBirthday($result['birthday']);
        $card->setTheme($result['theme']);
        $card->setAnalytics($result['analytics']);
        $card->setGravatarEmail($result['gravatar_email']);

        return $card;
    }
    
    public static function save(\Doctrine\DBAL\Connection $db, \Models\Card $card)
    {
        $query = "INSERT INTO card(firstname, lastname, profilepicture, title, birthday, theme, analytics)
                VALUES
                (
                    '" . sqlite_escape_string($card->getFirstname()) . "', " .
                    "'" . sqlite_escape_string($card->getLastname()) . "', " .
                    "'" . sqlite_escape_string($card->getProfilepicture()) . "', " .
                    "'" . sqlite_escape_string($card->getTitle()) . "', " .
                    "'" . $card->getBirthday()->getTimestamp() . "', " .
                    "'" . sqlite_escape_string($card->getTheme()) . "', " .
                    "'" . sqlite_escape_string($card->getAnalytics()) . "', " .
                    "'" . sqlite_escape_string($card->getGravatarEmail()) . "'" .
                ")";
        $result = $db->executeQuery($query);
        
        return $result;
    }
    
    public static function getTheme(\Doctrine\DBAL\Connection $db)
    {
        $query = "SELECT theme FROM card WHERE id = '1'";
        return $db->fetchColumn($query);
    }

}
