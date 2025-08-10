<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailValidationController;

Route::get('/health', fn() => response()->json(['status' => 'ok']));

Route::post('/validate-email', EmailValidationController::class);

