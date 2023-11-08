<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//controllers
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProgramController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//logs of the students about their payment
Route::get('/student-logs/{student_id}', [
    PaymentController::class,
    'getStudentLogs',
]);

//====================================================

//search a specific student
Route::get('/search-student/{student_id}', [
    PaymentController::class,
    'searchStudent',
]);

//get all the admins under a specific college
Route::get('/get-admin/{college_id}', [
    AdminController::class,
    'getAllAdminSpecificCollege',
]);

//add new payment of college fee
Route::post('/add-payment', [PaymentController::class, 'addPayment']);

//get the total collection of college fee of a specific college
Route::get('/get-total-payment/{college_id}', [
    PaymentController::class,
    'getTotalPayment',
]);

//get all the list of payments of college fee of a specific college
Route::get('/get-all-payment', [PaymentController::class, 'getAllPayment']);

//this is for scanning the qr code of the student, to get the student id
Route::get('/get-student-payment/{id}', [
    PaymentController::class,
    'getStudentBalance',
]);

//get the latest payment
Route::get('/get-latest-payment', [
    PaymentController::class,
    'getLastPaymentAr',
]);

//get the last 7 days of collection of a specific college with percentange
Route::get('/last-7-days/{id}', [
    PaymentController::class,
    'getPercentageOfLast7daysCollection',
]);

//get the last 30 days of collection of a specific college with percentange
Route::get('/last-30-days/{id}', [
    PaymentController::class,
    'getPercentageOfLast30daysCollection',
]);

//get the total number of student per program of a specific college
Route::get('/get-count-programs', [
    ProgramController::class,
    'getCountOfPrograms',
]);

//get the total amount of already paid of a specific student
Route::get('/get-total-student-payment/{id}', [
    PaymentController::class,
    'getTotalPaymentOfStudent',
]);
// Route::get(
//     '/data-student' . [PaymentController::class, 'getPaymentByStudentId']
// );
