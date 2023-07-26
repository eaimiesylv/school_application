<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\KlassController;
use App\Http\Controllers\User\SubjectController;
use App\Http\Controllers\User\SessionController;
use App\Http\Controllers\User\AssessmentController;
use App\Http\Controllers\User\StudentController;
use App\Http\Controllers\User\SubjectAllocationController;
use App\Http\Controllers\User\ScoreController;
use App\Http\Controllers\User\MergeSubjectController;


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

// Public routes
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'store']);
Route::get('klass', [KlassController::class, 'index']);
Route::get('session', [SessionController::class, 'index']);

// Protected routes - Require authentication (sanctum middleware)
Route::middleware('auth:sanctum')->group(function () {
    // Klass routes
   
    Route::resource('klass', KlassController::class)->except('index');
    Route::get('/klass_subject', [KlassController::class, 'klass_subject']);
    Route::get('/klass_subject/{id}', [KlassController::class, 'klass_subject_classid']);
    Route::get('/klass_subject_allocation/{sessionid}', [KlassController::class, 'klass_subject_allocation']);
    Route::get('/klass_subject_merge/{sessionid}', [KlassController::class, 'klass_subject_merge']);
    Route::get('/klass_subject_allocated_teacher/{sessionid}', [KlassController::class, 'klass_subject_allocation_teacher']);
    Route::get('/klass_student/{classid}/{sessionid}', [KlassController::class, 'klass_student']);
    // Subject routes
    Route::resource('subject', SubjectController::class);
    // Session routes
    Route::resource('session', SessionController::class)->except('index');
    Route::resource('student', StudentController::class);
    Route::get('session_assessment', [SessionController::class, 'session_assessment']);
    // Assessment routes
    Route::resource('assessment', AssessmentController::class);
    Route::resource('user', UserController::class)->except('store');
    Route::get('/allteacher',[UserController::class, 'allteacher']);
    Route::resource('subject_allocation', SubjectAllocationController::class);
    Route::resource('merge_subject', MergeSubjectController::class);
    Route::resource('score', ScoreController::class);
});
