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
        $locale = $this->app['locale'];
        $db = $this->app['db'];
        $dbParams = $db->getParams();
        if (!file_exists($dbParams["path"]))
            return $this->app->redirect("/$locale/install");

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

        $about = TextTable::getText($db, $locale, 'about')->getText();
        $secondaryTitle = TextTable::getText($db, $locale, 'secondaryTitle')->getText();

        // build the gravatar image link
        if ($card->getGravatarEmail() != '') {
            $gravatarEmail = md5(strtolower(trim($card->getGravatarEmail())));
            $gravatarLink = 'http://www.gravatar.com/avatar/' . $gravatarEmail;
        } else {
            $gravatarLink = null;
        }
        
        // hide the analytics code on the prod env
        if (!$this->app['prod']) {
            $card->setAnalytics('');
        }

        return $this->app['twig']->render('homepage.html.twig', array(
            'card'            => $card,
            'links'           => $links,
            'emails'          => $emailsArray,
            'websites'        => $websites,
            'phonenumbers'    => $phonenumbers,
            'about'           => $about,
            'secondaryTitle'  => $secondaryTitle,
            'lang'            => $locale,
            'possibleLocales' => $this->app['possibleLocales'],
            'gravatarLink'    => $gravatarLink,
        ));
    }

}
