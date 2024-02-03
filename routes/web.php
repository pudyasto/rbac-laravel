<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * !!! INFORMASI !!!
 * Untuk melakukan generate path module secara otomatis
 * gunakan perintah `php artisan module:permission`
 */

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('home');
    } else {
        return redirect('login');
    }
});

// Route Authentication Only
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::group([
        'prefix' => 'home',
    ], function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
    });


    // Route untuk modul personal
    Route::group([
        'prefix' => 'personal',
    ], function () {
        Route::get('/', [PersonalController::class, 'index'])->name('personal');
        Route::post('/updatePassword', [PersonalController::class, 'updatePassword'])->name('updatePassword');
        Route::post('/updateProfile', [PersonalController::class, 'updateProfile'])->name('updateProfile');
    });

    // Route untuk modul reference
    Route::group([
        'prefix' => 'reference',
    ], function () {
        Route::get('/getNIK', [ReferenceController::class, 'getNIK'])->name('getNIK');
        Route::get('/getRole', [ReferenceController::class, 'getRole'])->name('getRole');
    });
});

// Rout Authentication and Authorization
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'can:Access'])->group(function () {
    // Route untuk modul menus
    Route::group([
        'prefix' => 'menus',
    ], function () {
        Route::get('/', [MenusController::class, 'index'])->name('menus');
        Route::post('/tableMain', [MenusController::class, 'tableMain']);
        Route::post('/getMainMenu', [MenusController::class, 'getMainMenu']);

        Route::get('/create', [MenusController::class, 'create']);
        Route::get('/edit/{id}', [MenusController::class, 'edit']);

        Route::post('/store', [MenusController::class, 'store']);
        Route::post('/update/{id}', [MenusController::class, 'update']);
        Route::post('/destroy/{id}', [MenusController::class, 'destroy']);
    });


    // Route untuk modul users
    Route::group([
        'prefix' => 'users',
    ], function () {
        Route::get('/', [UsersController::class, 'index'])->name('users');
        Route::post('/tableMain', [UsersController::class, 'tableMain']);

        Route::get('/create', [UsersController::class, 'create']);
        Route::get('/edit/{id}', [UsersController::class, 'edit']);

        Route::post('/store', [UsersController::class, 'store']);
        Route::post('/update/{id}', [UsersController::class, 'update']);
        Route::post('/destroy/{id}', [UsersController::class, 'destroy']);
    });

    // Route untuk modul modules
    Route::group([
        'prefix' => 'modules',
    ], function () {
        Route::get('/', [ModulesController::class, 'index'])->name('modules');
        Route::post('/tableMain', [ModulesController::class, 'tableMain']);

        Route::get('/create', [ModulesController::class, 'create']);
        Route::get('/edit/{id}', [ModulesController::class, 'edit']);

        Route::post('/store', [ModulesController::class, 'store']);
        Route::post('/update/{id}', [ModulesController::class, 'update']);
        Route::post('/destroy/{id}', [ModulesController::class, 'destroy']);

        Route::get('/formAction/{id}', [ModulesController::class, 'formAction']);
        Route::post('/storeAction/{id}', [ModulesController::class, 'storeAction']);
        Route::post('/deleteAction/{id}', [ModulesController::class, 'deleteAction']);
        Route::post('/tableDetail', [ModulesController::class, 'tableDetail']);
    });

    // Route untuk modul roles
    Route::group([
        'prefix' => 'roles',
    ], function () {
        Route::get('/', [RolesController::class, 'index'])->name('roles');
        Route::post('/tableMain', [RolesController::class, 'tableMain']);

        Route::get('/create', [RolesController::class, 'create']);
        Route::get('/edit/{id}', [RolesController::class, 'edit']);

        Route::post('/store', [RolesController::class, 'store']);
        Route::post('/update/{id}', [RolesController::class, 'update']);
        Route::post('/destroy/{id}', [RolesController::class, 'destroy']);

        Route::get('/formRoleMenus/{id}', [RolesController::class, 'formRoleMenus']);
        Route::post('/storeRoleMenus/{id}', [RolesController::class, 'storeRoleMenus']);
        Route::post('/tableDetailRoleMenus', [RolesController::class, 'tableDetailRoleMenus']);

        Route::get('/formRoleModules/{id}', [RolesController::class, 'formRoleModules']);
        Route::post('/getListModule', [RolesController::class, 'getListModule']);
        Route::post('/storeRoleModules/{id}', [RolesController::class, 'storeRoleModules']);
    });
});


/*
 * !!! INFORMASI !!!
 * Untuk melakukan generate path module secara otomatis
 * gunakan perintah `php artisan module:permission`
 */
