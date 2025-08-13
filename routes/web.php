<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

Route::get('/', [PlayerController::class, 'index'])->name('home');

// Handles form submission and redirects accordingly (player or clan)
Route::post('/search', [PlayerController::class, 'search'])->name('search');
    
// Player profile
Route::get('/player/{tag}', [PlayerController::class, 'show'])->name('player.show');

// Clan search by name (with ?name=)
Route::get('/clan', [PlayerController::class, 'searchClans'])->name('clan.search');

// Clan info by tag
Route::get('/clan/{tag}', [PlayerController::class, 'showClan'])->name('clan.show');

//Ranking
Route::get('/rankings', [PlayerController::class, 'rankings'])->name('rankings');

// Privacy Policy
Route::view('/privacy', 'layouts.footerLinks.privacy')->name('privacy');

// Terms of Service
Route::view('/terms', 'layouts.footerLinks.terms-of-service')->name('terms');

// About Us
Route::view('/about', 'layouts.footerLinks.about')->name('about');