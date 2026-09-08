<?php

use App\Http\Controllers\DisciplinesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', [PageController::class, 'home'])->name('home');

// About the department page
Route::get('/about', [PageController::class, 'about'])->name('about');

// Disciplines page (Skill Tree)
Route::get('/disciplines', [DisciplinesController::class, 'index'])->name('disciplines');

// Admission page
Route::get('/admission', function () {
    return view('admission');
})->name('admission');

// News list page
Route::get('/news', [NewsController::class, 'index'])->name('news');

// Single news article page
Route::get('/news/{article:slug}', [NewsController::class, 'show'])->name('news.article');

// Partners page
Route::get('/partners', [PageController::class, 'partners'])->name('partners');

// Contacts page
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');
