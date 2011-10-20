<?php

class ChaoticCardUtil {

    function __construct() {
        
    }

    public static function dbExists($app) {
        $dbParams = $app["db"]->getParams();
        if (file_exists($dbParams["path"]))
            return true;
        else
            return false;
    }

    public static function createDb($app) {
        $dbParams = $app["db"]->getParams();
        if (self::dbExists($app))
            unlink($dbParams["path"]);

        $createTables = array();
        $createTables[] = 'CREATE TABLE admin(
            id INTEGER NOT NULL PRIMARY KEY,
            username VARCHAR(255),
            password VARCHAR(255)
            );';
        $createTables[] = 'CREATE TABLE card(
            id INTEGER NOT NULL PRIMARY KEY,
            firstname VARCHAR(255),
            lastname VARCHAR(255),
            profilepicture VARCHAR(255),
            title VARCHAR(255),
            secondarytitle varchar(255),
            birthday date,
            about longtext
            );';
        $createTables[] = 'CREATE TABLE email(
            id INTEGER NOT NULL PRIMARY KEY,
            email VARCHAR(255),
            position INTEGER UNIQUE
            );';
        $createTables[] = 'CREATE TABLE phonenumber(
            id INTEGER NOT NULL PRIMARY KEY,
            phonenumber VARCHAR(255),
            position INTEGER UNIQUE
            );';
        $createTables[] = 'CREATE TABLE website(
            id INTEGER NOT NULL PRIMARY KEY,
            url VARCHAR(255),
            title VARCHAR(255),
            position INTEGER UNIQUE
            );';
        $createTables[] = 'CREATE TABLE link(
            id INTEGER NOT NULL PRIMARY KEY,
            url VARCHAR(255),
            title VARCHAR(255),
            icon VARCHAR(255),
            position INTEGER UNIQUE
            );';

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
        $formatedDate = $birthday[2] . '-' . $birthday[1] . '-' . $birthday[0];
        $about = $POST["about"];
        $emails = $POST['email'];
        $phoneNumbers = $POST['phoneNumber'];
        $websiteUrls = $_POST['websiteurl'];
        $websiteTitles = $_POST['websitetitle'];
        $linkUrls = $POST['linkurl'];
        $linkTitles = $POST['linktitle'];
        $linkIcons = $FILES['linkicon'];

        $insertQueries = array();
        $insertQueries[] = "INSERT INTO admin(id, username, password) VALUES (NULL, '$username', '" . sha1($password) . "');";
        $insertQueries[] = "INSERT INTO card(id, firstname, lastname, profilepicture, title, secondaryTitle, birthday, about) VALUES (NULL, '$firstname', '$lastname', '" . $profilepicture["name"] . "', '$title', '$secondaryTitle', '$formatedDate', '$about');";
        
        $position = 0;
        foreach ($emails as $email) {
            if (!empty($email))
                $insertQueries[] = "INSERT INTO email(id, email, position) VALUES (NULL, '$email', '$position');";
            $position += 5;
        }
        
        $position = 0;
        foreach ($phoneNumbers as $phoneNumber) {
            if (!empty($phoneNumber)) {
                $insertQueries[] = "INSERT INTO phonenumber(id, phonenumber, position) VALUES (NULL, '$phoneNumber', '$position');";
                $position += 5;
            }
        }
        
        $position = 0;
        foreach ($websiteUrls as $i => $websiteUrl) {
            if (!empty($websiteUrl))
                if (!empty($websiteTitles[$i]))
                    $insertQueries[] = "INSERT INTO website(id, url, title, position) VALUES (NULL, '$websiteUrl', '$websiteTitles[$i]', '$position');";
                else
                    $insertQueries[] = "INSERT INTO website(id, url, title, position) VALUES (NULL, '$websiteUrl', '$websiteUrl', '$position');";
            $position += 5;
        }
        
        $position = 0;
        foreach ($linkUrls as $i => $linkUrl) {
            $insertQueries[] = "INSERT INTO link(id, url, title, icon, position) VALUES (NULL, '$linkUrl', '$linkTitles[$i]', '" . $linkIcons["name"][$i] . "', '$position');";
            $position += 5;
        }
        
        foreach ($insertQueries as $query) {
            $app["db"]->query($query);
        }
    }

    public static function getClientLanguage() {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            return substr($langs[0], 0, 2);
        } else {
            return 'en';
        }
    }

}

?>
