<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/deliveries/{delivery}/download-pdf', \App\Http\Controllers\DownloadDeliveryInPdf::class)->name('deliveries.download-pdf');
});
