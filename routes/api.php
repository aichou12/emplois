<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ResetPasswordController;

Route::post('/chatbot/reset-password', [ResetPasswordController::class, 'handleReset']);
