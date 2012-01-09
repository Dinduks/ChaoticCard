<?php

class EmailTable
{

    public static function getAllEmails(\Doctrine\DBAL\Connection $db, $raw = false)
    {
        $sql = 'SELECT * FROM email ORDER BY position ASC';
        $result = $db->fetchAll($sql);

        if ($raw) {
            foreach ($result as &$email) {
                $email = $email['email'];
            }
            return $result;
        } else {
            $emails = array();
            foreach ($result as $i => $elem) {
                $emails[] = new Models\Email();
                $emails[$i]->setId($elem['id']);
                $emails[$i]->setEmail($elem['email']);
                $emails[$i]->setPosition($elem['position']);
            }
            return $emails;
        }
    }
    
    public static function save(\Doctrine\DBAL\Connection $db, 
            Models\Email $email)
    {
        $query = "INSERT INTO email(email, position)
                  VALUES
                  ('" . 
                  sqlite_escape_string($email->getEmail()) . "', '" . 
                  sqlite_escape_string($email->getPosition()) . 
                  "')";
        $result = $db->executeQuery($query);
        
        return $result;
    }

}
