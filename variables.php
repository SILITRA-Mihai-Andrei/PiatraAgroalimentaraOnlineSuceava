<?php

include_once('simple_html_dom.php');

// For removing the warnings
libxml_use_internal_errors(true);
// For removing the warning caused by new types of HTML elements (ex: <nav>)
libxml_clear_errors();

// Variables for database server
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_app_database";
$database_error_connection_redirect_page = '/database_error.html';

$test_page = '/tests';
$portal_page_server = '/portal';
$portal_page = "portal.html";
$login_page_server = '/login.php';
$login_page = 'login.html';
$register_page_server = '/register';
$register_page = 'register.html';
$market_page = 'market.html';
$market_page_server = '/market';
$cumparaturi_page_server = '/cumparaturi';
$catch_page = 'catch.html';
$shoping_cart_page_server = '/shoping-cart';

// Initiate the database connection
$db = new PDO("mysql:host=$servername; dbname=$dbname; charset=utf8", $username, $password);

// VARIABLES

// Array of attributes used for div tags of invalid fields
$invalid_field_array_of_attributes = array('class'=>'alert alert-danger p-1 mt-1', 
                                            'id'=>'NumeCompletAlertInvalid',
                                            'style'=>'font-size: 12px;');


