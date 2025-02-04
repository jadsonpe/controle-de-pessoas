<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('day.index');
});

Route::get('/portifolio', function () {
    return view('day.portifolio-detail');
});