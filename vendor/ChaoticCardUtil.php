<?php

class ChaoticCardUtil 
{

    public static function getClientLanguage($possibleLocales, $defaultLocale = 'en')
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browsersLocale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

            if (in_array($browsersLocale, $possibleLocales))
                return $browsersLocale;
            else
                return $defaultLocale;
        } else {
            return $defaultLocale;
        }
    }
    
    public static function createDb($app)
    {
        $dbParams = $app['db']->getParams();
        if (file_exists($dbParams["path"])) {
            unlink($dbParams["path"]);
        }

        $migrationFiles = scandir($app['migrationsDir']);
        unset($migrationFiles[0]);
        unset($migrationFiles[1]);
        
        foreach ($migrationFiles as $migrationFile) {
            $queries = explode(';', file_get_contents($app['migrationsDir'] . $migrationFile));
            foreach ($queries as $query) {
                $app['db']->executeQuery($query);
            }
        }
    }
    
    public static function insertIntoDb($post, $files, $db)
    {
        $admin = new \Models\Admin($post['username'], $post['password']);
        AdminTable::save($db, $admin);
        
        $card = new \Models\Card(
                $post['firstname'], 
                $post['lastname'],  
                $files['profilepicture']['name'],
                $post['cardtitle'], 
                new DateTime($post['birthday']),
                '', 
                $post['analytics']);
        CardTable::save($db, $card);
        
        foreach ($post['email'] as $i=>$elem) {
            $email = new \Models\Email($post['email'][$i], $post['emailPosition'][$i]);
            EmailTable::save($db, $email);
        }
        
        foreach ($post['phoneNumber'] as $i=>$elem) {
            $phoneNumber = new \Models\Phonenumber($post['phoneNumber'][$i], $post['phoneNumberPosition'][$i]);
            PhoneNumberTable::save($db, $phoneNumber);
        }
        
        foreach ($post['websiteurl'] as $i=>$elem) {
            if (empty($post['websitetitle'][$i]))
                $website = new \Models\Website($post['websiteurl'][$i], $post['websiteurl'][$i], $post['websitePosition'][$i]);
            $website = new \Models\Website($post['websiteurl'][$i], $post['websitetitle'][$i], $post['websitePosition'][$i]);
            WebsiteTable::save($db, $website);
        }
        
        foreach ($post['linkurl'] as $i=>$elem) {
            $link = new \Models\Link($post['linkurl'][$i], $post['linktitle'][$i], $files['linkicon']['name'][$i], $post['linkPosition'][$i]);
            LinkTable::save($db, $link);
        }
        
        $langs = explode(' ', $post['lang']);
        foreach ($langs as $lang) {
            LangTable::save($db, new \Models\Lang($lang));
        }
        
        $textCounter = 1;
        
        $secondaryTitles = array_map('sqlite_escape_string', $post["secondaryTitle"]);
        foreach ($secondaryTitles as $i=>$secondaryTitle) {
            $langId = ++$i;
            TextTable::save($db, new Models\Text($secondaryTitle, 'secondaryTitle'));
            ContentTable::save($db, new Models\Content($langId, $textCounter));
            $textCounter++;
        }
        
        $aboutArray = array_map('sqlite_escape_string', $post["about-content"]);
        foreach ($aboutArray as $i=>$about) {
            $langId = ++$i;
            TextTable::save($db, new Models\Text($about, 'about'));
            ContentTable::save($db, new Models\Content($langId, $textCounter));
            $textCounter++;
        }
    }
    
    public static function getTheme($db)
    {
        return CardTable::getTheme($db);
    }

    public static function getPossibleLocales($filesList)
    {
        unset($filesList[0]);
        unset($filesList[1]);
        foreach ($filesList as &$file) {
            $file = explode('.', $file);
            $file = $file[0];
        }
        return $filesList;
    }

}
