<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;

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

Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);

Route::group(["middleware" => ["auth:api"]], function(){

    Route::get("profile", [UserController::class, "profile"]);
    Route::get("refresh", [UserController::class, "refreshToken"]);
    Route::get("logout", [UserController::class, "logout"]);

    // course api routes
    Route::post("course-enroll", [CourseController::class, "courseEnroll"]);
    Route::get("total-courses", [CourseController::class, "totalCourses"]);
    Route::delete("delete-course/{id}", [CourseController::class, "deleteCourse"]);
});

