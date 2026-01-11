<?php

use App\Livewire\About;
use App\Livewire\Blog\Index;
use App\Livewire\Blog\Show;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('blog.index');
Route::get('/blog/{slug}', Show::class)->name('blog.show');
Route::get('/about', About::class)->name('about');
