<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:23 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Mr.Stock 管理后台 登录</title>
    <meta name="keywords" content="Mr.Stock 管理后台">
    <meta name="description" content="Mr.Stock 管理后台">

    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <link href="{{asset('h+/css/bootstrap.min14ed.css')}}" rel="stylesheet">
    <link href="{{asset('h+/css/font-awesome.min93e3.css')}}" rel="stylesheet">

    <link href="{{asset('h+/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('h+/css/style.min862f.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">
    <?php
    $errorsInfo =(array)$errors->getMessages();
    if(!empty($errorsInfo)){
        $errorsInfo = array_shift($errorsInfo);
    }
    ?>
    @forelse($errorsInfo as $errorItem)
        <div class="pnotice" style="display: none;">{{$errorItem}}</div>
    @empty
    @endforelse

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">M.S</h1>

            </div>
            <h3>欢迎使用 Mr.Stock 管理后台</h3>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="用户名" required="">
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="">
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>

                <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
                </p>

            </form>
        </div>
    </div>
    <script src="{{asset('h+/js/jquery.min.js')}}"></script>
    <script src="{{asset('h+/js/bootstrap.min.js')}}"></script>
</body>
<script>
    $(function(){
        //错误提示
        var msg = $('.pnotice').text();
        if(msg==''){
            $("#passwdTip").css('display','none');
            return;
        }else{
            $("#passwdTip").css('display','block');
        }
    })
</script>

<!-- Mirrored from www.zi-han.net/theme/hplus/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:23 GMT -->
</html>
