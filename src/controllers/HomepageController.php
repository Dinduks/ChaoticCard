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

        return $this->app['twig']->render('homepage.html.twig', array(
                    "title" => $card->getTitle() . ", " . $card->getSecondarytitle(),
                    "card" => $card,
                    "links" => $links,
                    "emails" => $emails,
                    "websites" => $websites,
                    "phonenumbers" => $phonenumbers));
    }

}
