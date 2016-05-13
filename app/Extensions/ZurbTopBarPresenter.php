<?php
namespace App\Extensions;
/**
 * Created by PhpStorm.
 * @author tangjun <tangjun@misrobot.com>
 * @date 2016-01-21 18:27
 * @copyright 2013-2015 MIS misrobot.com Inc. All Rights Reserved
 */
use Pingpong\Menus\Presenters\Presenter;

class ZurbTopBarPresenter extends Presenter
{

    /*
     *
     * <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="profile-element">
                           <span style="font-size:20px;color:#fff;font-weight: bold;">技能中心管理系统</span>

                        </div>
                        <div class="logo-element">
                        </div>
                    </li>

                    {!! Menu::get('navbar') !!}

                    <li>
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">学生信息审核</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="{{route('msc.verify.student')}}">学生注册审核</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">楼栋信息管理</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.floor.index')}}">楼栋列表</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">实验室管理</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.laboratory.index')}}">实验室列表</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.LadMaintain.LaboratoryList')}}">实验室资源维护</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.laboratory.getLabClearnder')}}">开放日历管理</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.laboratory.getLabOrderList')}}">预约记录审核</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.laboratory.getLabOrderShow')}}">实验室预约查看</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">系统码表管理</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.profession.ProfessionList')}}">专业列表</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{route('msc.Dept.DeptList')}}">科室列表</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.professionaltitle.JobTitleIndex')}}">职称列表</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{route('msc.admin.resources.ResourcesIndex')}}">资源列表</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-user"></i> <span class="nav-label">用户权限管理</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="J_menuItem" href="{{ route('msc.admin.user.StudentList') }}">用户管理</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="{{ route('auth.AuthManage') }}">角色权限管理</a>
                            </li>
                        </ul>
                    </li>

                </ul>
     *
     * */
    /**
     * {@inheritdoc }
     */
    public function getOpenTagWrapper()
    {
        return  PHP_EOL . '<ul class="nav">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }
     */
    public function getCloseTagWrapper()
    {
        return  PHP_EOL . ' </ul>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<li><a href="#"><i class="fa fa-user"></i> <span class="nav-label">'.$item->getIcon().' '.$item->title.'</span><span class="fa arrow"></span></a></li>';

    }

    /**
     * {@inheritdoc }
     */
    public function getActiveState($item)
    {
        return \Request::is($item->getRequest()) ? ' class="active"' : null;
    }

    /**
     * {@inheritdoc }
     */
    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    public function getMenuWithDropDownWrapper($item)
    {
        return '<li>
                <a href="#"><i class="fa '.$item->attributes.'"></i> <span class="nav-label">'.$item->getIcon().' '.$item->title.'</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                  '.$this->getChildMenuItemsT($item).'
                </ul>
              </li>' . PHP_EOL;
        ;
    }
}
