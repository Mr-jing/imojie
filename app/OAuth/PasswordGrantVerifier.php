<?php

namespace Imojie\OAuth;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;


class PasswordGrantVerifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email' => $username,
            'password' => $password,
        ];

        if ($user = Sentinel::authenticate($credentials)) {
            return $user->id;
        }

        return false;
    }
}