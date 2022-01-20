<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use Tabuna\Breadcrumbs\Trail;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/',                     [HomeController::class, 'index'])->name('index');
Route::get('/pembayaran',           [HomeController::class, 'pembayaran'])->name('pembayaran');
Route::get('/upload-bukti-tf',      [HomeController::class, 'uploadbuktitf'])->name('uploadbuktitf');
Route::get('/selesai-daftar',       [HomeController::class, 'selesai'])->name('selesai');


Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });
