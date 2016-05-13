        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span style="font-size:20px;color:#fff;font-weight: bold;">技能中心管理系统</span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"><strong class="font-bold">{{@$name}}</strong></span>
                                <span class="text-muted text-xs block">{{@$role}}<b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="J_menuItem" href="">个人资料</a>
                                </li>

                                <li class="divider"></li>
                                <li><a href="">安全退出</a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            HX
                        </div>
                    </li>

                    {!! Menu::get('navbar') !!}



                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->

