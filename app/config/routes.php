<?php

use app\controllers\PagesController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

	/** 
	 * @var Router $router 
	 * @var Engine $app
	 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->get('/', function() use ($app) {
		$app->render('welcome', [ 'message' => 'You are gonna do great things!' ]);
	});

	$router->group('/category', function() use ($router) {
		$router->get('/add', [ PagesController::class, 'addCategory' ]);
		$router->post('/add', [ PagesController::class, 'addCategory' ]);
		$router->get('/delete/@id:[0-9]+', [ PagesController::class, 'deleteCategory' ]);
		$router->get('/update/@id:[0-9]+', [ PagesController::class, 'updateCategoryForm' ]);
		$router->post('/update', [ PagesController::class, 'updateCategory' ]);
		$router->get('/lists', [ PagesController::class, 'toLists' ]); // You would need to create this method in the controller and model to pull from the database
	});
	$router->get('/home', function() use ($app) {
		$app->render('welcome');
	});
	$router->get('/products', [ PagesController::class, 'products' ]);
	
	
}, [ SecurityHeadersMiddleware::class ]);