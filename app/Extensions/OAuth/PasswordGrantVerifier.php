<?php
namespace App\Extensions\OAuth;

use Illuminate\Support\Facades\Auth;
use App\Entities\Sys\User;
use App\Entities\Sys\SysRolePermission;
use App\Entities\Sys\SysMenus;
use App\Entities\Sys\SysUserRole;
use Illuminate\Support\Facades\Session;
use Menu;
use App\Extensions\ZurbTopBarPresenter;
class PasswordGrantVerifier
{
    public function verify($username, $password)
    {
        if(strlen($username)<3 || strlen($password)<6)
        {
            return false;
        }

        if (Auth::attempt(['username' => $username, 'password' =>$password])    ||
            Auth::attempt(['code' => $username, 'password' =>$password])        ||
            Auth::attempt(['mobile' => $username, 'password' =>$password])      ||
            Auth::attempt(['email' => $username, 'password' =>$password])
        )
        {
            return Auth::id();
        }

        else {
            return false;
        }
    }

    /**
     * @access public
     * @author tangjun <tangjun@misrobot.com>
     * @date    2016年1月21日17:35:20
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function verifyRole(){
        $user = Auth::user();
        $SysUserRole = new SysUserRole;
        $SysUserRoleInfo = $SysUserRole->where('user_id','=',$user->id)->with('SysRoles')->first();
        if(!empty($SysUserRoleInfo->SysRoles)){
            \Illuminate\Support\Facades\Session::put('roleName',$SysUserRoleInfo->SysRoles->name);
            return $SysUserRoleInfo->SysRoles->name;
        }
        return false;

    }

    /**
     * @access public
     * @return array
     * @author tangjun <tangjun@misrobot.com>
     * @date    2016年1月21日17:39:02
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function getRoleMenus(){
        $user = Auth::user();
        $SysUserRole = new SysUserRole;
        $SysUserRoleInfo = $SysUserRole->where('user_id','=',$user->id)->first();
        $data = [];
        if(!empty($SysUserRoleInfo->role_id)){
            $data['roleId'] = $SysUserRoleInfo->role_id;
        }
        $SysRolePermission = new SysRolePermission;
        $SysMenus = new SysMenus;
        $PermissionList = $SysRolePermission->getPermissionList($data);
        $MenusList = $SysMenus->getMenusList();
        //$FunctionsList = $SysFunctions->getFunctionsList();

        $MenusListNew = $this->node_merge($MenusList);
        //$FunctionsList = $this->node_merge($FunctionsList);

        $PermissionIdArr = [];
        if(!empty($PermissionList)){
            foreach($PermissionList as $v){
                $PermissionIdArr[] = $v['permission_id'];
            }
        }
        $MenusPermissions = [];
        //$MenusPermissions ['MscMenusAll']= $SysMenus->getMenusListNotSupremo()->toArray();
        $Menus = [];
        foreach($MenusListNew as $k => $v){
            if(in_array($v['SysPermissionMenu']['permission_id'],$PermissionIdArr)){
                $child = [];
                if(!empty($v['child'])){
                    foreach($v['child'] as $key => $val){
                        if(in_array($val['SysPermissionMenu']['permission_id'],$PermissionIdArr)){
                            $child [] = $val;
                            $data ['id'] = $val['id'];
                            $data ['name'] = $val['name'];
                            $data ['url'] = $val['url'];
                            $MenusPermissions ['MscMenusPermissions'][] = $data;
                        }
                    }
                }
                $v ['child'] = $child;
                $Menus [] = $v;
            }
        }
        //TODO 根据权限构建菜单
        Menu::create('navbar', function($menu) use ($Menus){
            foreach($Menus as $v){
                $menu->dropdown($v['name'], function ($sub) use ($v) {
                    foreach($v['child'] as $val){
                        $sub->url($val['url'], $val['name']);
                    }
                },$v['ico']);
            }
            $menu->setPresenter(new ZurbTopBarPresenter);
        });
        //TODO 菜单权限存入菜单
        Session::put('MenusPermissions',$MenusPermissions);
        //return  $MenusList;
    }

    //递归通过pid 将其压入到一个多维数组!
    /*
     * $node 存放所有节点的节点数组
     * $access 判断有误权限
     * $pid 父id
     * return 多维数组;
     * */
    public  function node_merge($node,$pid=0){
        $arr = array();
        foreach($node as $v){
            if($v['pid'] == $pid){
                $v["child"] = $this->node_merge($node,$v["id"]);
                $arr[] = $v;
            }
        }
        return  $arr ;
    }

    /**
     * @access public
     * @param $url
     * @author tangjun <tangjun@misrobot.com>
     * @date    2016年2月1日15:43:23
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function validationMenusPermissions($url){
        $MenusPermissions = Session::get('MenusPermissions','');
        $urlArr = explode('?',$url);
        $url = $urlArr[0];
        $tag = false;
/*        //TODO 判断当前访问的URL 是否属于菜单
        foreach($MenusPermissions['MscMenusAll'] as $v){
            if($url == $v['url']){
                $tag = true;
                break;
            }
        }*/
        //TODO 判断当前用户是否有访问该菜单的权限
        if($tag){
            foreach($MenusPermissions['MscMenusPermissions'] as $v){
                if($url == $v['url']){
                    return  true;
                    break;
                }
            }
            return  false;
        }else{
            return  true;
        }
    }

}