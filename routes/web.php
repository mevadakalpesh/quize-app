<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserAttemptQuizeController;
use App\Http\Controllers\SendMailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use App\Mail\SendClientMail;
use App\Models\MailTemplate;

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
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
})->name('home');

Route::middleware('auth')->group(function () {

  // admin routes
  Route::middleware(['isAdmin'])->group(function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //question resource routes
    Route::resource('question', QuestionController::class);
    Route::post('question/get-questions', [QuestionController::class, 'getQuestions'])->name('question.getQuestions');

    //Quize Routes
    Route::resource('quize', QuizeController::class);
    Route::post('get-question-by-category', [QuizeController::class, 'getQuestionByCategory'])->name('getQuestionByCategory');
    Route::post('quize/get-quizes', [QuizeController::class, 'getQuizes'])->name('quize.getQuizes');

    Route::post('get-user-data-dy-quize-id', [DashboardController::class, 'getUserDataByQuizeId'])->name('getUserDataByQuizeId');
  
    Route::resource('templates', SendMailController::class);
    Route::get('template/sendmail', [SendMailController::class,'sendMail'])->name('template.sendMail');
    Route::post('template/send-client-mail',[SendMailController::class,'sendClientMail'])->name('sendClientMail');
  
  });

  // question list for user
  Route::get('user-quize-list', [UserAttemptQuizeController::class, 'UserQuizeList'])->name('UserQuizeList');
  Route::get('quize-join/{quize}', [UserAttemptQuizeController::class, 'quizeJoin'])->name('quizeJoin');
  Route::get('quize-decline/{quize}', [UserAttemptQuizeController::class, 'quizeDecline'])->name('quizeDecline');
  Route::get('user-question-listing/{quize}', [UserAttemptQuizeController::class, 'userQuestionListing'])->name('userQuestionListing');

  Route::get('time-over', [UserAttemptQuizeController::class, 'timeUp'])->name('timeUp');
  Route::post('user-save-quize-history', [UserAttemptQuizeController::class, 'userSaveQuizeHistory'])->name('userSaveQuizeHistory');

  
});




//social auth routes
Route::get('auth/{provider}', [SocialLoginController::class, 'socialLogin'])->name('socialLogin');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'socialLoginCallback'])->name('socialLoginCallback');


Route::get('test', function() {
  
  //$data = MailTemplate::find(3);
  
 // return (new SendClientMail($data))->render();
  
});

require __DIR__.'/auth.php';