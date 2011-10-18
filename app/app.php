<?php
require __DIR__.'/autoload.php';

$app = new Silex\Application();

if ($_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path'         => __DIR__.'/../src/views',
        'twig.class_path'   => __DIR__.'/../vendor/Silex/vendor/twig/lib',
    ));
} else {
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path'         => __DIR__.'/../src/views',
        'twig.class_path'   => __DIR__.'/../vendor/Silex/vendor/twig/lib',
        'twig.options'      => array('cache' => __DIR__.'/cache'),
    ));
}

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'        => array(
        'driver'    => 'pdo_sqlite',
        'path'      =>  __DIR__.'/chaoticcard.sqlite',
    ),
    'db.dbal.class_path'    => __DIR__.'/../vendor\Silex\vendor\doctrine-dbal\lib',
    'db.common.class_path'  => __DIR__.'/../vendor\Silex\vendor\doctrine-common/lib',
));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale'                    => ChaoticCardUtil::getClientLanguage(),
    'locale_fallback'           => 'en',
    'translation.class_path'    => __DIR__.'/vendor/Symfony/Component',
));

$app->get('/{controllerName}/', function ($controllerName) use ($app) {
    $file = __DIR__.'/../src/controllers/'.$controllerName.'.php';
    if (file_exists($file)) {
        require $file;
        $controller = new $controllerName($app);
        return $controller->index();
    } else {
        throw new Exception("The '$url' controller doesn't exist!");
    }
});

$app->get('/{controllerName}/{actionName}', function ($controllerName, $actionName) use ($app) {
    $file = __DIR__.'/../src/controllers/'.$controllerName.'.php';
    if (file_exists($file)) {
        require $file;
        $controller = new $controllerName($app);
        if (method_exists($controller, $actionName)) {
            return $controller->{$actionName}();
        } else {
            throw new Exception("The action '$actionName' action isn't defined in the controller '$controllerName'!");
        }
    } else {
        throw new Exception("The '$controllerName' controller doesn't exist!");
    }
});

$app->get('/', function () use ($app) {
    $file = __DIR__.'/../src/controllers/homepage.php';
    require $file;
    $controller = new homepage($app);
    return $controller->index();
});

$app->post('/admin/newCardSubmit', function () use ($app) {
    require __DIR__.'/../src/controllers/admin.php';
    $controller = new Admin($app);
    return $controller->newCardSubmit();
});

$app['autoloader']->registerNamespace('Symfony', __DIR__.'/../vendor/Symfony/src');

$app['translator.messages'] = array(
    'fr' => __DIR__.'/../src/locales/fr.yml',
    'en' => __DIR__.'/../src/locales/en.yml'
);
$app['translator.loader'] = new Symfony\Component\Translation\Loader\YamlFileLoader();

// Create the (pseudo-)singleton 
new Database($app['db']);

$app["debug"] = true;

return $app;
?>
