<?php


use App\Models\ContactRequests;
use App\Models\Reviews;
use App\Models\User;
use App\Models\TutoringClass;
use App\Models\Enrolment;

use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ContactRequestsController;
use App\Http\Controllers\TutoringClassController;
use App\Http\Controllers\EnrolmentController;

use Illuminate\Http\Request;
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

// public routes
Route::get('/contact-requests', [ContactRequestsController::class, 'index']);
Route::get('/contact-requests/{id}', [ContactRequestsController::class, 'show']);
Route::post('/contact-requests', [ContactRequestsController::class, 'store']);
Route::delete('/contact-requests/{id}', [ContactRequestsController::class, 'destroy']);
Route::patch('/contact-requests/{id}', [ContactRequestsController::class, 'update']);

Route::get('/reviews', [ReviewsController::class, 'index']);
Route::get('/reviews/{id}', [ReviewsController::class, 'show']);
Route::post('/reviews', [ReviewsController::class, 'store']);


Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/{id}', [UsersController::class, 'show']);
Route::post('/auth/register', [UsersController::class, 'store']);
Route::post('/auth/login', [UsersController::class, 'login']);


// private routes
Route::group(['middleware' => ['auth:sanctum']],  function () {
    Route::delete('/users/{id}', [UsersController::class, 'destroy']);
    Route::patch('/users/{id}', [UsersController::class, 'update']);

    Route::delete('/reviews/{id}', [ReviewsController::class, 'destroy']);
    Route::patch('/reviews/{id}', [ReviewsController::class, 'update']);

    Route::get('/tutoring-classes', [TutoringClassController::class, 'index']);
    Route::get('/tutoring-classes/{id}', [TutoringClassController::class, 'show']);
    Route::post('/tutoring-classes', [TutoringClassController::class, 'store']);
    Route::delete('/tutoring-classes/{id}', [TutoringClassController::class, 'destroy']);
    Route::patch('/tutoring-classes/{id}', [TutoringClassController::class, 'update']);

    Route::post('/tutoring-classes/{id}/enroll', [EnrolmentController::class, 'store']);

});


