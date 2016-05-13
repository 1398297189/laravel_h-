@extends('layouts.base')
@section('meta')
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
@stop
@section('head_css')
    <link href="{{asset('h+/css/bootstrap.min14ed.css')}}" rel="stylesheet">
    <link href="{{asset('h+/css/font-awesome.min93e3.css')}}" rel="stylesheet">
    <link href="{{asset('h+/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('h+/css/style.min862f.css')}}" rel="stylesheet">
    <link href="{{asset('common/css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('common/css/common.css')}}" rel="stylesheet">
@stop


@section('footer_js')
    <script src="{{asset('h+/js/jquery.min.js')}}"></script>
    <script src="{{asset('h+/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('h+/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('h+/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('h+/js/plugins/layer/layer.min.js')}}"></script>
    <script src="{{asset('h+/js/hplus.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('h+/js/contabs.min.js')}}"></script>
    <script src="{{asset('h+/js/plugins/pace/pace.min.js')}}"></script>
    <script src="{{asset('common/js/bootstrapValidator.js')}}"></script>
@show