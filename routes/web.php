<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;

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

Route::get('/', [PageController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])
->prefix('admin')
->name('admin.')
->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::get('category-post', [CategoryController::class, 'categoryPost'])->name('category-post');
    Route::get('post-tag/{tag}', [TagController::class, 'postsTags'])->name('post-tag');
    Route::get('order-by/{direction}/{column}', [PostController::class, 'orderBy'])->name('orderBy');
    Route::get('search', [PostController::class, 'search'])->name('search');
    Route::get('no-tags', [PostController::class, 'noTags'])->name('noTags');
});

require __DIR__.'/auth.php';
