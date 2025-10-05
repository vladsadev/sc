<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrillingGridController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\InspectionIssueController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
//    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('can:admin-access,can:super-admin')->group(function () {
        //Users - Roles
        Route::get('/users', [UserRoleController::class, 'index'])->name('user-role.index');
        Route::get('/user/create', [UserRoleController::class, 'create'])->name('user-role.create');
        Route::get('/users/{user}/edit', [UserRoleController::class, 'edit'])->name('user-role.edit');
        Route::post('/users', [UserRoleController::class, 'store'])->name('user-role.store');
        Route::patch('/users/{user}/edit', [UserRoleController::class, 'update'])->name('user-role.update');
        Route::delete('/users/{user}', [UserRoleController::class, 'destroy'])->name('user-role.destroy');
    });

    //Reportes Page en Dashboard
    Route::view('/reportes', 'dashboard.reportes')->name('reportes');

    //Equipos
    Route::get('/catalogo', [EquipmentController::class, 'index'])->name('equipment.index');

    Route::middleware('can:admin-access')->group(function () {
        Route::get('/catalogo/crear', [EquipmentController::class, 'create'])->name('equipment.create');
        Route::get('/catalogo/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
        Route::patch('/catalog/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
        Route::delete('/catalog/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');
        Route::get('/catalogo/{equipment}/delete-confirm', [EquipmentController::class, 'confirmDelete'])->name('equipment.confirm-delete');
    });

    Route::get('/catalogo/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');
    Route::post('/catalogo', [EquipmentController::class, 'store'])->name('equipment.store');

    // Manuales
    Route::resource('manual', ManualController::class);
    Route::get('manual/{manual}/download', [ManualController::class, 'download'])->name('manual.download');

    //Inspecciones
    Route::view('/inspecciones', 'dashboard.reportes');
    Route::get('/inspecciones/{inspection}', [InspectionController::class, 'show'])->name('inspection.show');
    Route::get('/inspecciones/crear/{equipment}', [InspectionController::class, 'create'])->name('inspection.create');

    // Malla de Perforaciones
    Route::get('/malla', [DrillingGridController::class, 'index'])->name('malla');

    // PDF como imágenes usando ImageMagick
    Route::get('/malla/pdf/{id}/image/{page?}', [App\Http\Controllers\ImageMagickPdfController::class, 'viewAsImage'])
        ->name('malla.pdf.image');
    Route::get('/malla/pdf/{id}/pages', [App\Http\Controllers\ImageMagickPdfController::class, 'getPageCount'])
        ->name('malla.pdf.pages');


    //Mantenimiento
    Route::get('maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('maintenances/create/{equipment}', [MaintenanceController::class, 'create'])->name('maintenances.create');
    Route::post('maintenances', [MaintenanceController::class, 'store'])->name('maintenances.store');
    Route::get('maintenances/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenances.show');
    Route::get('maintenances/{maintenance}/edit', [MaintenanceController::class, 'edit'])->name('maintenances.edit');
    Route::patch('maintenances/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenances.update');

    Route::middleware('can:admin-access')->group(function () {
        Route::delete('maintenances/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');
    });

    // Rutas adicionales para cambios de estado
    Route::patch('maintenances/{maintenance}/start', [MaintenanceController::class, 'start'])->name('maintenances.start');
    Route::patch('maintenances/{maintenance}/complete', [MaintenanceController::class, 'complete'])->name('maintenances.complete');
    Route::patch('maintenances/{maintenance}/cancel', [MaintenanceController::class, 'cancel'])->name('maintenances.cancel');

    // Importación
    // Para el sistema central (importar)
    Route::get('/dashboard/import', [ImportController::class, 'showImportForm'])->name('import.form');
    Route::post('/dashboard/import', [ImportController::class, 'import'])->name('import.inspections');

// Para el sistema local (exportar)
    Route::get('/dashboard/export', [ExportController::class, 'export'])->name('export.inspections');


});
