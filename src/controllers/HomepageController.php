<?php

class HomepageController
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
        if (!file_exists($dbParams["path"]))
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
        foreach ($emails as $i => $email) {
            $strEmail = str_split($email->getEmail());
            $emailsArray[$i] = '';
            foreach ($strEmail as $char) {
                $emailsArray[$i] .= '&#' . ord($char) . ';';
            }
        }

        $about = TextTable::getText($db, $this->app['lang'], 'about')->getText();
        $secondaryTitle = TextTable::getText($db, $this->app['lang'], 'secondaryTitle')->getText();

        // delete the analytics code on the prod env
        if (!$this->app['prod']) {
            $card->setAnalytics('');
        }

        return $this->app['twig']->render('homepage.html.twig', array(
            'card'           => $card,
            'links'          => $links,
            'emails'         => $emailsArray,
            'websites'       => $websites,
            'phonenumbers'   => $phonenumbers,
            'about'          => $about,
            'secondaryTitle' => $secondaryTitle,
            'lang'           => $this->app['lang'],
        ));
    }

}
