<?php


use App\Http\Controllers\ContectController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TestimonialController;


Route::post('/subscribe', [SubscribeController::class, 'subscribe']);
Route::post('/contect', [ContectController::class, 'contect']);
Route::get('/subscribers', [SubscribeController::class, 'getSubscribers']);
Route::get('/contacts', [SubscribeController::class, 'getcontacts']);
Route::delete('/subscriber/{id}', [SubscribeController::class, 'deleteSubscriber']);
Route::delete('/contact/{id}', [SubscribeController::class, 'deletecontact']);
Route::post('/project', [ProjectController::class, 'createProject']);
Route::get('/projects', [ProjectController::class, 'getProjects']);
Route::delete('/project/{id}', [ProjectController::class, 'delete']);
Route::put('/projects/{id}', [ProjectController::class, 'updateProject']);


// Standard CRUD resource (index, store, show, update, destroy)
Route::apiResource('services', ServicesController::class);

// Extra actions
Route::patch('services/{service}/toggle',  [ServicesController::class, 'toggle'])->name('services.toggle');
Route::post('/store',  [ServicesController::class, 'store']);
Route::patch('services/{service}/toggle', [ServicesController::class, 'toggle'])
    ->name('services.toggle');
Route::apiResource('services', ServicesController::class);


Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::post('/testimonials', [TestimonialController::class, 'store']);
Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update']);
Route::patch('/testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggle']);
Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy']);

Route::get('/jobs', [JobController::class, 'index']);
Route::post('/add/jobs', [JobController::class, 'store']);
Route::put('/jobs/{careers}', [JobController::class, 'update']);
Route::patch('/jobs/{careers}/toggle', [JobController::class, 'toggle']);
Route::delete('/jobs/{careers}', [JobController::class, 'destroy']);



Route::post('/job-applications', [JobApplicationController::class, 'store']);
Route::get('/job-applications', [JobApplicationController::class, 'index']);
Route::delete('/job-applications/{id}', [JobApplicationController::class, 'destroy']);
Route::put('/job-applications/{id}/status', [JobApplicationController::class, 'updateStatus']);
