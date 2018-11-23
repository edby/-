<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:72:"D:\phpStudy\WWW\zcgj\public/../application/index\view\user\withdraw.html";i:1542764155;s:63:"D:\phpStudy\WWW\zcgj\application\index\view\common\userTop.html";i:1542452401;s:64:"D:\phpStudy\WWW\zcgj\application\index\view\common\userMenu.html";i:1542452364;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1542683181;}*/ ?>
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

<link rel="stylesheet" href="/static/ace/css/fetch.css" />
<style type='text/css'>
.no_data {height:50px;line-height:50px;font-family:"微软雅黑";font-size:16px;color:purple;text-align:center;border:1px solid gainsboro;}
</style>
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
            <p class="vip_hint">
                提现（请注意资金安全）：
                <small>动态奖，福利奖提现时，20%自动转换为消费券</small>
            </p>
            <div class="fetch_box">
                <ul id="myTab" class="nav nav-tabs">
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	                    <li <?php if($vo['bouns_type'] == '1'): ?>class='active'<?php endif; ?>>
	                        <a href="<?php echo $vo['select']; ?>" data-toggle="tab">
								<?php echo $vo['name']; ?>
	                            <p><?php echo $vo['short_name']; ?>余额：<span class="red"><?php echo $vo['bouns_number']; ?> 积分</span></p>
	                        </a>
	                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
				
                <div id="myTabContent" class="tab-content">
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	                    <div class="tab-pane fade<?php if($vo['bouns_type'] == '1'): ?> in active<?php endif; ?>" id="<?php echo $vo['div_id']; ?>">
	                        <div class="fetch_head">
	                            <p><?php echo $vo['short_name']; ?>余额
	                                <span class="red"><?php echo $vo['bouns_number']; ?> 积分</span>
	                            </p>
	                            <small><?php echo $vo['notice']; ?></small>
	                        </div>
	                        <div class="fetch_in">
	                            <p>
	                                <span>提现金额：</span>
	                                <small data-toggle="modal" data-target="#myModal1">了解提现规则 >></small>
	                            </p>
	                            <input id='number_<?php echo $vo['bouns_type']; ?>' type="number" name='bouns_number' placeholder="请输入您的提现金额" />
	                        </div>
	                        <!--<div class="fetch_acc">
	                            <p>
	                                <span>提现账户：</span>
	                            </p>
	                            <div class="bank">
	                                <a href="<?php echo url('bank'); ?>">银行卡管理</a>
	                            </div>
	                            <div class="bank_card" data-card-id='<?php echo $vo['bank']['id']; ?>'>
	                                <p><?php echo $vo['bank']['bank_user']; ?></p>
	                                <p><?php echo $vo['bank']['bank_number']; ?></p>
	                                <p>
	                                    <span><?php echo $vo['bank']['bank_name']; ?></span>
	                                    <span><?php echo $vo['bank']['bank_branch']; ?></span>
	                                </p>
	                            </div>
	                        </div>-->
	                        <button type="button" onclick="withdraw(<?php echo $vo['bouns_type']; ?>)">确定</button>
	                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                
                <!--提现记录-->
                <div class="fund_record">
                    <p>提现记录：</p>
                    <form class="record">
                        <table style='text-align:center;'>
                            <thead>
	                            <tr>
	                                <th width='30%' style='text-align:center;'>创建时间</th>
	                                <th width='10%' style='text-align:center;'>奖金种类</th>
	                                <th width='20%' style='text-align:center;'>金额</th>
	                                <th width='20%' style='text-align:center;'>转化为消费券</th>
	                                <th width='20%' style='text-align:center;'>审核状态</th>
	                            </tr>
                            </thead>
                            <tbody id='withdraw_list' data-count='<?php echo $count; ?>'>
	                            
                            </tbody>
                        </table>
                    </form>
                    <ul id='withdraw_page' class="page" style='width:auto;'>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<!--提现规则弹窗-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $page['name']; ?></h4>
            </div>
            <p class="line"></p>
            <div class="modal-body">
                <div><?php echo $page['content']; ?></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

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
<link rel="stylesheet" href="/static/layui/css/layui.css" media="all" />
<script type='text/javascript' src="/static/layui/layui.js"></script>
<script type='text/javascript' src="/static/ace/js/layer/layer.js"></script>
<script>
    vipNav(2)
</script>
<script type='text/javascript'>
// 判断买入数量输入格式
$('input[type=number]').on('input',function(){
	$(this).val($(this).val().match(/\d+\.?\d{0,2}/));
});

// 获取用户ID
var uid = $('.user_name').attr('data-uid');

// 执行提现
function withdraw(id){
	layer.confirm('确定要提现吗?',{
		btn: ['确定','关闭']
	},function(){
		var data = {
			uid:uid,
			bonus_type:id,
			number:$('#number_'+id).val(),
		}
		$.ajax({
			type:'post',
			url:'<?php echo url("do_withdraw"); ?>',
			data:data,
			success:function(ret){
				if(ret.code === 0){
					layer.alert(ret.msg);
				}else{
					layer.msg(ret.msg,{icon:ret.code,time:1500},function(){
						location.href = self.location.href;
					});
				}
			}
		});
	});
}

// 提现分页功能
var page;
$(document).ready(function(){
	// 读取提现分页
	withdraw_list();
	layui.use('laypage', function(){
	  var logpage = layui.laypage;
	  // 执行一个laypage实例
	  logpage.render({
	    elem: 'withdraw_page', 	// 注意，这里的 msg_page 是 ID，不用加 # 号
	    count: $('#withdraw_list').attr('data-count'), 			// 数据总数，从服务端得到
	    curr: page,
		limit: 8,
	    layout: ['count','prev','page','next','refresh', 'skip'],
	    jump: function(obj,first){
	      page = obj.curr;
	      if(!first){
	      	withdraw_list(page);
	      }
	    }
	  });
	});
});
// 调用提现分页
function withdraw_list(page){
	var data = {
		uid:uid,
		page:page,
	}
	var sell_html = '';
	$.ajax({
		type:'post',
		async:false, 
		url:'<?php echo url("withdraw_list"); ?>',
		data:data,
		success:function(ret){
			if(ret.code === 0){
				sell_html = '<tr class="no_data"><td colspan="5">暂无数据</td></tr>';
			}else{
				$.each(ret.sell,function(k,v){
					sell_html += '<tr><td>'+v.start_date+'</td>';
	                sell_html += '<td>'+v.bouns_type_text+'</td>';
	                sell_html += '<td>'+v.number+'</td>';
	                sell_html += '<td>'+v.vou_number+'</td>';
	                sell_html += '<td>'+v.sell_status_text+'</td></tr>';
				})
			}
			$('#withdraw_list').html(sell_html);
		}
	});
}
</script>
