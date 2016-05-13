<?php
/**
 * Created by PhpStorm.
 * User: tangjun <tangjun@misrobot.com>
 * Date: 2015年12月15日
 * Time: 11:18:06
 */

namespace App\Entities\Sys;

use Illuminate\Database\Eloquent\Model;


class SysPermissionFunction extends Model
{
    protected $connection	=	'sys';
    protected $table 		= 	'sys_permission_function';


    public function getPermissionFunctionsList($PermissionFunctionsArr){
        $thisBuilder = $this;
        if(!empty($PermissionMenuArr) && is_array($PermissionMenuArr)){
            $thisBuilder = $thisBuilder->whereIn('permission_id',$PermissionMenuArr);
        }
        return  $thisBuilder->with('SysFunctions')->first();
    }

    public function SysFunctions(){
        return $this->hasMany('App\Entities\Sys\SysFunctions','id','function_id');
    }


}