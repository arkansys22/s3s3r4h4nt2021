<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'Main';
$route['login'] = "Aspanel/login";
/* Controller Frontend - Pembuka*/
$route['main'] = "Main/index";


/* Controller Frontend - Penutup*/
$route['berita'] = "Berita/index";
$route['daftar'] = "Aspanel/register";
$route['klien/(:any)'] = "Klien/detail/$1";
$route['harga/(:any)'] = "Harga/detail/$1";
$route['produk/(:any)'] = "templates/detail/$1";
$route['quick/(:any)'] = "templates/quick_detail/$1";
$route['tips/(:any)'] = "berita/detail/$1";
$route['syarat-ketentuan/(:any)'] = "note/detail/$1";

/* Controller Default - Pembuka*/
$route['404_override'] = 'Notfound';
$route['translate_uri_dashes'] = FALSE;
$route['petacrawl\.xml'] = "petacrawl";
/* Controller Default - Penutup*/
