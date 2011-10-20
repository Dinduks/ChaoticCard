    <?php

class EmailTable {

    public static function getAllEmails(Doctrine\DBAL\Connection $db) {
        $sql = 'SELECT * FROM email';
        $result = $db->fetchAll($sql);
                
        $emails = array();
        foreach ($result as $i=>$elem) {
            $emails[] = new Email();
            $emails[$i]->setId($elem['id']);
            $emails[$i]->setEmail($elem['email']);
        }
        
        return $emails;
    }

}
