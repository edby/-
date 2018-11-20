<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:69:"D:\phpStudy\WWW\zcgj\public/../application/index\view\user\bonus.html";i:1542423948;s:63:"D:\phpStudy\WWW\zcgj\application\index\view\common\userTop.html";i:1542452401;s:64:"D:\phpStudy\WWW\zcgj\application\index\view\common\userMenu.html";i:1542452364;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1542683181;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>全部分类</title>
    <link rel="stylesheet" href="/static/ace/css/common.css" />
    <link rel="stylesheet" href="/static/ace/css/zhongyu.css" />
    <link rel="stylesheet" href="/static/ace/css/bootstrap.css" />
    <link rel="stylesheet" href="/static/ace/css/vip.css">
    
    <script type="text/javascript" src="/static/ace/js/jquery.min.js" ></script>
	<script type="text/javascript" src="/static/ace/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="/static/layui/layui.js"></script>
	<script type="text/javascript" src="/static/ace/js/common.js" ></script>
	<script type="text/javascript" src="/static/ace/js/vip.js"></script>
    <script type='text/javascript'>
		// 修改个人信息
		function user_change() {
	        layer.confirm('修改信息需要使用修改券！', {
	            btn: ['修改信息','稍后再说'] //按钮
	        }, function(){
	        	var uid = $('.user_name').attr('data-uid');
	        	$.ajax({
	        		type:'post',
	        		url:'<?php echo url("user_vou"); ?>',
	        		data:{uid:uid,vid:3},
	        		success:function(ret){
	        			if(ret.code === 0){
	        				layer.msg(ret.msg);
	        			}else{
	        				if(ret.num <= 0){
	        					layer.confirm('修改券不足！', {
						            btn: ['现在购买','稍后再说'] //按钮
						        }, function(){
						        	window.location.href = '<?php echo url("goods/change"); ?>';
						        });
	        				}else{
	        					layer.close(layer.index);
	        					$('#myModalLabel').html('修改个人信息');
	        					$('#myModal').modal('show');
	        				}
	        			}
	        		}
	        	});
	        });
		}
		
		// 提交完善/修改个人信息
		function full_detail() {
		    layer.confirm('确定提交？', {
		        btn: ['确定','取消'] //按钮
		    }, function(){
		        var data = {
		        	real_name:$('#uName').val(),
		        	tel:$('#uPhone').val(),
		        	wechat_accout:$('#weChat').val(),
		        	alipay_accout:$('#aliPay').val(),
		        }
		        
		        $.ajax({
		        	type:'post',
		        	url:'<?php echo url("editUser"); ?>',
		        	data:data,
		        	success:function(ret){
		        		if(ret.code === 0){
		        			if(ret.url){
			        			layer.alert(ret.msg,{icon:1500},function(){
			        				location.href = ret.url;
			        			});
							}else{
								layer.alert(ret.msg);
							}
		        		}else{
		        			$('#myModal').modal('hide');
		        			layer.msg(ret.msg);
		        		}
		        	}
		        });
		    });
		}
		
		// 帮新会员注册
		function go_reg() {
			var uid = $('.user_name').attr('data-uid');
			$.ajax({
				type:'post',
				url:'<?php echo url("user_status"); ?>',
				data:{uid:uid},
				success:function(ret){
					if(ret.code === 0){
						layer.msg(ret.msg,{icon:ret.code,time:1500},function(){
							location.href = ret.url;
						});
					}else{
						window.location.href = '<?php echo url("user/userreg"); ?>';
					}
				}
			});
		}
		
		// 去购买
		function buy_tip(id) {
			switch(id){
				case 2:	// 手续费券
					window.location.href = '<?php echo url("goods/tip"); ?>';
					break;
				case 3:	// 修改券
					window.location.href = '<?php echo url("goods/change"); ?>';
					break;
				case 4:	// 激活券
					window.location.href = '<?php echo url("goods/activate"); ?>';
					break;
				case 5:	// 入住券
					window.location.href = '<?php echo url("goods/enter"); ?>';
					break;
			}
		}
    </script>
</head>
<body>
<!--头部-->
<div class="top_nav">
    <div class="container clearfix">
        <div class="top_nav_l">
            <img src="/static/ace/img/logo_zc.png"/>
        </div>
        <ul class="top_nav_r clearfix">
            <?php if(is_array($sidebar) || $sidebar instanceof \think\Collection || $sidebar instanceof \think\Paginator): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<li>
					<a href="/<?php echo $vo['name']; ?>"><?php echo $vo['title']; ?></a>
				</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <?php if(empty($account) || (($account instanceof \think\Collection || $account instanceof \think\Paginator ) && $account->isEmpty())): ?>
	        <div class="accout">
	            <span>ZC</span>
				<div class="accout_menu">
	                <p><a href="<?php echo url('Publics/login'); ?>">登录</a></p>
	            </div>
	        </div>
	    <?php else: ?>
	    	<div class="accout">
	            <span>ZC</span>
	            <?php echo $account; ?>
	            <div class="accout_menu">
	                <p><a href="<?php echo url('User/wallet'); ?>">会员中心</a></p>
	                <p><a href="<?php echo url('Publics/logout'); ?>">退出登录</a></p>
	            </div>
	        </div>
	    <?php endif; ?>
    </div>
</div>

<!--完善个人信息弹窗-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">完善个人信息</h4>
            </div>
            <div class="modal-body">
                <ul class="full_detail">
                    <li>
                        <span>姓&emsp;名：</span>
                        <input type="text" name="full" id="uName">
                    </li>
                    <li>
                        <span>手机号：</span>
                        <input type="number" name="full" id="uPhone">
                    </li>
                    <li>
                        <span>微信号：</span>
                        <input type="text" name="full" id="weChat">
                    </li>
                    <li>
                        <span>支付宝：</span>
                        <input type="text" name="full" id="aliPay">
                    </li>
                    <li>
                        <div class="full_btn">
                            <button type="button" class="btn btn-primary" onclick="full_detail()">确认提交</button>
                            <p>请仔细确认个人信息，修改个人信息需要购买修改券</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<link rel="stylesheet" href="/static/ace/css/bonus.css">
<!--内容-->
<main class="main">
    <div class="main_box">
        <div class="main_left">
            <!--左侧用户信息&左侧会员中心导航栏-->
            <!--左侧会员中心导航栏-->
<div class="member">
    <div class="member_box">
        <img src="/static/ace/img/show1.jpg" class="portrait">
        <span>
            <div class="user_name" data-uid='<?php echo $user['id']; ?>'>
                <span><?php echo $user['real_name']; ?></span>
                <small>
                    <?php echo $user['level_text']; switch($user['level']): case "1": break; case "2": ?><img src="/static/ace/img/moon.png"><?php break; case "3": ?><img src="/static/ace/img/moon.png"><img src="/static/ace/img/moon.png"><?php break; case "4": ?><img src="/static/ace/img/moon.png"><img src="/static/ace/img/moon.png"><img src="/static/ace/img/moon.png"><?php break; case "5": ?><img style='margin-top:-5px;margin-left:5px;' src="/static/ace/img/sun.png"><?php break; endswitch; ?>
                </small>
            </div>
            <div class="user_phone"><?php echo $user['account']; ?></div>
            <?php if($user['status'] != 1): ?>
            <button type="button" title="消耗激活券进行激活" onclick="javascript:layer.confirm('确认激活??',function (){active_user()})">激活会员</button>
            <?php else: ?>
            <button type="button" disabled>会员已激活</button>
            <?php endif; if($user['is_set'] != '1'): ?>
            	<div class="user_full" data-toggle="modal" data-target="#myModal">完善个人信息 >></div>
        	<?php endif; ?>
        </span>
    </div>
    <div class="user_detail">
        <div>
            绑定微信号：
            <span><?php echo $user['wechat_accout']; ?></span>
        </div>
        <div>
            绑定支付宝：
            <span><?php echo $user['alipay_accout']; ?></span>
        </div>
        <div>
		帐号状态：
            <span class="blue"><?php echo $user['status_text']; ?></span>
        </div>
        <div>
		邀请码：
            <span class="blue"><?php echo $user['invitation_code']; ?></span>
        </div>
        <?php if($user['is_set'] == '1'): ?>
	        <div class="user_change">
	            <span onclick="user_change()">修改个人信息 >></span>
	            <small>（修改个人信息需要修改码）</small>
	        </div>
        <?php endif; ?>
    </div>
    <div class="go_reg">
        <span onclick="go_reg()">去帮新会员注册 >></span>
    </div>
</div>
<script>
    function active_user() {
        $.ajax(
            {
                url:'active_user',
                type:'post',
                data:'',
                success:function (r) {
                    r = JSON.parse(r);
                    if(r['code'] == 1){
                        layer.msg('激活成功！');
						window.location.reload();
                    }else{
                        layer.alert(r['msg']);
                    }
                }
            }
        )
    }
</script>
<div class="vip_nav">
    <ul>
        <li><a href="<?php echo url('wallet'); ?>">钱包</a></li>
        <li><a href="<?php echo url('bonus'); ?>">奖金</a></li>
        <li><a href="<?php echo url('withdraw'); ?>">提现</a></li>
        <li><a href="<?php echo url('transfer'); ?>">转账</a></li>
        <li><a href="<?php echo url('bank'); ?>">银行卡</a></li>
        <li><a href="<?php echo url('mod_pwd'); ?>">修改密码</a></li>
        <li><a href="<?php echo url('address'); ?>">地址管理</a></li>
        <li><a href="<?php echo url('my_promotion'); ?>">我的推广</a></li>
        <li><a href="<?php echo url('about_us'); ?>">关于我们</a></li>
        <li><a href="<?php echo url('Publics/logout'); ?>">退出登录</a></li>
    </ul>
</div>

        </div>

        <div class="main_right">
            <p class="vip_hint">钱包（请妥善保管您的资金）：</p>
            <!--冻结区-->
            <div class="bonus_head">
                <span>冻结区：</span>
            </div>
            <div class="bonus_box">
                <div class="bonus_main">
                    <?php if(is_array($bonus) || $bonus instanceof \think\Collection || $bonus instanceof \think\Paginator): $i = 0; $__LIST__ = $bonus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	                    <div>
	                        <span><?php echo $vo['name']; ?></span>
	                        <p>
	                            <span><?php echo $vo['frozen_bouns_number']; ?></span>
	                            积分
	                        </p>
	                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <p>小提示：进入冻结区的奖金，需要十天才能解冻哦，请耐心等待</p>
            </div>

            <!--解冻区-->
            <div class="bonus_head">
                <span>解冻区：</span>
                <a href="<?php echo url('withdraw'); ?>">提现</a>
            </div>
            <div class="bonus_box">
                <div class="bonus_main">
                    <?php if(is_array($bonus) || $bonus instanceof \think\Collection || $bonus instanceof \think\Paginator): $i = 0; $__LIST__ = $bonus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	                    <div>
	                        <span><?php echo $vo['name']; ?></span>
	                        <p>
	                            <span><?php echo $vo['bouns_number']; ?></span>积分
	                        </p>
	                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <p>小提示：动态解冻一月一次，福利不限次数哦，请耐心等待</p>
            </div>

            <!--转成消费券-->
            <div class="bonus_head">
                <span>转成消费券：</span>
            </div>
            <div class="bonus_box">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#active" data-toggle="tab">动态奖金</a>
                    </li>
                    <li>
                        <a href="#static" data-toggle="tab">静态奖金</a>
                    </li>
                    <li>
                        <a href="#welfare" data-toggle="tab">福利奖金</a>
                    </li>
                </ul>

                <div id="myTabContent" class="tab-content" data-uid='<?php echo $uid; ?>'>
                    <!--动态奖金-->
                    <div class="tab-pane fade in active" id="active">
                        <div class="move_in">
                            <p>
                                <span>动态积分：</span>
                                <small>按照1:1的比例转换消费券</small>
                            </p>
                            <input type="number" id="integral" oninput="integral()" name="bouns_number" placeholder="请输入您的转换的动态积分数量">
                        </div>
                        <div class="move_in">
                            <p>
                                <span>转换的消费券：</span>
                            </p>
                            <input type="number" id="consume" value="0" name="number" readonly="readonly">
                        </div>
                        <input type='hidden' id='integral_id' name='bouns_type' value='2'/>
                        <button type="button" onclick="in_con()">确认转换</button>
                    </div>

                    <!--静态奖金-->
                    <div class="tab-pane fade" id="static">
                        <div class="move_in">
                            <p>
                                <span>静态积分：</span>
                                <small>按照1:1的比例转换消费券</small>
                            </p>
                            <input type="number" id="quiet" oninput="quiet()" name="bouns_number" placeholder="请输入您的转换的静态积分数量">
                        </div>
                        <div class="move_in">
                            <p>
                                <span>转换的消费券：</span>
                            </p>
                            <input type="number" id="sta_con" name="number" value="0" readonly="readonly">
                        </div>
                        <input type='hidden' id='quiet_id' name='bouns_type' value='1'/>
                        <button type="button" onclick="quiet_con()">确认转换</button>
                    </div>

                    <!--福利奖金-->
                    <div class="tab-pane fade" id="welfare">
                        <div class="move_in">
                            <p>
                                <span>福利积分：</span>
                                <small>按照1:1的比例转换消费券</small>
                            </p>
                            <input type="number" id="weal" oninput="weal()" name="bouns_number" placeholder="请输入您的转换的福利积分数量">
                        </div>
                        <div class="move_in">
                            <p>
                                <span>转换的消费券：</span>
                            </p>
                            <input type="number" id="weal_con" name="number" value="0" readonly="readonly">
                        </div>
                        <input type='hidden' id='weal_id' name='bouns_type' value='3'/>
                        <button type="button" onclick="weal_con()">确认转换</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

		<!--底部-->
		<div class="foot">
			<img src="/static/ace/img/logo_zc.png" class="foot_img" />
			<div class="foot_b">@2018.zhongchengguoji</div>
		</div>
		<?php if($pre_card != null): ?>
		<!--优惠券-->
		<div class="coupon">
			<img src="/static/ace/img/yhq.png" class="yhq"/>
			<img src="/static/ace/img/close.png" class="cls" onclick="cls()"/>
		</div>
		<div class="mask"></div>
        <?php endif; ?>
	</body>
	<script>
		function cls(){
			$('.coupon,.mask').hide();
		}
		// var stat = document.cookie.split(";")[0].split("=")[1];
		// setTimeout(function(){
		// 	// document.cookie="sata=0";
		// },1500);
		// // console.log(document.cookie)
		// if(stat == 1){
		// 	$('.coupon,.mask').fadeIn();
		// }else{
		// 	$('.coupon,.mask').hide();
		// }
	</script>
</html>
<script>
    vipNav(1)
</script>
<script type='text/javascript'>
// 判断买入数量输入格式
$('#integral,#quiet,#weal').on('input',function(){
	$(this).val($(this).val().match(/\d+\.?\d{0,2}/));
});
var uid = $('.user_name').attr('data-uid');

// 提交动态积分
function integral() {
    var num = $('#integral').val();
    $('#consume').val(num);
}
function in_con() {
    var number = $('#integral').val();
    var bouns_type = $('#integral_id').val();
    layer.confirm('确定转换？', {
        btn: ['确定','取消']
    }, function(){
        $.ajax({
        	type:'post',
        	url:'<?php echo url("bonus"); ?>',
        	data:{uid:uid,number:number,bouns_type:bouns_type},
        	success:function(ret){
        		if(ret.code === 0){
        			if(ret.url){
	        			layer.alert(ret.msg,{icon:1500},function(){
	        				location.href = ret.url;
	        			});
					}else{
						layer.alert(ret.msg);
					}
        		}else{
        			$('#integral').val('');
        			$('#consume').val('0');
        			layer.alert(ret.msg);
        		}
        	}
        });
    });
}


// 提交静态积分
function quiet() {
    var num = $('#quiet').val();
    $('#sta_con').val(num);
}
function quiet_con() {
    var number = $('#quiet').val();
    var bouns_type = $('#quiet_id').val();
    layer.confirm('确定转换？', {
        btn: ['确定','取消']
    }, function(){
        $.ajax({
        	type:'post',
        	url:'<?php echo url("bonus"); ?>',
        	data:{uid:uid,number:number,bouns_type:bouns_type},
        	success:function(ret){
        		if(ret.code === 0){
        			if(ret.url){
	        			layer.alert(ret.msg,{icon:1500},function(){
	        				location.href = ret.url;
	        			});
					}else{
						layer.alert(ret.msg);
					}
        		}else{
        			$('#quiet').val('');
        			$('#sta_con').val('0');
        			layer.alert(ret.msg);
        		}
        	}
        });
    });
}

// 提交福利积分
function weal() {
    var num = $('#weal').val();
    $('#weal_con').val(num);
}
function weal_con() {
    var number = $('#weal').val();
    var bouns_type = $('#weal_id').val();
    layer.confirm('确定转换？', {
        btn: ['确定','取消']
    }, function(){
        $.ajax({
        	type:'post',
        	url:'<?php echo url("bonus"); ?>',
        	data:{uid:uid,number:number,bouns_type:bouns_type},
        	success:function(ret){
        		if(ret.code === 0){
        			if(ret.url){
	        			layer.alert(ret.msg,{icon:1500},function(){
	        				location.href = ret.url;
	        			});
					}else{
						layer.alert(ret.msg);
					}
        		}else{
        			$('#weal').val('');
        			$('#weal_con').val('0');
        			layer.alert(ret.msg);
        		}
        	}
        });
    });
}
</script>
