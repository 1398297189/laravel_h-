<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Entities\Sys\SysMenus;
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {



        //$permits = $this->getPermission($request);
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        
        //判断当前用户是否拥有当前路由的权限
        if(!self::ValidationMenus($request)){
            return response('没有当前菜单的权限.', 401);
        }

        return $next($request);
    }

    /**
     * @access public
     * @param $request
     * @return bool
     * @author tangjun <469307838@qq.com>
     * @date    2016年5月13日 09:22:00
     * @copyright
     */
    public function ValidationMenus($request){

        $SysMenus = new SysMenus();
        $Menus = $SysMenus->where('url','<>','')->select('id','url')->get();
        //判断有没有需要验证的 菜单权限
        if(count($Menus)>0){

            //当前访问的菜单id
            $MenuId = 0;
            $url = $Menus->pluck('url')->toArray();

            //获取路由信息
            $actions = $request->route()->getAction();

            //判断 路由是否需 权限验证
            if(!empty($actions['as']) && in_array($actions['as'],$url)){
                foreach($Menus as $v){
                    if($v['url'] == $actions['as']){
                        $MenuId = $v['id'];
                        break;
                    }
                }
                $user	=	Auth::user();

                //获取当前用户的权限
                $MenusList = $SysMenus	->getRoleMenus($user->roles->pluck('id'),true);
                if(count($MenusList)>0){

                    //判断当前用户是否 拥有该 路由的权限
                    if(in_array($MenuId,$MenusList->pluck('id')->toArray())){
                        return  true;
                    }else{
                        return  false;
                    }
                }else{
                    return  false;
                }
                //$MenuId;
            }else{
                return  true;
            }
        }else{
            return true;
        }
    }
}
