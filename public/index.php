<?php

use classes\Route;
require '../autoload.php';

// Add base route (startpage)
Route::add('/', function() {
    echo 'Hello World!';
});

// Simple test route that simulates static html file
//Route::add('/book', 'Book@show', 'get');
Route::add('/book', 'Book@create', 'get');
Route::add('/book', 'Book@update', 'put');
Route::add('/book', 'Book@delete', 'delete');

// Accept only numbers as parameter. Other characters will result in a 404 error
Route::add('/foo/([0-9]*)/bar', function($var1){
    echo $var1.' is a great number!';
});

Route::run();