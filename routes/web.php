<?php

use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\CronController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UnitController as AdminUnitsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ZoneController as AdminZonesController;
use App\Http\Controllers\Admin\LockController as AdminLockController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;
// Operator Controller
use App\Http\Controllers\Operator\IndexController as OperatorIndexController;
use App\Http\Controllers\Operator\LocationController as OperatorLocationController;
use App\Http\Controllers\Operator\ReportController as OperatorReportController;
use App\Http\Controllers\Operator\SettingsController as OperatorSettingsController;
use App\Http\Controllers\Operator\UnitController as OperatorUnitsController;
use App\Http\Controllers\Operator\UserController as OperatorUserController;
use App\Http\Controllers\Operator\ZoneController as OperatorZonesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('/', AdminIndexController::class);
    Route::resource('/roles', RolesController::class);
    Route::resource('/users', AdminUserController::class);
    Route::resource('/zones', AdminZonesController::class);
    Route::resource('/locations', AdminLocationController::class);
    Route::resource('/units', AdminUnitsController::class);
    Route::resource('/permissions', AdminPermissionController::class);
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::get('/lock', [AdminLockController::class, 'index'])->name('lock.index');
    Route::post('/lock-update', [AdminLockController::class, 'PhaseAndZoneLock'])->name('lock.update');

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/monthlyFlow', [AdminReportController::class, 'monthlyFlow'])->name('reports.monthlyFlow');
    Route::post('/reports/monthlyFlow', [AdminReportController::class, 'getMonthlyFlow'])->name('reports.get.monthlyFlow');
    Route::get('/reports/editMonthlyFlow/{month}/{unit}/{location}/{zone}', [AdminReportController::class, 'editMonthlyFlow'])->name('reports.editMonthlyFlow');
    Route::post('/reports/updateMonthlyFlow/{month}/{unit}/{location}/{zone}', [AdminReportController::class, 'updateMonthlyFlow'])->name('reports.updateMonthlyFlow');
    Route::get('/reports/singleUnitMonthlyFlow', [AdminReportController::class, 'singleUnitMonthlyFlow'])->name('reports.singleUnitMonthlyFlow');
    Route::post('/reports/singleUnitMonthlyFlow', [AdminReportController::class, 'getSingleUnitMonthlyFlow'])->name('reports.get.singleUnitMonthlyFlow');

    Route::get('/reports/eveningTotalizerReport', [AdminReportController::class, 'eveningTotalizerReport'])->name('reports.eveningTotalizerReport');
    Route::post('/reports/eveningTotalizerReport', [AdminReportController::class, 'getEveningTotalizerReport'])->name('reports.get.eveningTotalizerReport');

    Route::get('/reports/daily-totalizer-report', [AdminReportController::class, 'DailyTotalizerReport'])->name('reports.dailyTotalizerReport');
    Route::post('/reports/daily-totalizer-report', [AdminReportController::class, 'getDailyTotalizerReport'])->name('reports.get.dailyTotalizerReport');

    Route::get('/export/csv/{month}/{unit}/{location}/{zone}', [AdminReportController::class, 'exportCSVFile'])->name('export.csv');
    // Route::get('/unit/toggle-lock/{id}', [AdminUnitsController::class, 'toggleLock'])->name('unit.toggleLock');
});

Route::middleware(['auth', 'role:operator'])->name('operator.')->prefix('operator')->group(function () {
    Route::resource('/', OperatorIndexController::class);
    Route::resource('/users', OperatorUserController::class);
    Route::resource('/locations', OperatorLocationController::class);
    Route::resource('/zones', OperatorZonesController::class);
    Route::resource('/units', OperatorUnitsController::class);

    Route::get('/reports', [OperatorReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/monthlyFlow', [OperatorReportController::class, 'monthlyFlow'])->name('reports.monthlyFlow');
    Route::post('/reports/monthlyFlow', [OperatorReportController::class, 'getMonthlyFlow'])->name('reports.get.monthlyFlow');
    Route::get('/reports/singleUnitMonthlyFlow', [OperatorReportController::class, 'singleUnitMonthlyFlow'])->name('reports.singleUnitMonthlyFlow');
    Route::post('/reports/singleUnitMonthlyFlow', [OperatorReportController::class, 'getSingleUnitMonthlyFlow'])->name('reports.get.singleUnitMonthlyFlow');
    Route::get('/export/csv/{month}/{unit}/{location}/{zone}', [OperatorReportController::class, 'exportCSVFile'])->name('export.csv');

    Route::get('/settings', [OperatorSettingsController::class, 'index'])->name('settings.index');

});
// cron job routes
Route::get('/morning-flow', [CronController::class, 'morningFlow']);
Route::get('/evening-flow', [CronController::class, 'eveningFlow']);
Route::get('/daily-data-flow', [CronController::class, 'dailyDataFlow']);
Route::get('/daily-totalizer-delete', [CronController::class, 'dailyTotalizerFlowDelete']);

Route::get('/panel-lock', [CronController::class, 'panellock']);
Route::get('/panel-auto-lock-unlock', [CronController::class, 'panelAutoLockUnlock']);
Route::get('/send-over-limit-mail', [CronController::class, 'sendOverLimitReport']);
require __DIR__.'/auth.php';
