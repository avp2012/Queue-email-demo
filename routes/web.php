<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
	return redirect()->route('login');
});

Route::group(['prefix' => 'admin'], function () {
	Auth::routes();
	Route::get('dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
	Route::resource('posts', 'App\Http\Controllers\PostController');
	Route::post('multiple-posts-delete', [App\Http\Controllers\PostController::class, 'multiplePostsDelete']);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Email Route
Route::get('send-mail', function () {
	$details['email'] = 'demonarola@yopmail.com';
	dispatch(new App\Jobs\SendEmailInQueue($details));
});