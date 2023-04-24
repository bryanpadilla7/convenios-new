<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\typeInstrumentController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\NationalDirectionController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\ServicePlaceController;
use App\Http\Controllers\DependenceController;
use App\Http\Controllers\ExonerationController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ExcelController;

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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes(['verify' => true, 'remember_me'=>false]);

Route::group(['middleware'=> ['auth', 'verified']], function () {
    Route::group(['middleware'=>['has.role:Administrador']], function () {
        // Apis
        Route::resource('/api/web/department', DepartmentController::class);
        Route::resource('/api/web/municipality', MunicipalityController::class);
        Route::resource('/api/web/instrument', InstrumentController::class);
        Route::resource('/api/web/exoneration', ExonerationController::class);
        Route::get('api/dependence/byDirectionName/{national_directions}', [DependenceController::class, 'byDirectionName']); 
        Route::resource('/api/web/type', TypeInstrumentController::class);
        Route::resource('/api/web/entity', EntityController::class);
        Route::resource('/api/web/tariff', TariffController::class);
        Route::resource('/api/web/place', ServicePlaceController::class);
        Route::get('api/tariff/byDependenceName/{dependences}', [TariffController::class, 'byDependenceName']);
        Route::resource('/api/web/dependence', DependenceController::class);
        Route::resource('/api/web/direction', NationalDirectionController::class);
        Route::resource('/api/web/sector', SectorController::class);
        Route::resource('/api/web/user', UserController::class);
        Route::resource('/api/web/role', RoleController::class);

        // Views
        Route::get('/departments', function () {
            return view('department.index');
        });

        Route::get('/municipalities', function () {
            return view('municipality.index');
        });

        Route::get('/users', function () {
            return view('user.index');
        });

        Route::get('/instruments', function () {
            return view('instrument.index');
        });

        Route::get('/entities', function () {
            return view('entity.index');
        });

        Route::get('/tariffs', function () {
            return view('tariff.index');
        });

        Route::get('/places', function () {
            return view('place.index');
        });

        Route::get('/directions', function () {
            return view('direction.index');
        });

        Route::get('/dependences', function () {
            return view('dependence.index');
        });

        Route::get('/types', function () {
            return view('type.index');
        });
        
        Route::get('/exonerations', function () {
            return view('exoneration.index');
        });

        Route::get('/reports', function () {
            return view('reports.index');
        });

        Route::get('/sectors', function () {
            return view('sector.index');
        });

        //Reports
        Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
        Route::get('pdf/reports', [PDFController::class, 'generatePDF']);

        //Excel
        Route::get('export', [ExcelController::class, 'export']);
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });

    Route::group(['middleware'=>['has.role:Administrador,Usuario']], function () {
        // Apis
        
        Route::resource('/api/web/instrument', InstrumentController::class);
        Route::resource('/api/web/exoneration', ExonerationController::class);
        Route::get('api/dependence/byDirectionName/{national_directions}', [DependenceController::class, 'byDirectionName']); 
        Route::resource('/api/web/type', TypeInstrumentController::class);
        Route::resource('/api/web/entity', EntityController::class);
        Route::resource('/api/web/tariff', TariffController::class);
        Route::resource('/api/web/place', ServicePlaceController::class);
        Route::get('api/tariff/byDependenceName/{dependences}', [TariffController::class, 'byDependenceName']);
        Route::resource('/api/web/dependence', DependenceController::class);
        Route::resource('/api/web/direction', NationalDirectionController::class);
        Route::resource('/api/web/exonerationDetail', ExonerationDetailController::class);
        Route::resource('/api/web/sector', SectorController::class);
        Route::resource('/api/web/user', UserController::class);
        Route::resource('/api/web/role', RoleController::class);

        // Views
        Route::get('/instruments', function () {
            return view('instrument.index');
        });

        Route::get('/reports', function () {
            return view('reports.index');
        });

        Route::get('/places', function () {
            return view('place.index');
        });

        //Reports
        Route::get('generate-pdf', [PDFController::class, 'generatePDF']);
        Route::get('pdf/reports', [PDFController::class, 'generatePDF']);

        //Excel
        Route::get('export', [ExcelController::class, 'export']);
        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });
});

Route::post('import', [ExcelController::class, 'import']);
