<?php

use App\Http\Controllers\DisciplinesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', [PageController::class, 'home'])->name('home');

// About the department page
Route::get('/about', [StaffController::class, 'about'])->name('about');

// Info about staff
Route::get('/staff/{staff}/details', [StaffController::class, 'details'])->name('staff.details');

// Students: syllabuses (analog of syllabuses.ist.kpi.ua Index)
Route::get('/syllabuses', [DisciplinesController::class, 'syllabuses'])->name('syllabuses');

// Students: disciplines diagram (analog of syllabuses.ist.kpi.ua Diagram)
Route::get('/syllabuses/diagram', [DisciplinesController::class, 'diagram'])->name('syllabuses.diagram');

// Disciplines page (Skill Tree)
Route::get('/disciplines', [DisciplinesController::class, 'index'])->name('disciplines');

// Admission page
Route::get('/admission', [PageController::class, 'admission'])->name('admission');

// Educational programs page
Route::get('/programs', [PageController::class, 'programs'])->name('programs');

// News list page
Route::get('/news', [NewsController::class, 'index'])->name('news');

// Single news article page
Route::get('/news/{article:slug}', [NewsController::class, 'show'])->name('news.article');

// Partners page
Route::get('/partners', [PageController::class, 'partners'])->name('partners');
