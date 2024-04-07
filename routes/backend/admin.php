<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });
Route::get('table/controller', [DashboardController::class, 'tableController'])
    ->name('table.controller')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('dashboard'), route('admin.table.controller'));
    });
Route::post('update/tables', [DashboardController::class, 'updateTables'])->name('table.update');
