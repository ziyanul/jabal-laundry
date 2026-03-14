<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    OrderController,
    CustomerController,
    ServiceController,
    OutletController,
    PaymentController,
    UserController,
    RackController,
    ReportController
};

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    // =====================
    // DASHBOARD
    // =====================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // =====================
    // PROFILE
    // =====================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        // MASTER DATA
        Route::resource('customers', CustomerController::class);

        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('outlets', OutletController::class)->except(['show']);

        // REPORT
        Route::get('/reports/cash-daily', [ReportController::class, 'cashDaily'])
            ->name('reports.cash-daily');

            //RACKS
        Route::resource('racks', RackController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | KASIR & ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,kasir')->group(function () {

        Route::prefix('orders')->group(function () {

            Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
            Route::post('/', [OrderController::class, 'store'])->name('orders.store');

            Route::get('/{order:order_code}', [OrderController::class, 'show'])
                ->name('orders.show');

            // pembayaran
            Route::post('/{order}/payment', [PaymentController::class, 'store'])
                ->name('orders.payment');

            // cetak nota
            Route::get('/{order:order_code}/print', [OrderController::class, 'print'])
                ->name('orders.print');
                Route::get('/{order:order_code}/print-all',
    [OrderController::class, 'printAll']
)->name('orders.print.all');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | KARYAWAN, KASIR, ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,kasir,karyawan')->group(function () {

        Route::post('/orders/{order:order_code}/status', 
            [OrderController::class, 'updateStatus']
        )->name('orders.update-status');
    });

    Route::middleware('role:admin,owner')->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});


});
