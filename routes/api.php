<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordController;

Route::post('/generate', [WordController::class, 'generate']);
