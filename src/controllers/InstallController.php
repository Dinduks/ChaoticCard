<?php

class InstallController
{

    /**
     *
     * @var Silex\Application
     */
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function index()
    {
        $dbParams = $this->app['db']->getParams();
        if (file_exists($dbParams["path"])) {
            return $this->app->redirect("/");
        } else {
            return $this->newCard();
        }
    }

    public function newCard()
    {

        if ($_POST) {
            $linkIcons = $_FILES['linkicon'];

            $this->createDb();
            $this->insertIntoDb($_POST, $_FILES);

            foreach ($_FILES["linkicon"]["name"] as $i => $linkIconName) {
                move_uploaded_file(
                        $linkIcons["tmp_name"][$i], __DIR__ . '/../../web/images/icons/' . $linkIcons["name"][$i]
                );
            }

            move_uploaded_file(
                    $_FILES["profilepicture"]["tmp_name"], __DIR__ . "/../../web/images/" . $_FILES["profilepicture"]["name"]
            );

            return $this->app->redirect("/");
        } else {
            return $this->app['twig']->render('install.html.twig', array(
                        "formType" => "new",
                    ));
        }
    }
    
    protected function createDb()
    {
        $dbParams = $this->app['db']->getParams();
        if (file_exists($dbParams["path"])) {
            unlink($dbParams["path"]);
        }

        $queries = explode(';', file_get_contents($this->app['dbSqlPath']));
        foreach ($queries as $query) {
            $this->app['db']->executeQuery($query);
        }
    }
    
    public function insertIntoDb($post, $files)
    {
        $db = $this->app['db'];
        
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

}
