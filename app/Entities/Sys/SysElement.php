<?php
/**
 * Created by PhpStorm.
 * User: tangjun <tangjun@misrobot.com>
 * Date: 2015年12月15日
 * Time: 11:18:06
 */

namespace App\Entities\Sys;

use Illuminate\Database\Eloquent\Model;


class SysElement extends Model
{
    protected $connection	=	'sys';
    protected $table 		= 	'sys_element';


    public function getElementList($pid=0){
        return  $this->where('pid','=',$pid)->get();
    }




}