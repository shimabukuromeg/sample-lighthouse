<?php

namespace App\GraphQL\Mutations;

use App\Traits\AuthHelpers;
use Wimil\LighthouseGraphqlJwtAuth\Events\UserLoggedIn;
use Wimil\LighthouseGraphqlJwtAuth\Exceptions\AuthenticationException;

class Login
{
    use AuthHelpers;

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard()
    {
        return auth()->guard('admin_user');
    }

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function resolve($_, array $args)
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password']
        ];

        if (!$token = $this->guard()->attempt($credentials)) {
            throw new AuthenticationException("Unauthorized", "Incorrect email or password.");
        }

        event(new UserLoggedIn(auth('admin_user')->user()));

        return $this->respondWithToken($token);
    }
}
