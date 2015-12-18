<?php

namespace Imojie\Http\Controllers\Auth;

use Imojie\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $subject = '重置密码';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function getEmail()
    {
        return view('auth.forgot');
    }


    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $user = Sentinel::findByCredentials(['email' => $request->only('email')]);
        if ($user && !Activation::completed($user)) {
            return redirect()->back()->withErrors(['email' => '该邮箱注册的账号并没有激活，请重新注册']);
        }

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }


    protected function resetPassword($user, $password)
    {
        $user = Sentinel::findById($user->id);
        $user = Sentinel::update($user, ['password' => $password]);
        Sentinel::login($user);
    }
}
