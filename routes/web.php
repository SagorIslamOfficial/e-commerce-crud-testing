<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Custom routes
    Route:: resource('category', CategoryController::class);
    Route:: resource('subcategory', SubcategoryController::class);
    Route:: resource('product', ProductController::class);

    // I used AI to generate this route, method and JS codes for create and edit methods in product controller views file
    Route::get('/get-subcategories/{category}', [SubcategoryController::class, 'getSubcategories']);
});

require __DIR__.'/auth.php';
