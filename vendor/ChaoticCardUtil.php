<?php
class ChaoticCardUtil {

    function __construct() {
        
    }
    
    public static function createDb($app) {
        $dbParams = $app["db"]->getParams();
        unlink($dbParams["path"]);
        
        $createTables = array();
        $createTables[] = 'CREATE TABLE admin(
            ID BIGINT(11) NOT NULL PRIMARY KEY,
            username VARCHAR(255),
            password VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE card(
            ID BIGINT(11) NOT NULL PRIMARY KEY,
            firstname VARCHAR(255),
            lastname VARCHAR(255),
            title VARCHAR(255),
            secondarytitle varchar(255),
            birthday date,
            about longtext
            );';
        $createTables[] = 'CREATE TABLE email(
            ID BIGINT(11) NOT NULL PRIMARY KEY,
            email VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE phonenumber(
            ID BIGINT(11) NOT NULL PRIMARY KEY,
            phonenumber VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE website(
            ID BIGINT(11) NOT NULL PRIMARY KEY,
            url VARCHAR(255),
            title VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE link(
            ID BIGINT(11) NOT NULL PRIMARY KEY,
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
        $title = $POST["cardtitle"];
        $secondaryTitle = $POST["secondaryTitle"];
        $birthday = explode('/', $POST["birthday"]);
        $formatedDate = $birthday[2].'-'.$birthday[1].'-'.$birthday[0];
        $about = $POST["about"];
        $emails = $POST['email'];
        $phoneNumbers = $POST['phoneNumber'];
        $websites = $POST['website'];
        $linkUrls = $POST['linkurl'];
        $linkTitles = $POST['linktitle'];
        $linkIcons = $FILES['linkicon'];
        
        $insertQueries = array();
        $insertQueries[] = "INSERT INTO admin(ID, username, password) VALUES ('', '$username', '".sha1($password)."');";
        $insertQueries[] = "INSERT INTO card(ID, firstname, lastname, title, secondaryTitle, birthday, about) VALUES ('', '$firstname', '$lastname', '$title', '$secondaryTitle', '$formatedDate', '$about');";
        foreach ($emails as $email) {
            $insertQueries[] = "INSERT INTO email(ID, email) VALUES ('', '$email');";
        }
        foreach ($phoneNumbers as $phoneNumber) {
            $insertQueries[] = "INSERT INTO phonenumber(ID, phonenumber) VALUES ('', '$phoneNumber');";
        }
        foreach ($websites as $website) {
            $insertQueries[] = "INSERT INTO website(ID, url, title) VALUES ('', '$website', '');";
        }
        foreach ($linkUrls as $i=>$linkUrl) {
            $insertQueries[] = "INSERT INTO link(ID, url, title, icon) VALUES ('', '$linkUrl', '$linkTitles[$i]', '".$linkIcons["name"][$i]."');";
        }
        foreach ($insertQueries as $query) {
            $app["db"]->query($query);
        }
    }

}
?>
