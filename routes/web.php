<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/catalog', function () {
    return view('catalog'); // создайте при необходимости
})->name('catalog');

Route::get('/about', function () {
    return view('about'); // создайте при необходимости
})->name('about');

Route::get('/faq', function () {
    return view('faq'); // создайте при необходимости
})->name('faq');

Route::get('/contacts', function () {
    return view('landing#contacts'); // или отдельная страница
})->name('contacts');

Route::get('/search', function () {
    return view('search-results'); // страница результатов
})->name('search');

