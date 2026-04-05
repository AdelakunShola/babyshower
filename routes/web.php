<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BabyShowerController;

Route::get('/', [BabyShowerController::class, 'index'])->name('baby-shower.index');
Route::post('/baby-shower', [BabyShowerController::class, 'store'])->name('baby-shower.store');
Route::get('/baby-shower/thanks', [BabyShowerController::class, 'thanks'])->name('baby-shower.thanks');

Route::get('/baby-shower/admin', [BabyShowerController::class, 'admin'])->name('baby-shower.admin');
Route::get('/baby-shower/video/{submission}', [BabyShowerController::class, 'streamVideo'])->name('baby-shower.video');