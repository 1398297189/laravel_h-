@extends('layouts.base')
@section('meta')
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
@stop
@section('head_css')
    <link href="{{asset('msc/admin/plugins/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('msc/admin/plugins/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('msc/admin/plugins/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('app/index/style.min.css')}}" rel="stylesheet">
@stop

@section('head_js')

@stop

@section('body_attr') class="fixed-sidebar full-height-layout gray-bg"@stop

@section('body')
    <div id="wrapper">

                @include('layouts/left')


        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">

            <div class="row content-tabs">
                <button class="navbar-header">
                    <a class="navbar-minimalize roll-nav roll-left J_tabLeft " href="#"><i class="fa fa-bars"></i> </a>
                </button>
                <button class="roll-nav roll-left J_tabLeft" style="left: 40px"><i class="fa fa-backward"></i>
                </button>
                <nav class="page-tabs J_menuTabs" style="margin-left: 80px; width:inherit;">
                    <div class="page-tabs-content">
                        <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right J_tabRight" style="right: 120px;"><i class="fa fa-forward"></i>
                </button>
                <button class="roll-nav roll-right J_tabClose" style="padding: 0;width: 60px;">
                    <ul class="nav navbar-top-links navbar-right" style="width: 100%;height: 38px;margin-right: 0;">
                        <li class="dropdown" style="width: 100%;height: 38px;margin-right: 0;">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" style="padding: 0;width: 100%;min-height: 38px;">
                                <i class="fa fa-bell"></i> <span class="label label-primary" style="right: 12px;top: 3px;"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    {{--<a class="J_menuItem" href="/msc/admin/laboratory/lab-order-list" data-index="5">--}}
                                    <a href="javascript:void(0)" class="" id="goBooking">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> <span class="count">您有0条预约信息未处理</span>
                                            <span class="pull-right text-muted small"></span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </button>
                <a href="" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i>退出</a>
            </div>
            <div class="row J_mainContent" id="content-main">

                    <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="" frameborder="0" data-id="index_v1.html" seamless></iframe>

            </div>
            <div class="footer">
                <div class="pull-right">&copy; 2015-2018 <a href="/" target="_blank">misrobot.com</a>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->


    </div>


@section('footer_js')
        <!-- 全局js -->

    <script src="{{asset('msc/admin/plugins/js/jquery-2.1.1.min.js')}}"></script>
    <script src="{{asset('msc/admin/plugins/js/bootstrap.min.js?v=3.4.0')}}"></script>
    <script src="{{asset('msc/admin/plugins/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('msc/admin/plugins/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('msc/admin/plugins/js/plugins/layer/layer.min.js')}}"></script>

    <!-- 自定义js -->
    <script src="{{asset('msc/admin/plugins/js/hplus.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('msc/admin/plugins/js/contabs.min.js')}}"></script>
    <!-- 第三方插件 -->
    <script src="{{asset('msc/admin/plugins/js/plugins/pace/pace.min.js')}}"></script>
    <script>
        $(function(){
            function viewInExplorerStatus(){
                $.ajax({
                    type: "GET",
                    url: "/msc/admin/laboratory/admin-lab-orders",
                    success: function(msg){
                        if(msg.cnt){
                            $('.count').html('您有'+msg.cnt+'条预约信息未处理');
                            $('.label-primary').html(msg.cnt);
                        }
                        if(msg.lasttime){
                            $('.small').html(msg.lasttime);
                        }
                    }});
            }
            viewInExplorerStatus();
            setInterval(viewInExplorerStatus, 300000);
        });
        $("#goBooking").click(function(){
            var obj=$("#side-menu").find("a");
            obj.each(function(){
                if($(this).text() == "预约记录审核"){
                    $(this).click();
                }
            });
        })
    </script>
@show{{-- footer区域javscript脚本 --}}


@section('extraSection')
@show{{-- 补充额外的一些东东，不一定是JS，可能是HTML --}}
@stop