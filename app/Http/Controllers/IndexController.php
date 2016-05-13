<?php namespace App\Http\Controllers;

use App\Entities\Sys\SysMenus;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Session;
use App\Entities\StockSir\Admin;
use App\Entities\Sys\SysUserRole;
class IndexController extends Controller {


    public function index(SysUserRole $SysUserRole)
    {

        //Session::put('key','values');
        try{

            $SysMenus	=	new SysMenus();
            $user	=	Auth::user();

            if(!$user){
                throw new \Exception('没有找到用户，请登录');
            }

            if(is_null($user->roles))
            {
                throw new \Exception('非法用户，请按照要求注册');
            }

            $MenusList = $SysMenus	->getRoleMenus($user->roles->pluck('id'));

            $MenusList = $this		->node_merge($MenusList);
        }
        catch(\Exception $ex)
        {
            if($ex->getCode()==0){
                return redirect()->guest('/login');
            }
            return redirect()->guest('/login')->withErrors($ex->getMessage());
        }

        return view('layouts.admin',['list'=>$MenusList]);
    }
    //递归通过pid 将其压入到一个多维数组!
    /*
     * $node 存放所有节点的节点数组
     * $access 判断有误权限
     * $pid 父id
     * return 多维数组;
     * */
    protected  function node_merge($node,$pid=0){
        $arr = array();
        foreach($node as $v){
            if(empty($v))
            {
                continue;
            }
            if($v['pid'] == $pid){
                $v["child"] = $this->node_merge($node,$v["id"]);
                $arr[] = $v;
            }
        }
        return  $arr ;
    }
}