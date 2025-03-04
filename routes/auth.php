<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::middleware("guest")->group(
    function () {
        Route::get(
            "login",
            function () {
                return Socialite::driver("google")->redirect();
            }
        );
        Route::get(
            "google/auth",
            function () {
                $user = Socialite::driver("google")->user();
                // dd($user->getName());
            }
        );
    }
);

Route::post("logout", App\Livewire\Actions\Logout::class)
    ->name("logout");
