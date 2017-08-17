<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// route registration attempts to home
Route::any('/register','HomeController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('user/create', [
        'as' => 'user.create', 'uses' => 'UserController@create'
    ]);

    Route::post('user/create', [
        'as' => 'user.store', 'uses' => 'UserController@store'
    ]);

    Route::get('user/edit/{id}', [
        'as' => 'user.edit', 'uses' => 'UserController@edit'
    ]);

    Route::patch('user/edit/{id}', [
        'as' => 'user.update', 'uses' => 'UserController@update'
    ]);

    Route::post('user/delete', [
        'as' => 'user.delete', 'uses' => 'UserController@delete'
    ]);

    Route::get('user/lists', [
        'as' => 'user.lists', 'uses' => 'UserController@index'
    ]);

    // Articles
    Route::get('article/create', [
        'as' => 'article.create', 'uses' => 'ArticleController@create'
    ]);

    Route::post('article/create', [
        'as' => 'article.store', 'uses' => 'ArticleController@store'
    ]);

    Route::get('article/edit/{id}', [
        'as' => 'article.edit', 'uses' => 'ArticleController@edit'
    ]);

    Route::patch('article/edit/{id}', [
        'as' => 'article.update', 'uses' => 'ArticleController@update'
    ]);

    Route::post('article/delete', [
        'as' => 'article.delete', 'uses' => 'ArticleController@delete'
    ]);

    Route::get('article/lists', [
        'as' => 'article.lists', 'uses' => 'ArticleController@index'
    ]);

    // Article Categories
    Route::get('articlecategory/create', [
        'as' => 'articlecategory.create', 'uses' => 'ArticleCategoryController@create'
    ]);

    Route::post('articlecategory/create', [
        'as' => 'articlecategory.store', 'uses' => 'ArticleCategoryController@store'
    ]);

    Route::get('articlecategory/edit/{id}', [
        'as' => 'articlecategory.edit', 'uses' => 'ArticleCategoryController@edit'
    ]);

    Route::patch('articlecategory/edit/{id}', [
        'as' => 'articlecategory.update', 'uses' => 'ArticleCategoryController@update'
    ]);

    Route::post('articlecategory/delete', [
        'as' => 'articlecategory.delete', 'uses' => 'ArticleCategoryController@delete'
    ]);

    Route::get('articlecategory/lists', [
        'as' => 'articlecategory.lists', 'uses' => 'ArticleCategoryController@index'
    ]);

});
