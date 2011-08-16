<?php
class Admin {
    
    // TODO : Support profile pic
    
    function __construct($app) {
        $this->app = $app;
    }
    
    function index() {
//        if (file_exists('../src/chaoticcard.db')) {
//            return $this->editCard($app);
//        } else {
            return $this->newCard();
//        }
    }
    
    function newCard() {
        return $this->app['twig']->render('cardform.html.twig', array(
            "formType" => "new",
            "title" => "ChaoticCard installation",
            ));
    }
    
    function editCard() {
    }
    
    function newCardSubmit(){
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $title = $_POST["cardtitle"];
        $secondaryTitle = $_POST["secondaryTitle"];
        $birthday = explode('/', $_POST["birthday"]);
        $about = $_POST["about"];
        $emails = $_POST['email'];
        $phoneNumbers = $_POST['phoneNumber'];
        $websiteUrls = $_POST['websiteurl'];
        $websiteTitles = $_POST['websitetitle'];
        $linkUrls = $_POST['linkurl'];
        $linkTitles = $_POST['linktitle'];
        $linkIcons = $_FILES['linkicon'];
        
        ChaoticCardUtil::createDb($this->app);
        ChaoticCardUtil::insertIntoDb($this->app, $_POST, $_FILES);
        foreach ($_FILES["linkicon"]["name"] as $i=>$linkIconName) {
            move_uploaded_file($linkIcons["tmp_name"][$i], '../web/images/icons/'.$linkIcons["name"][$i]);
        }
        move_uploaded_file($_FILES["profilepicture"]["tmp_name"], "../web/images/".$_FILES["profilepicture"]["name"]);
        
        return $this->app->redirect("/");
    }

}
?>
