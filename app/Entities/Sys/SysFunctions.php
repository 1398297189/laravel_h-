<?php
/**
 * Created by PhpStorm.
 * User: tangjun <tangjun@misrobot.com>
 * Date: 2015年12月15日
 * Time: 11:18:06
 */

namespace App\Entities\Sys;

use Illuminate\Database\Eloquent\Model;


class SysFunctions extends Model
{
    protected $connection	=	'sys';
    protected $table 		= 	'sys_functions';


    public function getFunctionsList(){
        return  $thisBuilder = $this->with('SysPermissionFunction')->get();
    }

    public function SysPermissionFunction(){
        return  $this->hasOne('App\Entities\Sys\SysPermissionFunction','function_id','id');
    }




}