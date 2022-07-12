<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

//2 gnahatakan
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
    return view('pages.home');
})->name('home');

Route::get("/books", [BookController::class, "books"])->name('books');

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get("/dashboard", [AdminController::class, "index"])->name('index');
    Route::delete("/users/{id}", [AdminController::class, "delete"])->name('user.destroy');
});


Route::group(['middleware' => 'guest'], function () {

    Route::get("/register", [UserController::class, "register"])->name('register');

    Route::post("/register", [UserController::class, "storeRegister"])->name('register.store');

    Route::get("/login", [UserController::class, "login"])->middleware('guest')->name('login');

    Route::post("/login", [UserController::class, "storeLogin"])->name('page');

    Route::get('/sign-in/github/callback', [UserController::class, 'gitRedirect'])->name('github');

    Route::get('/sign-in/github/redirect', [UserController::class, 'gitCallback'])->name('redirectGithub');

    Route::get("/forgot-password", [UserController::class, "reset"])->name('password.request');

    Route::post("/forgot-password", [UserController::class, "resetPassword"])->name('password.email');

    Route::get('/reset-password/{token}', function ($token) {
        return view('pages.reset-password', ['token' => $token]);
    })->name('password.reset.page');;

    Route::post('/reset-password', [UserController::class, "sendPasswordResetNotification"])->name('password.reset');

});
Route::group(['middleware' => 'auth'], function () {

    Route::get("/logout", [UserController::class, "logout"])->name('logout');

    Route::get("/create", [BookController::class, "create"])->name('create');

    Route::get("/subscription", [SubscriptionController::class, "index"])->name('subscriptions');

    Route::get('stripe/{id}', [StripeController::class, 'stripe'])->name('stripe');

    Route::post('stripe/{id}', [StripeController::class, 'stripePost'])->name('stripePost');

    Route::get("/subId/{id}", [SubscriptionController::class, "cancel"])->name('subId');

    Route::post("/subscription", [SubscriptionController::class, "store"])->name('subscription.store');

    Route::get("/books/{file}", [BookController::class, "getDownload"])->name('download');

    Route::get('/verify/{id}', [UserController::class, 'verifyEmail'])->name('verify');

    Route::post("/home", [BookController::class, "createBook"])->name('createBook');

});






