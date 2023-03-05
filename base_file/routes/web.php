<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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

Route::get('/', [PageController::class, 'index'])->name('index');

Route::post('/search', [PageController::class, 'search'])->name('search');

Route::get('/{url?}', function($url){
    if($url=='librarian' || $url=='login' || $url=='admin'){
        return redirect(route('librarian.login'));
    }
    abort(404);
});

Route::get('/librarian/login', [PageController::class, 'librarianLogin'])->name('librarian.login');

Route::post('/send/login', [PageController::class, 'sendLogin'])->name('send.login');
Route::post('/send/logout', [PageController::class, 'sendLogout'])->name('send.logout');

Route::get('/librarian/dashboard', [PageController::class, 'librarianDashboard'])->name('librarian.dashboard');

//borrower routes
Route::get('/librarian/borrower', [PageController::class, 'librarianBorrower'])->name('librarian.borrower');
Route::post('/register/borrower',[PageController::class, 'registerBorrower'])->name('register.borrower');
Route::post('/reject/borrower',[PageController::class, 'rejectBorrower'])->name('reject.borrower');
Route::post('/delete/rejected/borrower',[PageController::class, 'deleteRejectedBorrower'])->name('delete.rejected.borrower');
Route::post('/delete/all/rejected/borrower',[PageController::class, 'deleteAllRejectedBorrower'])->name('delete.all.rejected.borrower');
Route::post('/accept/borrower',[PageController::class, 'acceptBorrower'])->name('accept.borrower');


Route::get('/librarian/transaction', [PageController::class, 'librarianTransaction'])->name('librarian.transaction');
Route::post('/add/transaction', [PageController::class, 'addTransaction'])->name('add.transaction');
Route::post('/delete/transaction', [PageController::class, 'deleteTransaction'])->name('delete.transaction');
Route::post('/edit/transaction', [PageController::class, 'editTransaction'])->name('edit.transaction');

Route::get('/librarian/book', [PageController::class, 'librarianBook'])->name('librarian.book');
Route::post('/add/book', [PageController::class, 'addBook'])->name('add.book');
Route::post('/delete/book', [PageController::class, 'deleteBook'])->name('delete.book');
Route::post('/edit/book', [PageController::class, 'editBook'])->name('edit.book');

Route::get('/librarian/catalog', [PageController::class, 'librarianCatalog'])->name('librarian.catalog');
Route::post('/add/catalog', [PageController::class, 'addCatalog'])->name('add.catalog');
Route::post('/delete/catalog', [PageController::class, 'deleteCatalog'])->name('delete.catalog');
Route::post('/edit/catalog', [PageController::class, 'editCatalog'])->name('edit.catalog');