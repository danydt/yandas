<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BudgetAccountController;
use App\Http\Controllers\BudgetAccountNatureController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetGroupController;
use App\Http\Controllers\CategoryController;
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
    Route::get('/accounts/search', [OrderController::class, 'search'])->name('accounts.search');
    Route::get('/accounts/search2', [OrderController::class, 'search2'])->name('accounts.search2');
    Route::get('/accounts/search3', [OrderController::class, 'search3'])->name('accounts.search3');
    Route::post('/accounts/{account}/add-user', [OrderController::class, 'addUser'])->name('accounts.add-user');
    Route::get('/accounts/{account}/remove-user/{user}', [OrderController::class, 'removeUser'])->name('accounts.remove-user');
    Route::get('/accounts/{account}/level-up/{user}', [OrderController::class, 'levelUp'])->name('accounts.level-up');
    Route::get('/accounts/{account}/level-down/{user}', [OrderController::class, 'levelDown'])->name('accounts.level-down');
    Route::get('/accounts/{account}/remove/{entity}', [OrderController::class, 'remove'])->name('accounts.remove');
    Route::post('/natures/{nature}/add-template', [OrderController::class, 'addTemplate'])->name('natures.add-template');
    Route::post('/entities/{entity}/affect', [OrderController::class, 'affect'])->name('entities.affect');
    Route::match(['get', 'post'], '/reporting/accounts', [OrderController::class, 'accounts'])->name('reporting.accounts');
    Route::match(['get', 'post'], '/reporting/revenues', [OrderController::class, 'revenues'])->name('reporting.revenues');
    Route::match(['get', 'post'], '/reporting/investments', [OrderController::class, 'investments'])->name('reporting.investments');
    Route::get('/natures/{nature}/html', [OrderController::class, 'html'])->name('natures.html');
    Route::get('/groups/{group}/html', [OrderController::class, 'html'])->name('groups.html');
    Route::get('/groups/{code}/html-filtered', [OrderController::class, 'htmlFiltered'])->name('groups.html-filtered');
    Route::get('/budgets/{id}/investments-html', [OrderController::class, 'investmentsHtml'])->name('budgets.investments-html');

    Route::post('/entities/{entity}/add-child', [OrderController::class, 'child'])->name('entities.add-child');

    Route::get('/payments/configs', [PaymentController::class, 'configs'])->name('payments.configs');
    Route::get('/expectations/new-create', [OrderController::class, 'newCreate'])->name('expectations.new-create');
    Route::get('/expectations/init', [OrderController::class, 'init'])->name('expectations.init');
    Route::get('/expectations/investment', [OrderController::class, 'investment'])->name('expectations.investment');
    Route::post('/expectations/store2', [OrderController::class, 'store2'])->name('expectations.store2');
    Route::get('/proformas/{proforma}/download', [ProformaController::class, 'download'])->name('proformas.download');

    Route::resources([
        'orders' => OrderController::class,
        'budgets' => OrderController::class,
        'accounts' => OrderController::class,
        'expectations' => OrderController::class,
        'categories' => OrderController::class,
        'dictionaries' => OrderController::class,
        'roles' => RoleController::class,
        'privileges' => OrderController::class,
        'proformas' => ProformaController::class,
        'users' => OrderController::class,
        'payments' => PaymentController::class,
        'reporting' => OrderController::class,
        'approvals' => OrderController::class,
        'natures' => OrderController::class,
        'currencies' => CurrencyController::class,
        'investments' => OrderController::class,
    ]);
});
