<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApiController::class, 'index']);
Route::get('/search', [ApiController::class, 'searchText']);
Route::post('/search', [ApiController::class, 'searchPdf']);
