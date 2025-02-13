<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoteController;

Route::get('/', function () {
    return view('vote');
});

Route::post('/vote', [VoteController::class, 'store']);
Route::get('/get-votes', [VoteController::class, 'getVotes']);