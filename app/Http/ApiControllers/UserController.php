<?php

namespace Imojie\Http\ApiControllers;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Imojie\Models\User;
use Imojie\Models\Zodiac;
use Carbon\Carbon;

class UserController extends Controller
{


    public function __construct()
    {
//        \DB::connection()->enableQueryLog();
//
//        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index()
    {
        return User::all();
    }

    public function me()
    {
        $user = app('Dingo\Api\Auth\Auth')->user();
        return $user;
    }
}
