<?php

use App\Livewire\Properties;
use App\Livewire\Chatbot;
use App\Livewire\ChatbotDemo;
use App\Livewire\ChatbotSettings;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Models\Property;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Embeddable chatbot route
Route::get('chatbot/embed/{chatbotId?}', function ($chatbotId = 1) {
    return view('chatbot-embed', ['chatbotId' => $chatbotId]);
})->name('chatbot.embed');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::get('properties', Properties::class)
        ->name('properties');

    Route::get('chatbot', Chatbot::class)
        ->name('chatbot');

    Route::get('chatbot/settings', ChatbotSettings::class)
        ->name('chatbot.settings');
});



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
