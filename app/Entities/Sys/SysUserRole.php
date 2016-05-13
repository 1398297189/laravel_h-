<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/4 0004
 * Time: 20:16
 */
namespace App\Entities\Sys;

use Illuminate\Database\Eloquent\Model;


class SysUserRole extends Model
{
    protected $connection = 'sys';
    protected $table = 'sys_user_role';
    protected $fillable = ['role_id', 'user_id'];
    public $timestamps = true;
    public $incrementing = true;

    public function SysRoles(){
        return $this->hasOne('App\Entities\Sys\SysRoles','id','role_id');
    }
}