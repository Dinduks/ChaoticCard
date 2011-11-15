<?php

class InstallController
{

    /**
     *
     * @var Silex\Application
     */
    private $app;

    function __construct($app)
    {
        $this->app = $app;
    }

    function index()
    {
        if (ChaoticCardUtil::dbExists($this->app)) {
            return $this->app->redirect("/");
        } else {
            return $this->newCard();
        }
    }

    function newCard()
    {

        if ($_POST) {
            $linkIcons = $_FILES['linkicon'];

            ChaoticCardUtil::createDb($this->app);
            ChaoticCardUtil::insertIntoDb($this->app, $_POST, $_FILES);

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

}
