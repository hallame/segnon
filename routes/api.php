<?php

use App\Http\Controllers\Api\BotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/bot/search', [BotController::class, 'search'])->name('api.bot.search');
