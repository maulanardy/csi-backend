<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::auth();

Route::group(['middleware' => 'auth'], function(){

	Route::group(['middleware' => 'auth.input'], function(){
		Route::get('', 'HomeController@index');
	});
		
	Route::group(['middleware' => 'auth.manager'], function(){
		// cars route
		Route::resources(['divisi' => 'DivisiController', ]);

		Route::group(['prefix' => 'cars'] , function(){
			// Route::get('','CarController@index');
			Route::get('', 'CarController@index');
			Route::get('{id}/edit', 'CarController@edit');
			Route::get('data', 'CarController@getAll');
			Route::get('{id}', 'CarController@show');
			Route::post('', 'CarController@create');
			Route::delete('{id}', 'CarController@destroy');
			Route::patch('{id}', 'CarController@update');
			Route::post('{id}/available', 'CarController@available');
		});

		//Driver route
		Route::group(['prefix' => 'drivers'] , function(){
			Route::get('', 'DriverController@index');
			Route::get('form', 'DriverController@formInput');
			Route::get('data', 'DriverController@getAll');
			Route::post('insert', 'DriverController@create');
			Route::delete('{id}', 'DriverController@destroy');

			Route::get('{id}/edit', 'DriverController@edit');
			Route::patch('{id}/update', 'DriverController@update');

			Route::post('{id}/available', 'DriverController@available');
		});
	});

	Route::group(['middleware' => 'auth.manager'], function(){
		//Tasks route
		Route::group(['prefix' => 'tasks'] , function(){
			Route::get('', 'TaskController@index');
			Route::get('approved', 'TaskController@approved');
			Route::get('pending', 'TaskController@pending');
			Route::get('history', 'TaskController@history');
			Route::get('prepare', 'TaskController@getPrepare');
			Route::get('outdated', 'TaskController@getOutdated');
			Route::get('data', 'TaskController@getAll');
			Route::get('data/approved', 'TaskController@getApproved');
			Route::get('data/ongoing', 'TaskController@getOngoing');
			Route::get('data/pending', 'TaskController@getPending');
			Route::get('data/history', 'TaskController@getHistory');
			Route::get('{id}/edit', 'TaskController@edit');
			Route::get('{id}', 'TaskController@show');
			// Route::post('tasks', 'TaskController@create');
			Route::delete('{id}', 'TaskController@destroy');
			Route::post('','TaskController@store');
			Route::post('{id}/cancel','TaskController@cancel');
			Route::post('{id}/approve','TaskController@approve');
			Route::patch('{id}/edit', 'TaskController@update');
		});
	});

	Route::group(['middleware' => 'auth.admin'], function(){
		Route::resources([
		    'users' => 'UserController',
		]);
		// Route::group(['prefix' => 'users'], function(){
		// 	Route::get('', 'UserController@index');
		// 	Route::get('create', 'UserController@create');
		// });
	});
	
});

Route::group(['prefix' => 'cron'], function(){
	Route::get('taskprepare', 'TaskController@getPrepare');
	Route::get('taskoutdated', 'TaskController@getOutdated');
});