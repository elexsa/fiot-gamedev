<?php

use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// About the department page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Disciplines page (Skill Tree)
Route::get('/disciplines', function () {
    return view('disciplines');
})->name('disciplines');

// Admission page
Route::get('/admission', function () {
    return view('admission');
})->name('admission');

// News list page
Route::get('/news', function () {
    return view('news', ['news' => config('content.news')]);
})->name('news');

// Single news article page
Route::get('/news/{slug}', function (string $slug) {
    $article = collect(config('content.news'))->firstWhere('slug', $slug);

    abort_if($article === null, 404);

    return view('news-article', ['article' => $article]);
})->name('news.article');

// Partners page
Route::get('/partners', function () {
    return view('partners');
})->name('partners');

// Contacts page
Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');