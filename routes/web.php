<?php

use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Disciplines page (Skill Tree)
Route::get('/disciplines', function () {
    return view('disciplines');
})->name('disciplines');

// Admission page
Route::get('/admission', function () {
    return view('admission');
})->name('admission');

// Partners page
Route::get('/partners', function () {
    return view('partners');
})->name('partners');