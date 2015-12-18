<?php

namespace Imojie\Models\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;


trait RegistersUsers
{
    use RedirectsUsers;


    public function getRegister()
    {
        return view('auth.register');
    }


    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }


        Sentinel::login($this->create($request->all()));

        return redirect($this->redirectPath());
    }
}
