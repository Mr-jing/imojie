<?php

namespace Imojie\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Laravel\Socialite\Facades\Socialite;
use Imojie\Http\Controllers\Controller;
use Imojie\Http\Requests\LoginRequest;
use Imojie\Http\Requests\BindAccountRequest;
use Imojie\Http\Requests\RegisterRequest;
use Imojie\Models\Auth\ThrottlesLogins;
use Imojie\Models\Auth\AuthenticatesAndRegistersUsers;
use Imojie\Models\User;
use Imojie\Models\OAuthAccount;


class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/home';

    const OAUTH_USER = 'oauth_user';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'postLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return Sentinel::register([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ], true);
    }


    public function getRegister()
    {
        return view('auth.register');
    }


    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $user = Sentinel::findByCredentials(['email' => $email]);
        if (!$user) {
            // 注册用户，但是先不激活
            $credentials = [
                'email' => $email,
                'password' => md5(time()),
            ];
            $user = Sentinel::register($credentials, false);
        }

        if (Activation::completed($user)) {
            return redirect('auth/register')->withErrors(array('该邮箱已经被注册激活'));
        }

        // 生成激活码
        $activation = Activation::create($user);

        // 发邮件
        $vars = [
            'email' => $email,
            'code' => $activation->code,
        ];
        Mail::queue('emails.register', $vars, function ($message) use ($email) {
            $message->to($email, $email)->subject('感谢您的注册');
        });

        return redirect('auth/registered');
    }


    public function getRegistered()
    {
        return view('auth.registered');
    }


    public function getActivation(Request $request)
    {
        if (!$request->has('email') || !$request->has('code')) {
            abort(404);
        }
        $vars = [
            'email' => $request->input('email'),
            'code' => $request->input('code'),
        ];
        if (Session::has(self::OAUTH_USER)) {
            $vars['oauthUser'] = Session::get(self::OAUTH_USER);
        }
        return view('auth.activation', $vars);
    }


    public function postActivation(RegisterRequest $request)
    {
        $email = $request->input('email');
        $user = Sentinel::findByCredentials(['email' => $email]);

        // 设置用户名和密码
        Sentinel::update($user, array(
            'first_name' => $request->input('username'),
            'password' => $request->input('password'),
        ));

        // 激活用户账号
        $status = Activation::complete($user, $request->input('code'));
        if (!$status) {
            return redirect('auth/register')->withErrors(array('邮件链接过期，请重新注册'));
        }

        if (Session::has(self::OAUTH_USER)) {
            $oauthInfo = Session::get(self::OAUTH_USER);
            $provider = $oauthInfo['provider'];
            $oauthUser = $oauthInfo['user'];

            $uid = OAuthAccount::where('oauth_id', $oauthUser->getId())
                ->where('oauth_type', $provider)->pluck('uid');

            if (!$uid) {
                // 绑定账号
                $oAuthAccount = new OAuthAccount();
                $oAuthAccount->uid = $user->id;
                $oAuthAccount->oauth_id = $oauthUser->getId();
                $oAuthAccount->oauth_type = $provider;
                $oAuthAccount->created_at = time();
                $oAuthAccount->save();
            }
        }

        // 登录
        Sentinel::login($user);

        return redirect($this->redirectPath());
    }


    public function getLogin()
    {
        return view('auth.login');
    }


    public function postLogin(LoginRequest $request)
    {
        // 验证账号
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        $remember = $request->has('remember') ? true : false;
        $user = Sentinel::authenticate($credentials, $remember);
        if (!$user) {
            return redirect()->back()->withInput($request->except(array('password')))
                ->withErrors(array('账号或密码错误'));
        }
        return redirect($this->redirectPath());
    }


    public function postLogout()
    {
        Sentinel::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }


    public function oauth($provider)
    {
        $provider = strtolower($provider);
        switch ($provider) {
            case 'qq':
                return Socialite::with('qq')->redirect();
                break;
            case 'weibo':
                return Socialite::with('weibo')->scopes(array('all'))->redirect();
                break;
            default:
                return redirect('auth/login');
        }
    }


    public function callback($provider)
    {
        $provider = strtolower($provider);

        $oauthUser = Socialite::with($provider)->user();

        $uid = OAuthAccount::where('oauth_id', $oauthUser->getId())
            ->where('oauth_type', $provider)->pluck('uid');

        if ($uid && $user = Sentinel::findById($uid)) {
            Sentinel::login($user);
            return redirect($this->redirectPath());
        }

        // 如果当前第三方账号没有绑定我站账号，那么跳转到绑定账号的页面
        Session::put(self::OAUTH_USER, array(
            'provider' => $provider,
            'user' => $oauthUser,
        ));
        return redirect()->action('Auth\AuthController@getBind');
    }


    public function getBind()
    {
        if (!Session::has(self::OAUTH_USER)) {
            return redirect($this->loginPath());
        }
        $oauthInfo = Session::get(self::OAUTH_USER);
        $provider = $oauthInfo['provider'];
        $oauthUser = $oauthInfo['user'];

        // 已经绑定了账号，直接登录
        $uid = OAuthAccount::where('oauth_id', $oauthUser->getId())
            ->where('oauth_type', $provider)->pluck('uid');
        if ($uid && $user = Sentinel::findById($uid)) {
            Sentinel::login($user);
            return redirect($this->redirectPath());
        }

        return view('auth.bind');
    }


    public function postBind(BindAccountRequest $request)
    {
        if (!Session::has(self::OAUTH_USER)) {
            return redirect($this->loginPath());
        }
        $oauthInfo = Session::get(self::OAUTH_USER);
        $provider = $oauthInfo['provider'];
        $oauthUser = $oauthInfo['user'];

        // 已经绑定了账号，直接登录
        $uid = OAuthAccount::where('oauth_id', $oauthUser->getId())
            ->where('oauth_type', $provider)->pluck('uid');
        if ($uid && $user = Sentinel::findById($uid)) {
            Sentinel::login($user);
            return redirect($this->redirectPath());
        }

        // 验证账号
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        $user = Sentinel::authenticate($credentials, false);
        if (!$user) {
            return redirect()->back()->withInput($request->except(array('password')))
                ->withErrors(array('账号或密码错误'));
        }

        // 绑定账号
        $oAuthAccount = new OAuthAccount();
        $oAuthAccount->uid = $user->id;
        $oAuthAccount->oauth_id = $oauthUser->getId();
        $oAuthAccount->oauth_type = $provider;
        $oAuthAccount->created_at = time();
        $oAuthAccount->save();

        Session::forget(self::OAUTH_USER);

        return redirect($this->redirectPath());
    }

}
