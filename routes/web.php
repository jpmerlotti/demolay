<?php

use Illuminate\Support\Facades\Route;

Route::get('/contact', fn() => view('welcome'))->name('contact');
