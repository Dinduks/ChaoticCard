<?php

require __DIR__.'/autoload.php';

$app = new Silex\Application();

$app['prod'] = ($_SERVER['SERVER_ADDR'] == '127.0.0.1') ? false : true;

$app['lang'] = ChaoticCardUtil::getClientLanguage();

/* SERVICES' REGISTRATION */
if (!$app['prod']) {
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path'         => __DIR__ . '/../src/views',
        'twig.class_path'   => __DIR__ . '/../vendor/Silex/vendor/twig/lib',
    ));
} else {
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path'         => __DIR__ . '/../src/views',
        'twig.class_path'   => __DIR__ . '/../vendor/Silex/vendor/twig/lib',
        'twig.options'      => array('cache' => __DIR__ . '/cache'),
    ));
}

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'    => array(
        'driver'    => 'pdo_sqlite',
        'path'      =>  __DIR__ . '/chaoticcard.sqlite',
    ),
    'db.dbal.class_path'    => __DIR__ . '/../vendor/Silex/vendor/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__ . '/../vendor/Silex/vendor/doctrine-common/lib'
));

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale'                    => $app['lang'],
    'locale_fallback'           => 'en',
    'translation.class_path'    => __DIR__ . '/vendor/Symfony/Component',
));

$app->register(new Silex\Provider\SymfonyBridgesServiceProvider(), array(
    'symfony_bridges.class_path' => __DIR__ . '/vendor/Symfony/Component',
));
/* END SERVICES' REGISTRATION */

/* ROUTES */
$app->match('/{controllerName}/', function ($controllerName) use ($app) {
    $controllerName = ucfirst($controllerName);
    
    $controller = ucfirst($controllerName).'Controller';
    $file = __DIR__ . "/../src/controllers/$controller.php";
    if (file_exists($file)) {
        require $file;
        $controllerObj = new $controller($app);
        return $controllerObj->index();
    } else {
        throw new Exception("The '$url' controller doesn't exist!");
    }
});

$app->match('/{controllerName}/{actionName}', function ($controllerName, $actionName) use ($app) {
    $controllerName = ucfirst($controllerName);
    $actionName = ucfirst($actionName);
    
    $controller = $controllerName.'Controller';
    $file = __DIR__ . "/../src/controllers/$controller.php";
    if (file_exists($file)) {
        require $file;
        $controllerObj = new $controller($app);
        if (method_exists($controller, $actionName)) {
            return $controllerObj->{$actionName}();
        } else {
            throw new Exception("The action '$actionName' action isn't defined in the controller '$controllerName'!");
        }
    } else {
        throw new Exception("The '$controllerName' controller doesn't exist!");
    }
});

$app->match('/', function () use ($app) {
    $file = __DIR__ . '/../src/controllers/HomepageController.php';
    require $file;
    $controller = new HomepageController($app);
    return $controller->index();
});
/* END ROUTES */

$app['autoloader']->registerNamespace('Symfony', __DIR__ . '/../vendor/Symfony/src');
$app['translator.loader'] = new Symfony\Component\Translation\Loader\YamlFileLoader();
$app['translator.messages'] = array(
    'fr' => __DIR__ . '/../src/locales/fr.yml',
    'en' => __DIR__ . '/../src/locales/en.yml'
);

$app['debug'] = (!$app['prod']) ? true : false;

return $app;
