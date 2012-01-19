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

    public function indexAction()
    {
        $dbParams = $this->app['db']->getParams();
        if (file_exists($dbParams['path'])) {
            return $this->app->redirect('/');
        } else {
            return $this->newCard();
        }
    }

    public function newCard()
    {

        if ($_POST) {
            @$linkIcons = $_FILES['linkicon'];

            ChaoticCardUtil::createDb($this->app);
            ChaoticCardUtil::insertIntoDb($_POST, $_FILES, $this->app['db']);

            foreach ($_FILES['linkicon']['name'] as $i => $linkIconName) {
                move_uploaded_file(
                        $linkIcons['tmp_name'][$i], __DIR__ . '/../../web/images/icons/' . $linkIcons['name'][$i]
                );
            }

            move_uploaded_file(
                    $_FILES['profilepicture']['tmp_name'], __DIR__ . '/../../web/images/' . $_FILES['profilepicture']['name']
            );

            return $this->app->redirect('/');
        } else {
            return $this->app['twig']->render('install.html.twig', array(
                        'formType'         => 'new',
                    ));
        }
    }
    
}
