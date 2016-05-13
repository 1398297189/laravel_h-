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


Route::group(['prefix' => "",'middleware' => ['auth']], function()
{
    Route::get('/',['uses'=>'IndexController@index','as'=>'admin.index']);

    /*
     * 权限管理
     * */
    Route::group(['prefix' => "auth",'middleware' => []], function()
    {
        Route::get('/auth-manage', ['uses'=>'AuthController@AuthManage','as'=>'auth.AuthManage']);

        Route::get('/new-role-page', ['uses'=>'AuthController@newRolePage','as'=>'auth.newRolePage']);
        Route::post('/add-new-role', ['uses'=>'AuthController@postAddNewRole','as'=>'auth.postAddNewRole']);
        Route::get('/delete-role', ['uses'=>'AuthController@deleteRole','as'=>'auth.deleteRole']);

        Route::get('/set-permissions/{id}', ['uses'=>'AuthController@SetPermissions','as'=>'auth.SetPermissions']);
        Route::get('/edit-role', ['uses'=>'AuthController@editRole','as'=>'auth.editRole']);
        Route::post('/save-permissions', ['uses'=>'AuthController@SavePermissions','as'=>'auth.SavePermissions']);

        Route::get('/add-auth', ['uses'=>'AuthController@AddAuth','as'=>'auth.AddAuth']);

    });

    /*
     * 数据库字典
     * */
    Route::group(['prefix' => "sys",'namespace' => 'Sys','middleware' => []], function()
    {
        Route::get('dictionary/index', ['uses'=>'DictionaryController@Index','as'=>'Sys.Dictionary.Index']);


    });

});


Route::auth();

Route::get('/home', ['uses'=>'IndexController@index','as'=>'admin.index']);
