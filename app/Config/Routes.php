<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Route login/logout (tanpa login)
$routes->get('/', 'Auth::login');
$routes->post('/auth/attemptLogin', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::processRegister');

// Route yang bisa diakses user biasa (setelah login)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/home', 'Pages::index');
    $routes->get('/surat', 'Surat::index');
    $routes->get('/surat/create', 'Surat::create');
    $routes->post('/surat/save', 'Surat::save');
    $routes->get('/surat/detail/(:num)', 'Surat::detail/$1');
});

// Route yang hanya boleh admin (atau role khusus)
$routes->group('', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('/surat/edit/(:num)', 'Surat::edit/$1');
    $routes->post('/surat/update/(:num)', 'Surat::update/$1');
    $routes->delete('surat/(:num)', 'Surat::delete/$1');
    $routes->get('/surat/rekap', 'Surat::rekap');
    $routes->get('/surat/downloadRekap', 'Surat::downloadRekap');
    $routes->get('/akun', 'AkunController::index');
    $routes->delete('akun/(:num)', 'AkunController::delete/$1');
    $routes->get('/akun', 'AkunController::index');
    $routes->get('/akun/approve/(:num)', 'AkunController::approve/$1');
    $routes->get('akun/delete/(:num)', 'AkunController::delete/$1');
    $routes->delete('/akun/(:num)', 'AkunController::delete/$1');
    $routes->get('/registadmin', 'Auth::registerAdmin');
    $routes->post('/registadmin/process', 'Auth::processRegisterAdmin');
    $routes->get('maintain', 'Maintain::index');
    $routes->get('maintain/exportSuratToPdf', 'Maintain::exportSuratToPdf');
    $routes->get('maintain/zipSurat', 'Maintain::zipSurat');
    $routes->get('maintain/', 'Maintain::zipSurat');
    $routes->post('maintain/clearSurat', 'Maintain::clearSurat');
    $routes->delete('maintain/clearSurat', 'Maintain::clearSurat');
});
