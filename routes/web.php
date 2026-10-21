<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::livewire('/post/create', 'pages::post.create');
Route::livewire('/view', 'pages::asset.view');
