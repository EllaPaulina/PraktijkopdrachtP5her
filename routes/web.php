<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
//use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
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

Route::get('/',[ArticleController::class,'index'])->name('articles.index');

Route::get('/articles', [ArticleController::class, 'index'])->middleware(['auth'])->name('articles.index');
Route::resource('articles', ArticleController::class)->middleware(['auth']);
Route::resource('categories', CategoryController::class)->middleware(['auth']);
Route::get('/search', [ArticleController::class, 'search'])->name('articles.search');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::post('/articles/{article}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

// Routes for admin
Route::get('/admin/articles', [ArticleController::class, 'adminIndex'])->name('articles.admin_index');
Route::post('/articles/{id}/toggle-visibility', [ArticleController::class, 'toggleVisibility'])->name('articles.toggleVisibility');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');






// Hieronder staat alles van Blaze
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('articles');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
