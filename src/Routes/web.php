<?php

use Pishgaman\Pishgaman\Http\Controllers\Web\HomeController;
use Pishgaman\Pishgaman\Http\Controllers\Web\TestController;
use Pishgaman\Pishgaman\Http\Controllers\Web\AuthController;
use Pishgaman\Pishgaman\Http\Controllers\Web\welcomeController;
use Pishgaman\Pishgaman\Http\Controllers\Web\AccessLevelController;
use Pishgaman\Pishgaman\Http\Controllers\Web\UsersController;
use Pishgaman\Pishgaman\Http\Controllers\Web\departmentsController;
use Pishgaman\Pishgaman\Http\Controllers\Web\SanctumController;
use Pishgaman\Pishgaman\Http\Controllers\Web\HistoryController;
use Pishgaman\Pishgaman\Http\Controllers\Web\DownloadController;
use Pishgaman\BackUpDB\Http\Controllers\BackUpController;
use Illuminate\Http\Request;

Route::namespace('Pishgaman\Pishgaman\Http\Controllers\Web')->middleware('web')->group(function () {
    // Admin Routes
    Route::prefix('admin')->middleware('auth')->group(function () {
        Route::get('test', [TestController::class, 'action'])->name('PTest');
        Route::get('accesslevel', [AccessLevelController::class, 'action'])->name('PAdminAccessLevel');
        Route::get('users', [UsersController::class, 'action'])->name('PAdminUsers');
        Route::get('history', [HistoryController::class, 'action'])->name('PAdminHistory');
        Route::get('departments', [departmentsController::class, 'departments'])->name('PAdminDepartments');
        Route::get('messages', [messagesController::class, 'messages'])->name('PMessages');
        Route::get('backup', [departmentsController::class, 'action'])->name('BackUpAction');
    });

    // General Routes
    Route::get('home', [HomeController::class, 'action'])->name('home')->middleware('auth');
    Route::get('', [welcomeController::class, 'index'])->name('welcom');
    Route::get('download', [DownloadController::class, 'download'])->name('download')->middleware('auth');
    Route::get('download/list', [DownloadController::class, 'downloadList'])->name('downloadList')->middleware('auth');
    Route::match(['get'], 'auth', [AuthController::class, 'action'])->name('auth')->middleware('web');

    // Redirect Routes
    Route::get('register', function () {
        return redirect()->route('auth', ['action' => 'mainAuth', 'type' => 'register']);
    })->name('register');
    Route::get('login', function () {
        return redirect()->route('auth', ['action' => 'mainAuth', 'type' => 'login']);
    })->name('login');
});

Route::middleware('web')->post('/sanctum/csrf-cookie', [SanctumController::class, 'setCsrfCookie']);
Route::middleware('web')->get('/sanctum/getToken', [SanctumController::class, 'getToken']);
