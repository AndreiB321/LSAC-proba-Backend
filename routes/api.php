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


// Route::post('/auth/register', function() {
//     return '/auth/register';
// });

// Route::post('/auth/login', function() {
//     return '/auth/login';
// });

// Route::get('/users', function() {
//     return '/users';
// });

// Route::get('/users/{id}', function() {
//     return '/users/{id}';
// });

// Route::patch('/users/{id}', function() {
//     return '/users/{id}';
// });

// Route::delete('/users/{id}', function() {
//     return '/users/{id}';
// });

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);


Route::get('/contact-requests', [ContactRequestsController::class, 'index']);
Route::get('/contact-requests/{id}', [ContactRequestsController::class, 'show']);
Route::post('/contact-requests', [ContactRequestsController::class, 'store']);
Route::delete('/contact-requests/{id}', [ContactRequestsController::class, 'destroy']);
Route::patch('/contact-requests/{id}', [ContactRequestsController::class, 'update']);

Route::get('/reviews', [ReviewsController::class, 'index']);
Route::get('/reviews/{id}', [ReviewsController::class, 'show']);
Route::post('/reviews', [ReviewsController::class, 'store']);
Route::delete('/reviews/{id}', [ReviewsController::class, 'destroy']);
Route::patch('/reviews/{id}', [ReviewsController::class, 'update']);


Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/{id}', [UsersController::class, 'show']);
Route::post('/auth/register', [UsersController::class, 'store']);
Route::post('/auth/login', [UsersController::class, 'login']);
Route::delete('/users/{id}', [UsersController::class, 'destroy']);
Route::patch('/users/{id}', [UsersController::class, 'update']);


Route::get('/tutoring-classes', [TutoringClassController::class, 'index']);
Route::get('/tutoring-classes/{id}', [TutoringClassController::class, 'show']);
Route::post('/tutoring-classes', [TutoringClassController::class, 'store']);
Route::delete('/tutoring-classes/{id}', [TutoringClassController::class, 'destroy']);
Route::patch('/tutoring-classes/{id}', [TutoringClassController::class, 'update']);

// Route::get('/reviews', function(){
//     return 'reviews';
// });

// Route::get('/products', function(){
//     return 'products2';
// });

// Route::post('/reviews', function() {
//     return Reviews::create([
//         'message' => 'Alex',
//     ]);
// });

// Route::post('/contact-requests', function() {
//     return ContactRequests::create([
//         'name' => 'Alex',
//         'email' => 'test@gmail.com',
//         'message' => 'un inceput de test',
//         'is_resolved' => 'false'
//     ]);
// });


// Route::group(['middleware' => ['auth:sanctum']],  function () {
//     return 'good';
// });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
