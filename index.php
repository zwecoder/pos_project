<?php
require_once "vendor/autoload.php";
require_once "app/bootstrap.php";

use app\core\Router;


$router = new Router();

// Define a dynamic route with a placeholder {id}
$router->get('/', 'HomeController@index');
$router->get('login', 'HomeController@login');
$router->post('login', 'HomeController@loginCheck');

$router->get('select/{id}', 'HomeController@selectById');
$router->get('insert', 'HomeController@insert');
$router->get('update', 'HomeController@update');
$router->get('delete/{id}', 'HomeController@delete');
$router->get('post/{id}', 'PostController@show');
///////admin user///////
$router->get('admin', 'IndexController@index');
$router->get('admin/ad_view', 'AdminController@adminView');
$router->get('admin/ad_create', 'AdminController@adminCreate');
$router->post('admin/ad_add', 'AdminController@adminAdd');
$router->get('admin/ad_edit/{id}', 'AdminController@adminEdit');
$router->post('admin/ad_edited/{id}', 'AdminController@adminEdited');
$router->get('admin/ad_delete/{id}', 'AdminController@adminDelete');
//////customer/////
$router->get('admin/customer_view', 'CustomerController@customerView');
$router->get('admin/customer_create', 'CustomerController@customerCreate');
$router->post('admin/customer_create', 'CustomerController@customerAdd');
$router->get('admin/customer_edit/{id}', 'CustomerController@customerEdit');
$router->post('admin/customer_edit/{id}', 'CustomerController@customerEdited');
$router->get('admin/customer_delete/{id}', 'CustomerController@customerDelete');
//////category/////
$router->get('admin/cat_view','CategoryController@catView');
$router->get('admin/cat_create','CategoryController@catCreate');
$router->post('admin/cat_create', 'CategoryController@catAdd');
$router->get('admin/cat_edit/{id}', 'CategoryController@catEdit');
$router->post('admin/cat_edit/{id}', 'CategoryController@catEdited');
$router->get('admin/cat_delete/{id}', 'CategoryController@catDelete');
//////category/////
$router->get('admin/product_view','ProductController@productView');
$router->get('admin/product_create', 'ProductController@productCreate');
$router->post('admin/product_create', 'ProductController@productAdd');
$router->get('admin/product_edit/{id}', 'ProductController@productEdit');
$router->post('admin/product_edit/{id}', 'ProductController@productEdited');
$router->get('admin/product_delete/{id}', 'ProductController@productDelete');
//////order/////
//$router->get('admin/product_view', 'ProductController@productView');
$router->get('admin/order_create', 'OrderController@orderCreate');
$router->post('admin/order_create/{qtyVal}/{productId}', 'OrderController@orderIncDec');
$router->post('admin/order_create', 'OrderController@orderAdd');
$router->get('admin/order_Delete/{id}', 'OrderController@orderDelete');
$router->post('admin/order_payment/{paymentmethod}/{cphone}', 'OrderController@orderPayment');//new style for ajax send
$router->post('admin/order_payment_customer', 'OrderController@orderPaymentCustomer'); //old style for ajax send
$router->get('admin/order_summary', 'OrderController@orderSummary');
///order summary///
$router->post('admin/order_save', 'OrderController@orderSave');
$router->get('admin/orders', 'OrderController@orders');
$router->post('admin/orders', 'OrderController@ordersFilter');
$router->get('admin/order_view/{trackNo}', 'OrderController@orderView');
$router->get('admin/order_view_print/{trackNo}', 'OrderController@orderViewPrint');
//$router->get('admin/order_error_checker', 'OrderController@orderSave');//for php error check




$router->get('logout', 'AdminController@adminLogout');

$router->dispatch();