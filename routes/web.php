<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\MainController;
use App\Http\Controllers\admin\ServicesController;
use App\Http\Controllers\admin\OrdersController;
use App\Http\Controllers\admin\ReportsController;

Auth::routes();

// ✅ Admin Panel (role 1 and 2)
Route::middleware(['auth', 'isAdmin'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });

    // Dashboard
    Route::get('admin/dashboard/index', [MainController::class, 'index'])->name('dashboard.index');

    // Services
    Route::prefix('admin/services')->name('services.')->group(function () {
        Route::get('index', [ServicesController::class, 'index'])->name('index');
        Route::get('create', [ServicesController::class, 'create'])->name('create');
        Route::post('store', [ServicesController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ServicesController::class, 'edit'])->name('edit');
        Route::post('update', [ServicesController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [ServicesController::class, 'destroy'])->name('destroy');
    });

    // POS
    Route::prefix('admin/pos')->name('pos.')->group(function () {
        Route::get('index', [OrdersController::class, 'pos'])->name('index');
    });

    // Orders
    Route::prefix('admin/orders')->name('orders.')->group(function () {

        Route::get('index', [OrdersController::class, 'index'])->name('index');
        Route::get('create', [OrdersController::class, 'create'])->name('create');

        // POS screen
        Route::get('pos', [OrdersController::class, 'pos'])->name('pos');

        // Save bill
        Route::post('store', [OrdersController::class, 'store'])->name('store');

        Route::get('edit/{id}', [OrdersController::class, 'edit'])->name('edit');
        Route::post('update', [OrdersController::class, 'update'])->name('update');

        Route::get('destroy/{id}', [OrdersController::class, 'destroy'])->name('destroy');

        // Invoice & Print
        Route::get('{id}/invoice', [OrdersController::class, 'invoice'])->name('invoice');
        Route::get('{id}/print', [OrdersController::class, 'print'])->name('print');
    });

    // ✅ Reports (ONLY Super Admin role=1)
    Route::middleware('isSuperAdmin')->prefix('admin/reports')->name('reports.')->group(function () {
        Route::get('daily', [ReportsController::class, 'daily'])->name('daily');
        Route::get('weekly', [ReportsController::class, 'weekly'])->name('weekly');
        Route::get('monthly', [ReportsController::class, 'monthly'])->name('monthly');
        Route::get('yearly', [ReportsController::class, 'yearly'])->name('yearly');
    });
});

