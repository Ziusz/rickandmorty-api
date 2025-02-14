<?php

use App\Http\Controllers\Api\V1\CharacterFrontAPIController;
use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CharacterController::class, 'index'])->name('character.index');

Route::prefix('api/v1')->name('api.v1.')->group(function () {
    Route::get('/characters', [CharacterFrontAPIController::class, 'index'])->name('characters');
});
