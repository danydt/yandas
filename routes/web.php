<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BudgetAccountController;
use App\Http\Controllers\BudgetAccountNatureController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetGroupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\ExpectationController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function() {

    Route::post('/expectations/save', [OrderController::class, 'save'])->name('expectations.save');
    Route::get('/expectations/{expectation}/toggle', [OrderController::class, 'toggle'])->name('expectations.toggle');
    Route::post('/expectations/{expectation}/decision', [OrderController::class, 'decision'])->name('expectations.decision');
    Route::get('/approvals/{expectation}/history', [OrderController::class, 'history'])->name('approvals.history');
    Route::get('/dictionaries/search', [OrderController::class, 'search'])->name('dictionaries.search');
    Route::get('/users/search', [OrderController::class, 'search'])->name('users.search');
    Route::get('/users/search2', [OrderController::class, 'search2'])->name('users.search2');
    Route::match(['get', 'post'], '/reporting/accounts', [OrderController::class, 'accounts'])->name('reporting.accounts');
    Route::match(['get', 'post'], '/reporting/revenues', [OrderController::class, 'revenues'])->name('reporting.revenues');
    Route::match(['get', 'post'], '/reporting/investments', [OrderController::class, 'investments'])->name('reporting.investments');

    Route::post('/entities/{entity}/add-child', [OrderController::class, 'child'])->name('entities.add-child');

    Route::get('/payments/configs', [PaymentController::class, 'configs'])->name('payments.configs');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/proformas/{proforma}/download', [ProformaController::class, 'download'])->name('proformas.download');

    Route::resources([
        'orders' => OrderController::class,
        'categories' => OrderController::class,
        'roles' => RoleController::class,
        'privileges' => OrderController::class,
        'proformas' => ProformaController::class,
        'users' => UserController::class,
        'clients' => ClientController::class,
        'payments' => PaymentController::class,
        'reporting' => OrderController::class,
        'currencies' => CurrencyController::class,
        'investments' => OrderController::class,
    ]);
});
