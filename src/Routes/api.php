<?php

use Pishgaman\Pishgaman\Http\Controllers\Api\AccessLevelController;
use Pishgaman\Pishgaman\Http\Controllers\Api\UsersController;
use Pishgaman\Pishgaman\Http\Controllers\Api\HistoryController;
use Pishgaman\Pishgaman\Http\Controllers\Api\ProfileController;
use Pishgaman\Pishgaman\Http\Controllers\Api\DownloadController;
use Pishgaman\Pishgaman\Http\Controllers\Api\departmentsController;

Route::group(['namespace' => 'Pishgaman\Pishgaman\Http\Controllers\Api','middleware' => [ 'auth:sanctum' ] ], function() {
    Route::prefix('api/admin')->group(function () {
        Route::match(['get','post','put','delete'], 'AccessLevel', [AccessLevelController::class, 'action'])->name('PAdminAccessLevelApi');    
        Route::match(['get','post','put','delete'], 'users', [UsersController::class, 'action'])->name('PAdminUsersApi');    
        Route::match(['get','post','put','delete'], 'history', [HistoryController::class, 'action'])->name('PHistoryApi');    
        Route::match(['get','post','put','delete'], 'departments', [departmentsController::class, 'action'])->name('PAdminDepartmentsApi');    
    });

    Route::match(['get','post','put','delete'],'api/profile', [ProfileController::class, 'action'])->name('homeApi');
    Route::match(['get','post','put','delete'],'api/download', [DownloadController::class, 'action'])->name('downloadApi');
    
});

Route::group(['namespace' => 'Pishgaman\Pishgaman\Http\Controllers\Api','middleware' => ['web']], function() {
    Route::prefix('api')->group(function () {
        Route::post('auth', 'AuthController@action');
    });
});
