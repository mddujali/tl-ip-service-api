<?php

use App\Http\Controllers\Api\IpAddressController;
use Illuminate\Support\Facades\Route;

Route::apiResource('ip-addresses', IpAddressController::class)
    ->except(['destroy'])
    ->parameters(['ip-addresses' => 'ip_address_id'])
    ->middleware('jwt.verify');
