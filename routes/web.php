<?php

use App\Http\Controllers\mailController;
use App\Http\Controllers\testController;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

// Route::get('test/send-email', function() {
//     $sendMail = 'virgostevanus27@gmail.com';
//     dispatch(new SendEmailJob($sendMail));
// });

Route::post('profile/email-verify', [mailController::class, 'verifyEmail'])->name('email.verify');
Route::get('profile/email-send/{userID}/{userEMAIL}', [mailController::class, 'sendEmail'])->name('email.send');

Route::post('test', [mailController::class,'test'])->name('test');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
