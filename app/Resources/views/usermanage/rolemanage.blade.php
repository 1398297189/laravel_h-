@extends('layouts.usermanage')

@section('only_css')
    <link href="{{asset('')}}" rel="stylesheet">
@stop

@section('only_js')
    <script src="{{asset('msc/admin/usermanage/rolemanage.js')}}"></script>
@stop

@section('content')
    <input type="hidden" id="parameter" value="{'pagename':'rolemanage','ajaxUrl':'{{ route('auth.postCheckNameOnly') }}'}" />
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-title">
            <h5>角色权限管理</h5>
            <div class="ibox-btns user_btn">
                <button type="button" class="btn btn-white right" id="add_role" data-toggle="modal" data-target="#myModal" style="color: #9c9c9c">新增角色</button>
            </div>
        </div>
        <div class="ibox float-e-margins">
            <div class="container-fluid ibox-content">
                <table class="table table-striped" id="table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>角色名称</th>
                        <th>描述</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($roleList as $role)
                    <tr>
                        <td class="open-id">{{@$role->id}}</td>
                        <td class="role_name">{{@$role->name}}</td>
                        <td class="role_descrip">{{@$role->description}}</td>
                        <td>
                            <a class="state1 edit_role modal-control marr_1" data-toggle="modal" data-target="#myModal" data="{{@$role->id}}">编辑</a>
                            <a class="state1 modal-control marr_1" href="{{ route('auth.SetPermissions',[@$role->id]) }}">设置权限</a>
                            <a class="state2 delete" data="{{@$role->id}}">删除</a>
                        </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
                <div class="pull-right"></div>
            </div>
        </div>
    </div>

@stop{{-- 内容主体区域 --}}

@section('layer_content')
    {{--新增--}}
    <form class="form-horizontal" id="Form" novalidate="novalidate" method="post" action="{{route('auth.postAddNewRole')}}">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="add_close">&times;</button>
            <h4 class="modal-title" id="myModalLabel">新增角色</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="col-sm-3 control-label"><span class="dot">*</span>角色名称：</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control add_name" placeholder="请输入角色名称" id="add_name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><span class="dot">*</span>角色描述：</label>
                <div class="col-sm-9">
                    <input type="text" name="description" class="form-control add_description" placeholder="请输入角色描述">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-5 col-sm-offset-4 right">
                    <button type="button" class="btn btn-success notAgree" id='sure_sub' aria-hidden="true">确　　定</button>
                    <button type="button" class="btn btn-white right" data-dismiss="modal" aria-hidden="true" id="cancel_btn">取　　消</button>
                </div>
            </div>
        </div>
    </form>
{{--编辑--}}
    <form method="post" action="{{ url('/auth/edit-role') }}" class="form-horizontal" id="Form2" novalidate="novalidate" style="display: none" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">编辑角色</h4>
        </div>
        <div class="modal-body">
            <input id="edit_id" type="hidden" name="id" class="form-control" value="">
            <div class="form-group">
                <label class="col-sm-3 control-label"><span class="dot">*</span>角色名称：</label>
                <div class="col-sm-9">
                    <input id="edit_name" type="text" name="name" class="form-control" placeholder="请输入文本" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><span class="dot">*</span>角色描述：</label>
                <div class="col-sm-9">
                    <input id="edit_des" type="text" name="description" class="form-control" placeholder="请输入文本" value="">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-5 col-sm-offset-4 right">
                    <button type="button" class="btn btn-success notAgree" id='sure-notice' aria-hidden="true">确　　定</button>
                    <button type="button" class="btn btn-white right" data-dismiss="modal" aria-hidden="true" id="cancelEdit">取　　消</button>
                </div>
            </div>
        </div>
    </form>
@stop