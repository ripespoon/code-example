<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnDemandController;
use App\Http\Controllers\OnDemandCategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\AdminController;

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

/**
 * User Authentication, Registration and Password Resets.
 */
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot', [AuthController::class, 'forgot']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth:api', 'cors'], function() {

    /**
     * Fetch the currently authed user.
     */
    Route::get('me', function(Request $request) {
        return $request->user();
    });

    /**
     * Fetch listing of on demand videos.
     */
    Route::get('on-demand/library', [OnDemandController::class, 'library']);

    /**
     * Store a new video resource.
     */
    Route::post('on-demand/library', [OnDemandController::class, 'store']);

    /**
     * Upload image for a on demand resource.
     */
    Route::post('on-demand/library/{ondemand}/upload-image', [OnDemandController::class, 'uploadImage']);

    /**
     * Upload video for a on demand resource.
     */
    Route::post('on-demand/library/{ondemand}/upload-video', [OnDemandController::class, 'uploadVideo']);

    /**
     * Fetch listing of on demand categories.
     */
    Route::get('on-demand/categories', [OnDemandCategoryController::class, 'all']);

    /**
     * Store a new category.
     */
    Route::post('on-demand/category', [OnDemandCategoryController::class, 'store']);

    /**
     * Upload image for a on demand category.
     */
    Route::post('on-demand/category/{category}/upload-image', [OnDemandCategoryController::class, 'uploadImage']);



    /**
     * Fetch listing of members.
     */
    Route::get('members', [MemberController::class, 'all']);

    /**
     * Load a single member profile.
     */
    Route::get('members/{member}', [MemberController::class, 'single']);



    /**
     * Fetch listing of trainers.
     */
    Route::get('trainers', [TrainerController::class, 'all']);

    /**
     * Load a single trainers profile.
     */
    Route::get('trainers/{trainers}', [TrainerController::class, 'single']);

    /**
     * Validate and store a new trainer account.
     */
    Route::post('trainers', [TrainerController::class, 'store']);

    /**
     * Upload profile picture for a trainer.
     */
    Route::post('trainers/{user}/upload-image', [TrainerController::class, 'uploadImage']);



    /**
     * Fetch listing of admins.
     */
    Route::get('admins', [AdminController::class, 'all']);

    /**
     * Load a single admin profile.
     */
    Route::get('admins/{user}', [AdminController::class, 'single']);

    /**
     * Validate and store a new admin account.
     */
    Route::post('admins', [AdminController::class, 'store']);

    /**
     * Upload profile picture for an admin.
     */
    Route::post('admins/{user}/upload-image', [AdminController::class, 'uploadImage']);
});
