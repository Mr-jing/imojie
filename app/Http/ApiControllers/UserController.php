<?php

namespace Imojie\Http\ApiControllers;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Imojie\Models\User;
use Imojie\Models\Zodiac;
use Carbon\Carbon;
use Imojie\Transformers\UserTransformer;
use Imojie\Http\Requests\LoginRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

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


    public function login(LoginRequest $request)
    {
        // 验证账号
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        $remember = $request->has('remember') ? true : false;
        $user = Sentinel::authenticate($credentials, $remember);
        if (!$user) {
            // 账号或密码错误
            abort(401);
        }

        // 返回 OAuth2 的 access_token
        return $this->getToken($credentials);
    }

    protected function getToken($credentials)
    {
        return $this->api->with([
            'grant_type' => 'password',
            'username' => $credentials['email'],
            'password' => $credentials['password'],
            'client_id' => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
        ])->post('oauth/access_token');
    }

    public function me()
    {
        $user = app('Dingo\Api\Auth\Auth')->user();
        return $this->response()->item($user, new UserTransformer());
    }
}
