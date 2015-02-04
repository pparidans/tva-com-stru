<?php

date_default_timezone_set('Europe/Brussels');

require_once __DIR__.'/../vendor/autoload.php';

use models\StructuredCommunicationService;

$app = new Silex\Application();

$StructuredCommunicationService = new StructuredCommunicationService();

$app['debug'] = true;

// Register the Twig templating engine
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__.'/views',
));

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
	'monolog.logfile' => 'php://stderr',
));

// Our web handlers
$app->get('/', function() use($app, $StructuredCommunicationService) {
	$app['monolog']->addDebug('logging output.');
	$company_number = filter_input(INPUT_GET, 'companynumber', FILTER_SANITIZE_STRING);
	$com_stru = null;
	if(!is_null($company_number)) {
		$com_stru = $StructuredCommunicationService->convert_vat($company_number);
	}
    return $app['twig']->render('index.twig', array(
        'comm_structured' => $com_stru,
        'company_number' => $company_number
    ));
});

$app->run();