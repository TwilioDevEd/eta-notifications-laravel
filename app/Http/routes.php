<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',
    ['as' => 'order.index',
     'uses' => 'OrderController@index']
);

Route::get('/order/{id}',
    ['as' => 'order.show',
     'uses' => 'OrderController@show']
);
