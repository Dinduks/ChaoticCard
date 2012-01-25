<?php

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\HttpFoundation\Response;

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

    public function indexAction()
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
        
        $contactForm = $this->createContactForm();

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
            'contactForm'      => $contactForm->createView(),
        ));
    }
    
    public function submitContactFormAction()
    {
        if ($this->app['request']->getMethod() == 'POST') {
            $contactForm = $this->createContactForm();
            $contactForm->bindRequest($this->app['request']);
            
            if ($contactForm->isValid()) {
                $formContent = $_POST['form'];
                $emails = EmailTable::getAllEmails($this->app['db'], true);
                
                if ($formContent['subject'] == '') 
                    $formContent['subject'] = 'Contact';
                
                $body = $this->app['twig']->render(
                    'contactFormBody.html.twig',
                    array('formContent' => $formContent)
                );
                
                $message = $this->app['mailer']
                                ->createMessage()
                                ->setFrom($formContent['email'])
                                ->setTo($emails[0])
                                ->setSubject($formContent['subject'])
                                ->setBody($body);
                $this->app['mailer']->send($message);
                
                return new Response('ok', 200);
            } else {
                echo $this->app['twig']->render(
                    'contactForm.html.twig', 
                    array(
                        'contactForm' => $contactForm->createView(), 
                        'lang'        => $this->app['locale']
                        )
                );
            }
        } else {
            $this->app->redirect($this->app['url_generator']->generate('homepage'));
        }
    }
    
    public function createContactForm()
    {
        $constraints = new Constraints\Collection(array(
            'name'  => new Constraints\NotBlank,
            'email' => array(
                new Constraints\NotBlank(),
                new Constraints\Email(),
            ),
            'website' => new Constraints\Url,
            'message' => new Constraints\NotBlank()
        ));
        
        $builder = $this->app['form.factory']
                        ->createBuilder(
                            'form', 
                            array(
                                'validation_constraint' => $constraints,
                            )
                        );
        
        $form = $builder->add('name', 'text')
                        ->add('email', 'email')
                        ->add('website', 'text')
                        ->add('subject', 'text')
                        ->add('message', 'textarea')
                        ->getForm();
        
        return $form;
    }

}
