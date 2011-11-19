<?php

class HomepageController
{

    function __construct($app)
    {
        $this->app = $app;
    }

    function index()
    {
        if (!ChaoticCardUtil::dbExists($this->app))
            return $this->app->redirect("/install");

        $db = $this->app['db'];

        $card = CardTable::load($db);
        $links = LinkTable::getAllLinks($db);
        $emails = EmailTable::getAllEmails($db);
        $websites = WebsiteTable::getAllWebsites($db);
        $phonenumbers = PhoneNumberTable::getAllPhoneNumbers($db);
        
        // transforms the email adresses to a string of ASCII chars
        // (to protect them from spam crawlers)
        $emailsArray = array();
        foreach ($emails as $i=>$email) {
            $strEmail = str_split($email->getEmail());
            $emailsArray[$i] = '';
            foreach ($strEmail as $char) {
                $emailsArray[$i] .= '&#' . ord($char) . ';';
            }
        }
        
        $about = TextTable::getText($db, $this->app['lang'], 'about')->getText();
        $secondaryTitle = TextTable::getText($db, $this->app['lang'], 'secondaryTitle')->getText();

        return $this->app['twig']->render('homepage.html.twig', array(
                    'card' => $card,
                    'links' => $links,
                    'emails' => $emailsArray,
                    'websites' => $websites,
                    'phonenumbers' => $phonenumbers,
                    'about' => $about,
                    'secondaryTitle' => $secondaryTitle
                ));
    }

}
