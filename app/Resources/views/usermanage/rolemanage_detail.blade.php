@extends('layouts.usermanage')

@section('only_css')

    <style>
        .clear_padding{
            padding: 0;
        }
        .clear_margin{
            margin: 0;
        }
        .border-bottom{
            border-bottom: none!important;
        }
        .btn-default{
            color: #9c9c9c;
        }
        .btn_padding{
            padding: 2px 5px;
        }
        .btn_focus{
            background-color: #bababa!important;
            color: #fff!important;
        }
        /*.btn:hover{*/
            /*color: #fff;*/
            /*background-color: #bababa;*/
        /*}*/
        /*.btn:focus{*/
            /*background-color: #fff;*/
            /*color: #9c9c9c;*/
        /*}*/
    </style>
@stop

@section('only_js')
    <script src="{{asset('msc/admin/usermanage/rolemanage.js')}}"></script>
@stop

@section('content')
    <input type="hidden" id="parameter" value="{'pagename':'rolemanage_detail'}" />
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-title">
            <h5>{{ @$roleName }}-权限设置</h5>
            <div class="ibox-btns user_btn">
                <button class="btn btn-white right marl_10" id="saveForm" style="color: #9c9c9c">保　　存</button>
                <button class="btn btn-success marl_10" id="goHistory">返　　回</button>
            </div>
        </div>
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div style="margin-top: 10px">
                   <label class="check_label checkbox_input">
                        <div class="check_icon" style="display: inline-block"></div>
                        <input type="checkbox" value="">
                        <span style="float: right;text-indent: 6px">技能中心管理系统</span>
                    </label>
                    <!-- <label class="check_label checkbox_input" style="margin-left: 15px">
                        <div class="check_icon" style="display: inline-block"></div>
                        <input type="checkbox" value="">
                        <span style="float: right;text-indent: 6px">OSCE考试智能管理系统</span>
                    </label>
                    <label class="check_label checkbox_input" style="margin-left: 15px">
                        <div class="check_icon" style="display: inline-block"></div>
                        <input type="checkbox" value="">
                        <span style="float: right;text-indent: 6px">智能分析系统</span>
                    </label>
                    -->

                </div>
                <div class="hr-line-dashed"></div>
                <form method="post" action="{{ route('auth.SavePermissions') }}" id="authForm" class="panel-body">
                    <input type="hidden" value="{{ $role_id }}" name="role_id">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="ibox-title" style="border-top: none;">
                                一级
                            </div>
                            <div class="ibox-content">
                                <ul class="clear_padding">
                                    @foreach($MenusList as $val)
                                        <li>
                                            <div class="ibox float-e-margins clear_margin">
                                                <label class="check_label checkbox_input" hidevalue="{{ @$val['SysPermissionMenu']['permission_id'] }}">
                                                    <div  class="check_real check_icon display_inline @if(!empty($val['SysPermissionMenu']['permission_id']) && in_array(@$val['SysPermissionMenu']['permission_id'],$PermissionIdArr)) check @endif"></div>
                                                    @if(!empty($val['SysPermissionMenu']['permission_id']) && in_array(@$val['SysPermissionMenu']['permission_id'],$PermissionIdArr))<input type="hidden"  name="permission_id[]" value="{{ @$val['SysPermissionMenu']['permission_id'] }}"> @endif
                                                    <span class="check_name">{{ @$val['name'] }}</span>
                                                </label>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </div>
                                                <div class="ibox-content" style="border-top:none">
                                                    @if(!empty($val['child']))
                                                        @foreach($val['child'] as $v)
                                                            <button type="button" hidevalue="{{ @$v['SysPermissionMenu']['permission_id'] }}" class="btn btn-outline @if(!empty($v['SysPermissionMenu']['permission_id']) && in_array(@$v['SysPermissionMenu']['permission_id'],$PermissionIdArr)) btn_focus @else btn-default2 @endif  font10 btn_padding" permission_id="{{ @$v['SysPermissionMenu']['permission_id'] }}" >{{ @$v['name'] }}</button>
                                                            @if(!empty($v['SysPermissionMenu']['permission_id']) && in_array(@$v['SysPermissionMenu']['permission_id'],$PermissionIdArr))
                                                                <input type="hidden"  name="permission_id[]" value="{{ @$v['SysPermissionMenu']['permission_id'] }}">
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="ibox-title" style="border-top: none;">
                                二级
                            </div>
                            <div class="ibox-content">
                                <ul class="clear_padding">
                                    @foreach($FunctionsList as $val)
                                        <li>
                                            <div class="ibox float-e-margins clear_margin">
                                                <label class="check_label checkbox_input">
                                                    <div class="check_real check_icon display_inline @if(!empty($val['SysPermissionFunction']['permission_id']) && in_array(@$val['SysPermissionFunction']['permission_id'],$PermissionIdArr)) check @endif"></div>
                                                    <input type="checkbox" @if(!empty($val['SysPermissionFunction']['permission_id']) && in_array(@$val['SysPermissionFunction']['permission_id'],$PermissionIdArr)) checked="checked" @endif  name="permission_id[]" value="{{ @$val['SysPermissionFunction']['permission_id'] }}">
                                                    <span class="check_name">{{ @$val['name'] }}</span>
                                                </label>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </div>
                                                <div class="ibox-content" style="border-top:none">
                                                    @if(!empty($val['child']))
                                                        @foreach($val['child'] as $v)
                                                            <button type="button" class="btn btn-outline @if(!empty($v['SysPermissionFunction']['permission_id']) && in_array(@$v['SysPermissionFunction']['permission_id'],$PermissionIdArr)) btn_focus @else btn-default2 @endif  font10 btn_padding" value="{{ @$v['SysPermissionFunction']['permission_id'] }}">{{ @$v['name'] }}</button>
                                                        @endforeach
                                                    @endif
                                                </div>

                                                {{--<div class="ibox-content clear_padding" style="border-top: none">--}}
                                                {{--<div id='external-events'>--}}
                                                {{--<div style="margin-left: 5%">--}}
                                                {{--@if(!empty($val['child']))--}}
                                                {{--@foreach($val['child'] as $v)--}}
                                                {{--<label class="check_label checkbox_input">--}}
                                                {{--<div class="check_real check_icon display_inline @if(!empty($v['SysPermissionFunction']['permission_id']) && in_array(@$v['SysPermissionFunction']['permission_id'],$PermissionIdArr)) check @endif"></div>--}}
                                                {{--<input type="checkbox" @if(!empty($v['SysPermissionFunction']['permission_id']) && in_array(@$v['SysPermissionFunction']['permission_id'],$PermissionIdArr)) checked="checked" @endif  name="permission_id[]" value="{{ @$v['SysPermissionFunction']['permission_id'] }}">--}}
                                                {{--<span class="check_name">{{ @$v['name'] }}</span>--}}
                                                {{--</label>--}}
                                                {{--@endforeach--}}
                                                {{--@endif--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="ibox-title" style="border-top: none;">
                                极限细则
                            </div>
                            <div class="ibox-content">
                                <ul class="clear_padding">

                                </ul>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
@stop{{-- 内容主体区域 --}}
