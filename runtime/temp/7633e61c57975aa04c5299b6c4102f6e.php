<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\phpStudy\WWW\zcgj\public/../application/index\view\publics\login.html";i:1541153389;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>登录</title>
		<link rel="stylesheet" href="/static/ace/css/bootstrap.css" />
		<link rel="stylesheet" href="/static/ace/css/login.css" />
	</head>
	<body class="login_bg">
		<img src="/static/ace/img/logo_zc.png" class="logo"/>
		<div class="login">
			<h1>登录</h1>
			<input id='login_account' name='account' type='text' placeholder="请输入手机号"/>
			<input id='login_password' name='password' type='password'  placeholder="请输入密码" type="password"/>
			<button onclick="login()">登录</button>
			<div class="login_bottom"><span class="wjmm">忘记密码</span></div>
		</div>
		<div class="forgot_pass dis_none">
			<h1>忘记密码</h1>
			<input id='forgot_account' name='account' type='text' placeholder="请输入手机号"/>
			<input id='forgot_code' name='code' placeholder="请输入验证码" class="code"/>
			<span id='get_verification'>发送验证码</span>
			<button onclick='forgot()'>找回密码</button>
			<div class="login_bottom"><font class="ljdl">立即登录</font></div>
		</div>
	</body>
	<script type="text/javascript" src="/static/ace/js/jquery.min.js" ></script>
	<script type="text/javascript" src="/static/ace/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="/static/ace/js/common.js" ></script>
</html>
<script src="/static/ace/js/layer/layer.js"></script>
<script type='text/javascript'>
	// 登陆
	function login(){
		var log_account = $('#login_account').val();
		var log_password = $('#login_password').val();
		$.ajax({
			type:'post',
			url:'<?php echo url("login"); ?>',
			data:{account:log_account,password:log_password},
			success:function(ret){
				if(ret.code === 0){
					layer.msg(ret.msg);
				}else{
					layer.msg(ret.msg,{icon:ret.code,time:2000},function(){
						location.href = ret.url
					})
				}
			}
		});
	}
	
	// 获取短信验证码;  
    var validCode = true;
    $("#get_verification").click(function() {
        var phone = $('#forgot_account').val();
        $(this).attr('disabled', true);
        var time = 30;
        var get_code = $(this);
        if(validCode) {
            $.ajax({
            	type:'post',
            	url:'<?php echo url("get_verify"); ?>',
            	data:{account:phone,type:2},
            	success:function(ret){
            		if(ret.code === 0){
                        layer.msg(ret.msg);
                    }else{
                        validCode = false;
                        var t = setInterval(function() {
                            time--;
                            get_code.html(time + "秒");
                            if(time == 0) {
                                clearInterval(t);
                                get_code.html("重新获取");
                                validCode = true;
                                get_code.attr('disabled', false);
                            }
                        }, 1000);
                        layer.msg(ret.msg);
                        $('#get_verification').attr('data',ret.data);
                        alert(ret.data);
                    }
            	}
            });
        }
    });
	
	// 找回密码
	function forgot(){
		
		
	}
	
</script>
