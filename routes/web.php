<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/fairs', [PageController::class, 'fairs'])->name('fairs');
Route::get('/fairs/{slug}', [PageController::class, 'fairShow'])->name('fairs.show');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactSend'])->name('contact.send');
Route::get('/search', [PageController::class, 'search'])->name('search');
Route::get('/representations', [PageController::class, 'representations'])->name('representations');
Route::get('/supports', [PageController::class, 'supports'])->name('supports');
Route::get('/news', [PageController::class, 'news'])->name('news');
Route::get('/news/{slug}', [PageController::class, 'newsShow'])->name('news.show');
Route::get('/kvkk', [PageController::class, 'kvkk'])->name('kvkk');

Route::get('/lang/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');

// Admin Auth
use App\Http\Controllers\Admin\LoginController;

Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FairController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\RepresentationController;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('fairs/featured', [FairController::class, 'featured'])->name('fairs.featured');
    Route::post('fairs/{fair}/unfeature', [FairController::class, 'unfeature'])->name('fairs.unfeature');
    Route::resource('fairs', FairController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('representations', RepresentationController::class);
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::get('inbox', [InboxController::class, 'index'])->name('inbox.index');
    Route::get('inbox/{message}', [InboxController::class, 'show'])->name('inbox.show');
    Route::delete('inbox/{message}', [InboxController::class, 'destroy'])->name('inbox.destroy');
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});



