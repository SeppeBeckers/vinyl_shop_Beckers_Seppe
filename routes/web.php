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

/*Route::get('/', function () {
    //return view('welcome');
    return 'the Vinyl shop';
}); */

/*Route::get('contact-us', function () {
    //return 'Contact info';
    return view('contact');
}); */
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::view('/', 'home');
Route::get('contact-us', 'ContactUsController@show');
Route::post('contact-us', 'ContactUsController@sendEmail');
Route::get('shop', 'ShopController@index');
Route::get('shop/{id}', 'ShopController@show');
Route::get('shop_alt', 'ShopController@shopAlt');
Route::get('logout', 'Auth\LoginController@logout');


//Route::view('admin/records', 'admin.records.index');
/*Route::get('admin/records', function (){
    $records = [
        'Queen - <b>Greatest Hits</b>',
        'The Rolling Stones - <em>Sticky Fingers</em>',
        'The Beatles - Abbey Road'
    ];

    return view('admin.records.index', [
        'records' => $records
    ]);
});*/

// New version with prefix and group
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::redirect('/', 'admin/records');
    Route::get('records', 'Admin\RecordController@index');
    Route::get('genres/qryGenres', 'Admin\GenreController@qryGenres');
    Route::resource('genres', 'Admin\GenreController');
    Route::resource('users', 'Admin\UserController');
});

Route::redirect('user', '/user/profile');
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('profile', 'User\ProfileController@edit');
    Route::post('profile', 'User\ProfileController@update');
    Route::get('password', 'User\PasswordController@edit');
    Route::post('password', 'User\PasswordController@update');
});
