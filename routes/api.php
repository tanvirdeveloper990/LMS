<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCommerzPaymentController;


Route::middleware('api')->get('/check', function (Request $request) {
    return response()->json(['message' => 'API route working!']);
});

Route::post('/success', [SslCommerzPaymentController::class, 'success'])->name('success');
