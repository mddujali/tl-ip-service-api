<?php

declare(strict_types=1);

use App\Http\Controllers\Api\IpAddressController;
use Illuminate\Support\Facades\Route;

Route::apiResource('ip-addresses', IpAddressController::class)
    ->parameters(['ip-addresses' => 'ip_address_id'])
    ->middleware('jwt.verify');
