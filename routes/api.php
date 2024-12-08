<?php

use App\Http\Controllers\BypassController;
use Illuminate\Support\Facades\Route;

Route::addRoute(['GET', 'POST'],'/bypass', [BypassController::class,'bypass']);
