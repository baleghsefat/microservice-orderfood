<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // TODO refactor
        Auth::viaRequest('jwt', function (Request $request) {
            $token = $request->header('authorization');
            if (isset($token)) {
                if (isTokenValid($token)) {
                    $tokenData = optional(tokenData($token));
                    $user = new User();
                    $user->first_name = $tokenData['first_name'];
                    $user->last_name = $tokenData['last_name'];
                    $user->role = $tokenData['role'];

                    return $user;
                }
            }
        });
    }
}
