<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

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

Auth::routes();

Route::get('/quiz', [App\Http\Controllers\HomeController::class, 'index'])->name('quiz');
Route::any('/submit-question', [App\Http\Controllers\HomeController::class, 'submit_question'])->name('submit-question');


Route::group(['middleware' => ['auth','AdminMiddleware']], function (){
	Route::get('/home', [QuizController::class, 'index']);
    Route::any('/add-qestion', [QuizController::class, 'store']);
    Route::any('/show/{id}', [QuizController::class, 'show']);
    Route::post('/edit-qestion/{id}', [QuizController::class, 'update']);
    Route::get('/delete-qestion/{id}', [QuizController::class, 'destroy']);
});