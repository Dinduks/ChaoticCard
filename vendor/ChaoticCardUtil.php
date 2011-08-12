<?php
class ChaoticCardUtil {

    function __construct() {
        
    }
    
    public static function dbExists($app){
        $dbParams = $app["db"]->getParams();
        if (file_exists($dbParams["path"]))
            return true;
        else
            return false;
    }
    
    public static function getAllPhoneNumbers($app) {
        $query = "SELECT id FROM phonenumber";
        $result = $app["db"]->query($query);
        $allPhoneNumbers = array();
        foreach ($result as $id) {
            $allPhoneNumbers[] = new PhoneNumber($app, $id);
        }
        return $allPhoneNumbers;
    }
    
    public static function createDb($app) {
        $dbParams = $app["db"]->getParams();
        if (self::dbExists($app))
            unlink($dbParams["path"]);
        
        $createTables = array();
        $createTables[] = 'CREATE TABLE admin(
            ID INTEGER NOT NULL PRIMARY KEY,
            username VARCHAR(255),
            password VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE card(
            ID INTEGER NOT NULL PRIMARY KEY,
            firstname VARCHAR(255),
            lastname VARCHAR(255),
            profilepicture VARCHAR(255),
            title VARCHAR(255),
            secondarytitle varchar(255),
            birthday date,
            about longtext
            );';
        $createTables[] = 'CREATE TABLE email(
            ID INTEGER NOT NULL PRIMARY KEY,
            email VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE phonenumber(
            ID INTEGER NOT NULL PRIMARY KEY,
            phonenumber VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE website(
            ID INTEGER NOT NULL PRIMARY KEY,
            url VARCHAR(255),
            title VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE link(
            ID INTEGER NOT NULL PRIMARY KEY,
            url VARCHAR(255),
            title VARCHAR(255),
            icon VARCHAR(255)
            )';
        
        foreach ($createTables as $query) {
            $app["db"]->query($query);
        }
    }
    
    public static function insertIntoDb($app, $POST, $FILES) {
        $username = $POST["username"];
        $password = $POST["password"];
        $firstname = $POST["firstname"];
        $lastname = $POST["lastname"];
        $profilepicture = $FILES["profilepicture"];
        $title = $POST["cardtitle"];
        $secondaryTitle = $POST["secondaryTitle"];
        $birthday = explode('/', $POST["birthday"]);
        $formatedDate = $birthday[2].'-'.$birthday[1].'-'.$birthday[0];
        $about = $POST["about"];
        $emails = $POST['email'];
        $phoneNumbers = $POST['phoneNumber'];
        $websiteUrls = $_POST['websiteurl'];
        $websiteTitles = $_POST['websitetitle'];
        $linkUrls = $POST['linkurl'];
        $linkTitles = $POST['linktitle'];
        $linkIcons = $FILES['linkicon'];
        
        $insertQueries = array();
        $insertQueries[] = "INSERT INTO admin(ID, username, password) VALUES (NULL, '$username', '".sha1($password)."');";
        $insertQueries[] = "INSERT INTO card(ID, firstname, lastname, profilepicture, title, secondaryTitle, birthday, about) VALUES (NULL, '$firstname', '$lastname', '".$profilepicture["name"]."', '$title', '$secondaryTitle', '$formatedDate', '$about');";
        foreach ($emails as $email) {
            if (!empty($email))
                $insertQueries[] = "INSERT INTO email(ID, email) VALUES (NULL, '$email');";
        }
        foreach ($phoneNumbers as $phoneNumber) {
            if (!empty($phoneNumber))
                $insertQueries[] = "INSERT INTO phonenumber(ID, phonenumber) VALUES (NULL, '$phoneNumber');";
        }
        foreach ($websiteUrls as $i=>$websiteUrl) {
            if (!empty($websiteUrl))
                if (!empty($websiteTitles[$i]))
                    $insertQueries[] = "INSERT INTO website(ID, url, title) VALUES (NULL, '$websiteUrl', '$websiteTitles[$i]);";
                else
                    $insertQueries[] = "INSERT INTO website(ID, url, title) VALUES (NULL, '$websiteUrl', '$websiteUrl');";
        }
        foreach ($linkUrls as $i=>$linkUrl) {
            $insertQueries[] = "INSERT INTO link(ID, url, title, icon) VALUES (NULL, '$linkUrl', '$linkTitles[$i]', '".$linkIcons["name"][$i]."');";
        }
        foreach ($insertQueries as $query) {
            $app["db"]->query($query);
        }
    }

}
?>
