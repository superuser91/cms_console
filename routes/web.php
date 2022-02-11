<?php

use Illuminate\Support\Facades\Route;
use Vgplay\CmsConsole\Console;

Route::middleware('web')->group(function () {
    Route::group([
        'prefix' => config('vgplay.console.prefix'),
        'middleware' => config('vgplay.console.middleware')
    ], function () {
        Route::name('console.')->group(function () {
            Route::get('/', [Console::class, 'show'])->name('show');
            Route::post('/', [Console::class, 'execute'])->name('execute');
        });
    });
});
