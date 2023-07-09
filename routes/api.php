<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'V1', 'namespace' => 'App\Http\Controllers\API\V1', 'middleware' => 'auth:sanctum'], function() {
    Route::apiResource('vocabulary', VocabularyController::class);
    Route::apiResource('player', PlayerController::class);
    Route::apiResource('quiz', QuizController::class);
    Route::apiResource('quiz-answer', QuizAnswerController::class)->only(['show', 'update']);

    Route::get('player/{player}/quizzes', [App\Http\Controllers\API\V1\PlayerController::class, 'quizzes'])->name('player.quizzes');
    Route::get('player/{player}/vocabularies', [App\Http\Controllers\API\V1\PlayerController::class, 'vocabularies'])->name('player.vocabularies');
});

Route::post('/login', LoginController::class)->name('login.login');

Route::post('/register', RegisterController::class)->name('register.register');
