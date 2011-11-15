<?php

class ChaoticCardUtil 
{

    public static function dbExists($app)
    {
        $dbParams = $app["db"]->getParams();
        if (file_exists($dbParams["path"])) {
            return true;
        } else {
            return false;
        }
    }

    public static function createDb($app)
    {
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
            birthday date
            );';
        $createTables[] = "CREATE TABLE email(
            id INTEGER NOT NULL PRIMARY KEY,
            email VARCHAR(255),
            position INTEGER NOT NULL DEFAULT '0'
            );";
        $createTables[] = "CREATE TABLE phonenumber(
            id INTEGER NOT NULL PRIMARY KEY,
            phonenumber VARCHAR(255),
            position INTEGER NOT NULL DEFAULT '0'
            );";
        $createTables[] = "CREATE TABLE website(
            id INTEGER NOT NULL PRIMARY KEY,
            url VARCHAR(255),
            title VARCHAR(255),
            position INTEGER NOT NULL DEFAULT '0'
            );";
        $createTables[] = "CREATE TABLE link(
            id INTEGER NOT NULL PRIMARY KEY,
            url VARCHAR(255),
            title VARCHAR(255),
            icon VARCHAR(255),
            position INTEGER NOT NULL DEFAULT '0'
            );";
        $createTables[] = "CREATE TABLE lang(
            id INTEGER NOT NULL PRIMARY KEY,
            lang VARCHAR(255)
            );";
        $createTables[] = "CREATE TABLE text(
            id INTEGER NOT NULL PRIMARY KEY,
            text longtext,
            category VARCHAR(255)
            );";
        $createTables[] = "CREATE TABLE content(
            id INTEGER NOT NULL PRIMARY KEY,
            lang_id INTEGER,
            text_id INTEGER,
            FOREIGN KEY(lang_id) REFERENCES lang(id),
            FOREIGN KEY(text_id) REFERENCES text(id)
            );";

        foreach ($createTables as $query) {
            $app["db"]->query($query);
        }
    }

    public static function insertIntoDb($app, $POST, $FILES)
    {
        $langs = explode(' ', $_POST['lang']);
        
        $username = sqlite_escape_string($POST["username"]);
        $password = sqlite_escape_string($POST["password"]);
        
        $firstname = sqlite_escape_string($POST["firstname"]);
        $lastname = sqlite_escape_string($POST["lastname"]);
        $profilepicture = $FILES["profilepicture"];
        $title = sqlite_escape_string($POST["cardtitle"]);
        $secondaryTitles = array_map('sqlite_escape_string', $POST["secondaryTitle"]);
        $birthday = explode('/', $POST["birthday"]);
        $formatedDate = $birthday[2] . '-' . $birthday[1] . '-' . $birthday[0];
        $aboutArray = array_map('sqlite_escape_string', $POST["about-content"]);
        
        $emails = array_map('sqlite_escape_string', $POST['email']);
        $emailsPositions = array_map('sqlite_escape_string', $POST['emailPosition']);
        
        $phoneNumbers = array_map('sqlite_escape_string', $POST['phoneNumber']);
        $phoneNumbersPositions = array_map('sqlite_escape_string', $POST['phoneNumberPosition']);
        
        $websitesUrls = array_map('sqlite_escape_string', $_POST['websiteurl']);
        $websitesTitles = array_map('sqlite_escape_string', $_POST['websitetitle']);
        $websitesPositions = array_map('sqlite_escape_string', $_POST['websitePosition']);
        
        $linksUrls = array_map('sqlite_escape_string', $POST['linkurl']);
        $linksTitles = array_map('sqlite_escape_string', $POST['linktitle']);
        $linksIcons = $FILES['linkicon'];
        $linksPositions = array_map('sqlite_escape_string', $POST['linkPosition']);

        $insertQueries = array();
        $insertQueries[] = "INSERT INTO admin(username, password) 
                            VALUES ('$username', '" . sha1($password) . "');";
        $insertQueries[] = "INSERT INTO card(id, firstname, lastname, profilepicture, 
                                             title, birthday) 
                            VALUES (NULL, '$firstname', '$lastname', '{$profilepicture['name']}', 
                                    '$title', '$formatedDate');";
        
        $position = '';
        
        foreach ($emails as $i => $email) {
            if (!empty($email))
                $insertQueries[] = "INSERT INTO email(id, email, position) 
                                    VALUES (NULL, '$email', '$emailsPositions[$i]');";
        }
        
        foreach ($phoneNumbers as $i => $phoneNumber) {
            if (!empty($phoneNumber)) {
                $insertQueries[] = "INSERT INTO phonenumber(id, phonenumber, position) 
                                    VALUES (NULL, '$phoneNumber', '$phoneNumbersPositions[$i]');";
            }
        }
        
        foreach ($websitesUrls as $i => $websiteUrl) {
            if (!empty($websiteUrl))
                if (!empty($websitesTitles[$i]))
                    $insertQueries[] = "INSERT INTO website(url, title, position) 
                                        VALUES ('$websiteUrl', '$websitesTitles[$i]', '$position');";
                else
                    $insertQueries[] = "INSERT INTO website(url, title, position) 
                                        VALUES ('$websiteUrl', '$websiteUrl', '$websitesPositions[$i]');";
        }
        
        foreach ($linksUrls as $i => $linkUrl) {
            $insertQueries[] = "INSERT INTO link(url, title, icon, position) 
                                VALUES ('$linkUrl', '$linksTitles[$i]', '" . $linksIcons["name"][$i] . "', 
                                        '$linksPositions[$i]');";
        }
        
        foreach ($langs as $lang) {
            $insertQueries[] = "INSERT INTO lang(lang) VALUES ('$lang');";
        }
        
        $textCounter = 1;
        foreach ($secondaryTitles as $i=>$secondaryTitle) {
            $langId = ++$i;
            $insertQueries[] = "INSERT INTO text(text, category) VALUES ('$secondaryTitle', 'secondaryTitle');";
            $insertQueries[] = "INSERT INTO content(text_id, lang_id) VALUES ('$textCounter', '$langId');";
            $textCounter++;
        }
        
        foreach ($aboutArray as $i=>$about) {
            $langId = ++$i;
            $insertQueries[] = "INSERT INTO text(text, category) VALUES ('$about', 'about');";
            $insertQueries[] = "INSERT INTO content(text_id, lang_id) VALUES ('$textCounter', '$langId');";
        }
        
        foreach ($insertQueries as $query) {
            $app["db"]->query($query);
        }
    }

    public static function getClientLanguage() 
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            return substr($langs[0], 0, 2);
        } else {
            return 'en';
        }
    }

}
