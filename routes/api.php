<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\TypeInstrumentController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\NationalDirectionController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\ServicePlaceController;
use App\Http\Controllers\DependenceController;
use App\Http\Controllers\ExonerationController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::group(
    [
        'middleware' => ['api', 'throttle:api'],
        'prefix' => 'auth'
    ],
    function ($router) {
        Route::post('login', [AuthController::class, 'login']);
    }
);

Route::group(
    [
        'middleware' => ['api', 'throttle:api', 'auth:api', 'log'],
        'prefix' => 'auth'
    ],
    function ($router) {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    }
);

Route::group(
    [
        'middleware' => ['api', 'throttle:api', 'auth:api', 'log', 'has.role:Administrador'],
    ],
    function ($router) {
        // Apis
        Route::resource('/department', DepartmentController::class);
        Route::resource('/municipality', MunicipalityController::class);
        Route::resource('/user', UserController::class);
        Route::resource('/instrument', InstrumentController::class);
        Route::resource('/exoneration', ExonerationController::class);
        Route::resource('/entity', EntityController::class);
        Route::resource('/direction', NationalDirectionController::class);
        Route::resource('/place', ServicePlaceController::class);
        Route::resource('/tariff', TariffController::class);
        Route::resource('/type', TypeInstrumentController::class);
        Route::resource('/sector', SectorController::class);
        Route::resource('/dependence', DependenceController::class);
        Route::resource('/role', RoleController::class);
    }
);