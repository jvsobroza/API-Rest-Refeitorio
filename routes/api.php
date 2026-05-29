<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('refeicoes', [ApiController::class, 'getRefeicoes']);
Route::get('refeicoes/{data}', [ApiController::class, 'getRefeicoesByData']);
Route::post('refeicoes', [ApiController::class, 'postRefeicoes']);
Route::put('refeicoes/{id}', [ApiController::class, 'putRefeicoes']);
Route::delete('refeicoes/{id}', [ApiController::class, 'deleteRefeicoes']);
