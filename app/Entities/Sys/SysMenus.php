<?php
/**
 * Created by PhpStorm.
 * User: tangjun <tangjun@misrobot.com>
 * Date: 2015年12月15日
 * Time: 11:18:06
 */

namespace App\Entities\Sys;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Sys\SysPermissions;
use App\Entities\Sys\SysPermissionMenu;
use DB;
class SysMenus extends Model
{
    protected $connection	=	'sys';
    protected $table 		= 	'sys_menus';

    protected $fillable 	=	['moduleid', 'name', 'url','pid','ico','order','descrition'];

    public function getMenusList(){
        return  $thisBuilder = $this->with('SysPermissionMenu')->get();
    }

    public function SysPermissionMenu(){
        return  $this->hasOne('App\Entities\Sys\SysPermissionMenu','menu_id','id');
    }

    /**
     * 添加菜单权限信息
     * @access public
     *
     * @author tangjun <tangjun@misrobot.com>
     * @date 2015年12月17日13:59:39
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */

    public function AddMenus($data){
        if(!empty($data) && is_array($data)){
            foreach($data as $val){
                DB::connection('sys')->beginTransaction();
                $MenusObj = $this->create($val);
                //添加成功之後 返回的菜單id
                if(!empty($MenusObj->id)){
                    $PermissionsObj = SysPermissions::create([
                        'moduleid'=>$val['moduleid'],
                        'type'=>'MENU',
                        'itemid'=>'0',
                        'name'=>$val['name'],
                        'description'=>$val['descrition']
                    ]);
                    //添加成功之後 返回的權限id
                    if(!empty($PermissionsObj->id)){
                        $PermissionMenuObj = SysPermissionMenu::create([
                            'permission_id'=>$PermissionsObj->id,
                            'menu_id'=>$MenusObj->id,
                        ]);

                        //添加成功之後 返回的菜單表和權限表 關聯的id
                        if(!empty($PermissionMenuObj->id)){
                            if(SysPermissions::where('id','=',$PermissionsObj->id)->update(['itemid'=>$PermissionMenuObj->id])){
                                DB::connection('sys')->commit();
                            }else{
                                DB::connection('sys')->rollBack();
                            }
                        }else{
                            DB::connection('sys')->rollBack();
                        }
                    }else{
                        DB::connection('sys')->rollBack();
                    }
                }else{
                    DB::connection('sys')->rollBack();
                }
            }

        }

    }

    /**
     *
     * @access public
     * @param $roleIdArr
     * @param $urlNotNull
     * @return \Illuminate\Support\Collection
     * @author tangjun <469307838@qq.com>
     * @date    2016年5月13日 09:30:18
     * @copyright
     */
    public function getRoleMenus($roleIdArr,$urlNotNull=false){
        $thisBuilder   =   SysPermissionMenu::leftJoin('sys_role_permission','sys_permission_menu.permission_id','=','sys_role_permission.permission_id')
            ->  leftJoin('sys_menus','sys_permission_menu.menu_id','=','sys_menus.id');

        if($urlNotNull){
            $thisBuilder ->  where('url','<>','');
        }

        $list = $thisBuilder ->  whereIn('sys_role_permission.role_id',$roleIdArr)
            ->  groupBy('sys_permission_menu.menu_id')
            ->  orderBy('sys_menus.order','DESC')
            ->  get();
        $menus  =   [];

        foreach($list as $item)
        {
            $menu       =   $item-> menus;
            $menus[]    =   $menu;
        }
        return collect($menus);
    }

}