<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Route for login 
$route['default_controller'] = 'auth';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';
$route['user/dashboard'] = 'user/dashboard';
$route['user/user-list'] = 'user/user_list';
$route['user/form/(:num)'] = 'user/form/$1';
$route['user/form'] = 'user/form';
$route['user/save/(:num)'] = 'user/save/$1';
$route['user/save'] = 'user/save';
$route['user/delete/(:num)'] = 'user/delete/$1';


// Default route untuk menampilkan produk
$route['products'] = 'products/index'; // Menampilkan daftar produk
$route['products/add'] = 'products/add'; // Halaman untuk tambah produk
$route['products/edit/(:num)'] = 'products/edit/$1'; // Halaman untuk edit produk berdasarkan ID
$route['products/delete/(:num)'] = 'products/delete/$1'; // Endpoint untuk hapus produk berdasarkan ID

$route['api/users/(:any)'] = 'api/users/$1';  // Menangani route untuk pengguna


// get all
$route['api/user/tampil'] = 'apiuser';  // Menangani route untuk pengguna
// get by id 
$route['api/user/tampil/(:any)'] = 'apiuser/get_user/$1';  // Menangani route untuk pengguna
// create user 
$route['api/user/create'] = 'apiuser/create';  // Menangani route untuk pengguna

// update users
$route['api/user/update/(:num)'] = 'apiuser/update/$1';
$route['api/user/delete/(:num)'] = 'apiuser/delete/$1';

//dashboard
$route['dashboard'] = 'dashboard/index'; // Menampilkan dashboard utama
$route['dashboard/export_excel'] = 'dashboard/export_excel'; // Ekspor data ke Excel
$route['dashboard/export_pdf'] = 'dashboard/export_pdf'; // Ekspor data ke PDF

//home
$route['home'] = 'home/index';



