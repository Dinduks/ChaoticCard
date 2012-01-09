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
        $emails = EmailTable::getAllEmails($db, true);
        $websites = WebsiteTable::getAllWebsites($db);
        $phonenumbers = PhoneNumberTable::getAllPhoneNumbers($db);

        $about = TextTable::getText($db, $locale, 'about')->getText();
        $secondaryTitle = TextTable::getText($db, $locale, 'secondaryTitle')->getText();
        $metaKeywords = TextTable::getText($db, $locale, 'metaKeywords')->getText();
        $metaDescription = TextTable::getText($db, $locale, 'metaDescription')->getText();

        // build the gravatar image link
        $gravatarLink = ChaoticCardUtil::getGravatarLink($card->getGravatarEmail());

        foreach ($emails as &$email) {
            $email = ChaoticCardUtil::strToAscii($email);
        }

        // hide the analytics code on the prod env
        if (!$this->app['prod']) {
            $card->setAnalytics('');
        }

        return $this->app['twig']->render('homepage.html.twig', array(
            'card'             => $card,
            'links'            => $links,
            'emails'           => $emails,
            'websites'         => $websites,
            'phonenumbers'     => $phonenumbers,
            'about'            => $about,
            'secondaryTitle'   => $secondaryTitle,
            'lang'             => $locale,
            'possibleLocales'  => $this->app['possibleLocales'],
            'gravatarLink'     => $gravatarLink,
            'metaKeywords'     => $metaKeywords,
            'metaDescription'  => $metaDescription,
        ));
    }

}
