<?php
class HomePage {

    function __construct($app) {
        $this->app = $app;
    }
    
    function index(){
        // The database is a big mess...
        $cardQuery = "SELECT * FROM card";
        $linksQuery = "SELECT * FROM link";
        $emailsQuery = "SELECT * FROM email";
        $websitesQuery = "SELECT * FROM website";
        $phonenumbersQuery = "SELECT * FROM phonenumber";
        
        $card = $this->app["db"]->fetchAssoc($cardQuery);
        $links = $this->app["db"]->fetchAll($linksQuery);
        $emails = $this->app["db"]->fetchAll($emailsQuery);
        $websites = $this->app["db"]->fetchAll($websitesQuery);
        $phonenumbers = $this->app["db"]->fetchAll($phonenumbersQuery);
        
        return $this->app['twig']->render('homepage.html.twig', array(
            "card" => $card, 
            "links" => $links, 
            "emails" => $emails, 
            "websites" => $websites, 
            "phonenumbers" => $phonenumbers));
    }

}
?>