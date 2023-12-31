<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
 $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

//LOGIN
use App\Controllers\UsuariosController;
$routes->get('login', [UsuariosController::class, 'index']);
$routes->post('login', [UsuariosController::class, 'comprovar_user']);

//LOGOUT
$routes->get('logout', [UsuariosController::class, 'logout']);

//HOME
use App\Controllers\HomeController;
$routes->get('home', [HomeController::class, 'index']);
$routes->post('home', [HomeController::class, 'home_posts']);

//CLIENTES
use App\Controllers\ClientsController;
$routes->get('clients', [ClientsController::class, 'index']);
$routes->post('clients', [ClientsController::class, 'posts']);

//FACTURAS
use App\Controllers\InvoicesController;
//Facturas Listar
$routes->get('facturas', [InvoicesController::class, 'index']);
$routes->post('facturas', [InvoicesController::class, 'posts']);

//DETALLES
use App\Controllers\DetallesController;
//Facturas Crear
$routes->get('crear_facturas', [DetallesController::class, 'index']); 
$routes->post('crear_facturas', [DetallesController::class, 'posts']);
//Facturas Editar
$routes->get('editar_facturas', [DetallesController::class, 'editar_factura']);
$routes->post('editar_facturas', [DetallesController::class, 'posts']);


//HISTORIAL
use App\Controllers\HistorialController;
$routes->get('historial', [HistorialController::class, 'index']);
$routes->post('historial', [HistorialController::class, 'posts']);


//ADMIN
use App\Controllers\AdminController;
$routes->get('admin', [AdminController::class, 'index']);
$routes->post('admin', [AdminController::class, 'home_posts']);

//////////////////

use App\Controllers\Pages;
$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
