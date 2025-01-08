<?php

use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CharacterController::class, 'index'])->name('character.index');
Route::get('/api/characters', [CharacterController::class, 'getCharacters'])->name('character.data');
