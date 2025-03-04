<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
                $googleUser = Socialite::driver("google")->user();

                $user = new User;
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->google_id = $googleUser->id;
                $user->google_access_token = $googleUser->token;
                $user->google_refresh_token = $googleUser->refreshToken;
                $user->google_expires_in = $googleUser->expiresIn;
                $user->google_avatar_url = $googleUser->avatar;

                $user->save();
                Auth::login($user);

                return redirect("/vote");
            }
        );
    }
);

Route::post("logout", App\Livewire\Actions\Logout::class)
    ->name("logout");
