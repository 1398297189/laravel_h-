<?php
/**
 * Created by PhpStorm.
 * User: fengyell <Luohaihua@misrobot.com>
 * Date: 2015/11/19
 * Time: 16:02
 */

namespace App\Http\Controllers;
use App\Entities\Sys\SysRoles;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Entities\Sys\SysRolePermission;
use App\Entities\Sys\SysPermissionMenu;
use App\Entities\Sys\SysPermissionFunction;
use App\Entities\Sys\SysPermissions;
use App\Entities\Sys\SysMenus;
use App\Entities\Sys\SysFunctions;
use DB;
use App\Extensions\OAuth\PasswordGrantVerifier;
class AuthController extends BaseController
{   

    public function __construct(SysRoles $SysRoles){
        $this->SysRoles=$SysRoles;
    }
    /**
     * 权限管理页面
     * @method GET /auth/auth-manage
     * @access public
     *
     * @param Request $request get请求<br><br>
     * <b>get请求字段：</b>
     * @return view
     *
     * @version 0.8
     * @author whg <whg@misrobot.com>
     * @date 2015年12月15日17:39:08
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function AuthManage(){
        $roleList = $this->SysRoles->getRolesList();
        return view('usermanage.rolemanage',['roleList'=>$roleList]);
    }

    /**
     * 新建角色页面
     * @method GET /auth/role-manage
     * @access public
     *
     * @param Request $request get请求<br><br>
     * <b>get请求字段：</b>
     * @return view
     *
     * @version 0.8
     * @author whg <weihuiguo@misrobot.com>
     * @date 2015年12月15日11:36:27
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function newRolePage(){
        return view('role.role');
    }

    /**
     * 新建角色数据处理
     * @method GET /auth/role-manage
     * @access public
     *
     * @param Request $request get请求<br><br>
     * <b>get请求字段：</b>
     * @return view
     *
     * @version 0.8
     * @author whg <weihuiguo@misrobot.com>
     * @date 2015年12月15日11:39:12
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function postAddNewRole(Request $Request,SysRoles $SysRoles){
        $this->validate($Request,[
            'name' => 'required|min:2|max:10',
            ]);
        $data = [
            'name' => Input::get('name'),
            'slug' => rand(1,999999),
            'description'=>Input::get('description')
        ];
        $addNewRole = DB::connection('sys')->table('sys_roles')->insert($data);

        if($addNewRole){

            return redirect()->route('auth.AuthManage');
        }else{
            return  redirect()->back()->withErrors(['系统繁忙']);
        }
    }




    /**
     * 权限设置页面
     * @method GET /auth/set-permissions
     * @access public
     *
     * @param Request $request get请求<br><br>
     * <b>get请求字段：</b>
     * @return view
     *
     * @version 0.8
     * @author tangjun <tangjun@misrobot.com>
     * @date 2015年12月15日13:59:39
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */

    public function SetPermissions($id,SysRolePermission $SysRolePermission,SysMenus $SysMenus,SysFunctions $SysFunctions){

        $data = [];
        $roleName = '';
        if(!empty($id)){
            $data['roleId'] = $id;
            $SysRolesInfo = SysRoles::where('id','=',$id)->first();
            if(!empty($SysRolesInfo->id)){
                $roleName = $SysRolesInfo->name;
            }

        }

        $PermissionList = $SysRolePermission->getPermissionList($data);
        $MenusList = $SysMenus->getMenusList();
        //$FunctionsList = $SysFunctions->getFunctionsList();

        $MenusList = $this->node_merge($MenusList);
        //$FunctionsList = $this->node_merge($FunctionsList);

        $PermissionIdArr = [];
        if(!empty($PermissionList)){
            foreach($PermissionList as $v){
                $PermissionIdArr[] = $v['permission_id'];
            }
        }
        $data = [
            'PermissionIdArr'=>$PermissionIdArr,
            'MenusList'=>$MenusList,
            //'FunctionsList'=>$FunctionsList,
            'role_id'=>$id,
            'roleName'=>$roleName
        ];
        return  view('usermanage.rolemanage_detail',$data);
    }

    /**
     * 权限设置页面
     * @method GET /auth/save-permissions
     * @access public
     *
     * @param Request $request get请求<br><br>
     * <b>get请求字段：</b>
     * @return view
     *
     * @version 0.8
     * @author tangjun <tangjun@misrobot.com>
     * @date 2015年12月15日13:59:39
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */

    public function SavePermissions(Request $Request,SysRolePermission $SysRolePermission){

        $this->validate($Request,[
            'role_id'       => 'required|integer',
        ]);


        $role_id = $Request->get('role_id');
        $permissionIdArr = $Request->get('permission_id');
        $status = $SysRolePermission->where('role_id','=',$role_id)->get();

        DB::connection('sys')->beginTransaction();
        $rew = false;
        if(empty($status->toArray())){
            $rew = true;
        }else{
            $rew = $SysRolePermission->DelRolePermission($role_id);
        }
        if($rew){
            $R = $SysRolePermission->AddRolePermission($permissionIdArr,$role_id);
            if($R){
                DB::connection('sys')->commit();
                //$GrantVerifier = new PasswordGrantVerifier;
                //$GrantVerifier->getRoleMenus();
                return redirect()->intended('/auth/auth-manage');
            }else{
                DB::connection('sys')->rollBack();
                dd('权限编辑失败');
            }
        }else{
            DB::connection('sys')->rollBack();
            dd('权限编辑失败');
        }



    }
    /**
     * 删除角色
     * @method GET /auth/role-manage
     * @author whg <weihuiguo@misrobot.com>
     * @date 2015-12-15 14:20
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */

    public function deleteRole(){
        $id = Input::get('id');
        if($id){
            $deleteRole = DB::connection('sys')->table('sys_roles')->where(['id'=>$id])->delete();
            if($deleteRole){
                return redirect()->intended('/auth/auth-manage');
            }else{
                return  redirect()->back()->withErrors(['系统繁忙']);
            }
        }else{
            return  redirect()->back()->withErrors(['系统繁忙']);
        }
    }

    /**
     * 编辑角色
     * @method GET /auth/role-manage
     * @author whg <weihuiguo@misrobot.com>
     * @date 2015-12-15 14:20
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function editRole(Request $Request){
        //dd(Input::get());
        $this->validate($Request,[
            'name' => 'required|min:2|max:10',
            ]);
        $data = [
            'name' => Input::get('name'),
            'description'=>Input::get('description')
        ];
        $addNewRole = DB::connection('sys')->table('sys_roles')->where(['id'=>Input::get('id')])->update($data);
        if($addNewRole){
            return redirect()->route('auth.AuthManage');
        }else{
            return  redirect()->back()->withErrors(['系统繁忙']);
        }
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
     * 添加基础权限信息
     * @method GET /auth/add-auth
     * @access public
     *
     * @param Request $request get请求<br><br>
     * <b>get请求字段：</b>
     * @return view
     *
     * @author tangjun <tangjun@misrobot.com>
     * @date 2015年12月17日13:59:39
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function AddAuth(SysPermissions $SysPermissions,SysMenus $SysMenus){

/*       $data = [
           0=>[
               'moduleid'=>'user',
               'name'=>'热点和专题',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
           ],
           1=>[
               'moduleid'=>'admin',
               'name'=>'信息推送',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
           ],
           2=>[
               'moduleid'=>'admin',
               'name'=>'股机',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
           ],
           3=>[
               'moduleid'=>'admin',
               'name'=>'自定义',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
           ],
           4=>[
               'moduleid'=>'admin',
               'name'=>'股先生DIY',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
           ],
           5=>[
               'moduleid'=>'admin',
               'name'=>'行业股池',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
           ],
           7=>[
                'moduleid'=>'admin',
                'name'=>'运营',
                'url'=>'',
                'pid'=>'0',
                'ico'=>'fa-table',
                'order'=>'',
                'descrition'=>''
            ],
            8=>[
               'moduleid'=>'admin',
               'name'=>'财学堂',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
            ],
            9=>[
               'moduleid'=>'admin',
               'name'=>'问股',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
            ],
            10=>[
               'moduleid'=>'admin',
               'name'=>'策略宝',
               'url'=>'',
               'pid'=>'0',
               'ico'=>'fa-table',
               'order'=>'',
               'descrition'=>''
            ]
        ];*/
/*       $data = [
            0=>[
                'moduleid'=>'admin',
                'name'=>'问股管理',
                'url'=>'',
                'pid'=>'83',
                'ico'=>'J_menuItem',
                'order'=>'',
                'descrition'=>''
            ],
            1=>[
                'moduleid'=>'admin',
                'name'=>'股池分类',
                'url'=>'',
                'pid'=>'82',
                'ico'=>'J_menuItem',
                'order'=>'',
                'descrition'=>''
            ],
            2=>[
                'moduleid'=>'admin',
                'name'=>'股池价格管理',
                'url'=>'',
                'pid'=>'82',
                'ico'=>'J_menuItem',
                'order'=>'',
                'descrition'=>''
            ],
            3=>[
                'moduleid'=>'admin',
                'name'=>'股池预期收益管理',
                'url'=>'',
                'pid'=>'82',
                'ico'=>'J_menuItem',
                'order'=>'',
                'descrition'=>''
            ],
            4=>[
                'moduleid'=>'admin',
                'name'=>'股池持股周期管理',
                'url'=>'',
                'pid'=>'82',
                'ico'=>'J_menuItem',
                'order'=>'',
                'descrition'=>''
            ],
            5=>[
                'moduleid'=>'admin',
                'name'=>'直播管理',
                'url'=>'',
                'pid'=>'86',
                'ico'=>'J_menuItem',
                'order'=>'',
                'descrition'=>''
            ],
            6=>[
               'moduleid'=>'admin',
               'name'=>'调仓理由',
               'url'=>'',
               'pid'=>'86',
               'ico'=>'J_menuItem',
               'order'=>'',
               'descrition'=>''
            ]
        ];*/

        //$SysMenus->AddMenus($data);
    }

    /**
     * @method
     * @url  /auth/check-name-only
     * @access public
     * @author tangjun <tangjun@misrobot.com>
     * @date    2016年2月15日16:07:05
     * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
     */
    public function postCheckNameOnly(Request $request){
        $this->validate($request,[
            'name'   => 'required',
        ]);

        $SysRoles = new SysRoles;
        if(!empty($request['id'])){
            $SysRolesInfo = $SysRoles->where('name','=',$request['name'])->where('id','<>',$request['id'])->first();
        }else{
            $SysRolesInfo = $SysRoles->where('name','=',$request['name'])->first();
        }

        if(!empty($SysRolesInfo->id)){
            return response()->json(
                $this->success_rows(1,'名称重复')
            );
        }else{
            return response()->json(
                $this->success_rows(2,'没有相同名称')
            );
        }

    }

    /**
     * 接口调用成功返回json数据结构(多行记录)
     *
     * @return string
     * [
     * 		'code'			=>	1,
     * 		'message'		=>	'success',
     * 		'data'			=>	[
     * 		'total'		=>	10,
     * 		'pagesize'	=>	10,
     * 		'pageindex'	=>	1,
     * 		'rows'		=>	[]
     * 		]
     * ];
     */
    public function success_rows($code=1,$message='success',$total=0,$pagesize=10,$pageindex=0,$rows=[]){

        return [
            'code'			=>	$code,
            'message'		=>	$message,
            'data'			=>	[
                'total'		=>	$total,
                'pagesize'	=>	$pagesize,
                'page'		=>	$pageindex,
                'rows'		=>	$rows
            ]
        ];
    }
}   