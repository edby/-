<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\phpStudy\WWW\zcgj\public/../application/index\view\user\userreg.html";i:1542073333;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>注册</title>
		<link rel="stylesheet" href="/static/ace/css/bootstrap.css" />
		<link rel="stylesheet" href="/static/ace/css/login.css" />
	</head>
	<body class="login_bg">
		<img src="/static/ace/img/logo_zc.png" class="logo"/>
		<div class="forgot_pass regis_body" style='height:520px;'>
			<h1>注册</h1>
			<input id='account' name='account' type='text' placeholder="请输入手机号" />
			<input id='code' name='code' placeholder="请输入验证码" class="code" />
			<span id='get_verification'>发送验证码</span>
			<input id='password' name='password' type='password' placeholder="请输入密码" type="password" />
			<input id='repassword' name='repassword' type='password' placeholder="请再次输入密码" type="password" />
			<input type='text' placeholder='请输入您的邀请码' value='<?php echo $user['invitation_code']; ?>' disabled="disabled" />
			<input id='invitation_code' type='hidden' name='invitation_code' value='<?php echo $user['invitation_code']; ?>' />
			<button id='reg'>立即注册</button>
			<div class="login_bottom" style='cursor:default;'></div>
		</div>
	</body>
	<script type="text/javascript" src="/static/ace/js/jquery.min.js" ></script>
	<script type="text/javascript" src="/static/ace/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="/static/ace/js/common.js" ></script>
</html>
<script src="/static/ace/js/layer/layer.js"></script>
<script type='text/javascript'>
	//获取短信验证码;  
    var validCode = true;
    $("#get_verification").click(function() {
        var phone = $('#account').val();
        $(this).attr('disabled', true);
        var time = 30;
        var get_code = $(this);
        if(validCode) {
            $.ajax({
            	type:'post',
            	url:'<?php echo url("get_verify"); ?>',
            	data:{account:phone,type:1},
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
    
    // 执行注册
    $('#reg').click(function(){
    	
    	var data = {
    		account:$('#account').val(),
    		code:$('#code').val(),
    		password:$('#password').val(),
    		repassword:$('#repassword').val(),
    		invitation_code:$('#invitation_code').val(),
    	}
    	
    	$.ajax({
    		type:"post",
    		url:"<?php echo url('userreg'); ?>",
    		data:data,
    		success:function(ret){
    			if(ret.code === 0){
    				layer.msg(ret.msg);
    			}else{
    				layer.msg(ret.msg,{icon:ret.code,time:2000},function(){
    					location.href = ret.url;
    				})
    			}
    		}
    	});
    });
</script>
