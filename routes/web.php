<?php

use App\Livewire\Form;
use App\Livewire\SimpleThemeEditor;
use App\Livewire\ThemeEditor;
use App\Models\Blog\Post;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/editor', 'theme-editor');
