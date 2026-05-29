<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DigitalCardController\ListUndangan\WhatsappController as WhatsappController;
use App\Http\Controllers\DigitalCardController\ListUndangan\ListUndanganController as UndanganController;

Route::get('/test-wablas', [WhatsappController::class, 'kirimPesan']);
Route::post('/test-bulk-send', [UndanganController::class, 'bulkSend'])->name('tamu.bulk-send');
