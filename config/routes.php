<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use App\Controller\ProductController;
use App\Controller\OrderController;

$routes = new RouteCollection();

$routes->add( 'product:index',
    ( new Route( '/product/', [ '_controller' => [ ProductController::class, 'index' ] ] ) )->setMethods( 'GET' )
);
$routes->add( 'order:create',
    ( new Route( '/order/create', [ '_controller' => [ OrderController::class, 'create' ] ] ) )->setMethods( 'POST' )
);
$routes->add( 'order:pay',
    ( new Route( '/order/pay', [ '_controller' => [ OrderController::class, 'pay' ] ] ) )->setMethods( 'POST' )
);

return $routes;