<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('filament.demolay.auth.login'));
});


Route::prefix('/v1')->get('/love', function () {
    $start = Carbon::create(year: 2023, month: 12, day: 6);
    $time = round(now()->diffInMonths($start) / 11 * -1, 1);

    return response([
        'success' => true,
        'message' => "Eu te amo, Danielle",
        'data' => [
            "inicio" => $start->format('d/M/Y'),
            "total" => $time . ' anos',
            "url" => 'joaopedromerlotti.com.br/amor'
        ]
    ], 200);
});
