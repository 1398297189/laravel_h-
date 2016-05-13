<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Input;
use App\Entities\User;
class WeChatAuthenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    protected $user;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取用户信息
        $this->getUserInfo();
        
        $openid = Session::get('openid','');
        $user = User::where('openid','=',$openid)->first();
        if (($this->auth->guest() && empty($this->user->id))|| empty($user->id)) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                //dd( Auth::user());
                return redirect()->guest('/msc/wechat/user/user-login');
            }
        }
        //判断用户是否被禁用
        if($this->user->status != '正常' ){
            return redirect()->guest('/msc/wechat/user/user-login');
        }
        return $next($request);
    }

    //获取OpenID
    public function getOpenId(){
        $auth = new \Overtrue\Wechat\Auth(config('wechat.app_id'), config('wechat.secret'));
        $userInfo = $auth->authorize($to = null, $scope = 'snsapi_userinfo', $state = 'STATE');
        if(!empty($userInfo)){
            return $userInfo->openid;
        }else{
            return false;
        }
    }

    //获取用户信息
    public function getUserInfo(){
        $UserM = new User;
        $user = Auth::user();
        $Suser = Session::get('user','');
        if(Input::get('state') == '123' && empty($Suser->id) && empty($user->id)){
            $openid = $this->getOpenId();
            $user = $UserM->where('openid','=',$openid)->first();
            $UserM->getStatusAttribute($user['status']);
            if(!empty($user->id)){
                $user['status'] = $UserM->getStatusAttribute($user['status']);
                $this->user = $user;
                Session::put('user',$user);
                Session::put('openid',$openid);
            }
        }
        $this->user = !empty($user->id)?$user:Session::get('user','');
    }
}
