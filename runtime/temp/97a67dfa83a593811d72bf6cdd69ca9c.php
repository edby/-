<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"D:\phpStudy\WWW\zcgj\public/../application/index\view\index\buy_det.html";i:1542021934;s:64:"D:\phpStudy\WWW\zcgj\application\index\view\common\indexTop.html";i:1542367104;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1542683181;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>首页</title>
<link rel="stylesheet" href="/static/ace/css/common.css" />
<link rel="stylesheet" href="/static/ace/css/zhongyu.css" />
<link rel="stylesheet" href="/static/ace/css/bootstrap.css" />
</head>

<body>
<!--头部-->
<div class="top_nav">
	<div class="container clearfix">
		<div class="top_nav_l">
			<img src="/static/ace/img/logo_zc.png" />
		</div>
		<ul class="top_nav_r clearfix">
			<?php if(is_array($sidebar) || $sidebar instanceof \think\Collection || $sidebar instanceof \think\Paginator): $key = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
				<li>
					<?php if(($key == 3) OR ($key == 4)): ?>
					<a onclick="javascript:layer.msg('功能待开发',{time:1500})" style="cursor:pointer" ><?php echo $vo['title']; ?></a>
					<?php else: ?>
					<a href="/<?php echo $vo['name']; ?>" ><?php echo $vo['title']; ?></a>
					<?php endif; ?>
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
		
<script type="text/javascript" src="/static/ace/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/ace/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/ace/js/common.js"></script>
<script type='text/javascript' src="/static/ace/js/layer/layer.js"></script>

<link rel="stylesheet" href="/static/layui/css/layui.css" media="all" />
<script type='text/javascript' src="/static/layui/layui.all.js"></script>
<!--匹配订单-->
<div class="container" style="min-height: 580px;">
	<div class="order_tit clearfix">
		<h1>匹配订单</h1>
		<span class="order_tit_1">订单详情</span>
		<span class="order_tit_2">BEST</span>
		<span class="order_tit_3">查看订单详情</span>
	</div>
	<div class="payer">
		<p class="clearfix">
			<span class="col-md-3">打款人：<?php echo $order['real_name']; ?>(<?php echo $order['account']; ?>)</span>
			<span class="col-md-3">总预付款：<?php echo $order['order_number']; ?></span>
			<span class="col-md-3">付款状态：<font class="cor_red"><?php echo $order['order_status_text']; ?></font></span>
			<span class="col-md-3">备注：<?php if(empty($order['remarks']) || (($order['remarks'] instanceof \think\Collection || $order['remarks'] instanceof \think\Paginator ) && $order['remarks']->isEmpty())): ?>无<?php else: ?><?php echo $order['remarks']; endif; ?></span>
		</p>
		<div class="payer_sm">打款最迟时间：<?php echo $order['last_pay_date']; ?> 每天早上8点~12点完成并需要确认</div>
	</div>
	<ul class="payee">
		<?php if(is_array($order['trade_sell']) || $order['trade_sell'] instanceof \think\Collection || $order['trade_sell'] instanceof \think\Paginator): $i = 0; $__LIST__ = $order['trade_sell'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<li>
				<p>
					<span>收款人：<?php if(empty($vo['real_name']) || (($vo['real_name'] instanceof \think\Collection || $vo['real_name'] instanceof \think\Paginator ) && $vo['real_name']->isEmpty())): ?>&nbsp;-&nbsp;<?php else: ?>&nbsp;<?php echo $vo['real_name']; ?>&nbsp;<?php endif; ?>(<?php echo $vo['account']; ?>)</span>
					<span>创建时间：<?php echo $vo['start_date']; ?></span>
				</p>
				<?php switch($vo['pay']['user_pay_type']): case "1": ?>
					<div class="clearfix">
						<div class="col-md-2" style="margin-top: 15px;">选择付款方式：</div>
						<div class="col-md-6 pay_imgs">
							<div class="ali_wx">
								<span>
									<img src="/static/ace/img/order_wxz.png" data-type='1' />
									支付宝：<?php echo $vo['pay']['alipay_accout']; ?>
								</span>
								<span>
									<img src="/static/ace/img/order_wxz.png" data-type='2' />
									微信号：<?php echo $vo['pay']['wechat_accout']; ?>
								</span>
							</div>
							<div>
								<img src="/static/ace/img/order_wxz.png" data-type='3' />
								银行卡：<?php echo $vo['pay']['bank_name']; ?>&nbsp;&nbsp;<?php echo $vo['pay']['bank_user']; ?>&nbsp;&nbsp;<?php echo $vo['pay']['bank_number']; ?>
							</div>
						</div>
						<div class="col-md-2" style="position: relative;">
							<input accept="image/*" type="file" name="file" class="filed" id='upload_pay_<?php echo $vo['id']; ?>'>
							<img src="/static/ace/img/upload.png" class="upload_btn" id='view_pay_<?php echo $vo['id']; ?>' />
						</div>
						<div class="col-md-2"><button onclick='pay(event,<?php echo $vo['id']; ?>,<?php echo $order['trade_buy_id']; ?>,<?php echo $order['id']; ?>)'>确认提交</button></div>
					</div>
					<div class="need_pay">需要付款：<font class="cor_red"><?php echo $vo['number']; ?>(未付款)</font></div>
					<?php break; case "2": ?>
					<div class="clearfix">
						<div class="col-md-2" style="margin-top: 15px;">选择付款方式：</div>
						<div class="col-md-6 pay_imgs">
							<div class="ali_wx">
								<?php switch($vo['pay']['pay_type']): case "1": ?>
									<span>
										<img src="/static/ace/img/<?php echo $vo['pay']['img_src']; ?>" data-type='1' />
										支付宝：<?php echo $vo['pay']['alipay_accout']; ?>
									</span>
									<?php break; case "2": ?>
									<span>
										<img src="/static/ace/img/<?php echo $vo['pay']['img_src']; ?>" data-type='2' />
										微信号：<?php echo $vo['pay']['wechat_accout']; ?>
									</span>
									<?php break; case "3": ?>
									<span>
										<img src="/static/ace/img/<?php echo $vo['pay']['img_src']; ?>" data-type='3' />
										银行卡：<?php echo $vo['pay']['bank_name']; ?>&nbsp;&nbsp;<?php echo $vo['pay']['bank_user']; ?>&nbsp;&nbsp;<?php echo $vo['pay']['bank_number']; ?>
									</span>
									<?php break; endswitch; ?>
							</div>
						</div>
						<div class="col-md-2" style="position: relative;">
							<input accept="image/*" name="file" class="filed" <?php if($vo['sell_status'] == ''): ?>id='upload_pay_<?php echo $vo['id']; ?>'<?php else: ?>style='cursor:default;'<?php endif; ?>>
							<img src="<?php echo $vo['pay']['pay_pic']; ?>" class="upload_btn" id='view_pay_<?php echo $vo['id']; ?>' />
						</div>
						<div class="col-md-2"><button style='background: gray;'>已提交</button></div>
					</div>
					<div class="need_pay">需要付款：<font style='color:gray;'><?php echo $vo['number']; ?>(已付款)</font></div>
					<?php break; endswitch; ?>
			</li>
			<script>
				layui.use('upload', function(){
					var upload = layui.upload;
					var upload_pay = '#upload_pay_'+<?php echo $vo['id']; ?>;
					var buyer_id = <?php echo $order['buyer_id']; ?>;
					//执行实例
					var uploadInst = upload.render({
						elem: upload_pay //绑定元素
						,url: '<?php echo url("upload_pay"); ?>' //上传接口
						,data: {type: 'buy_pay',buyer_id:buyer_id}
						,done: function(ret){
					    	if(ret.code === 0){
								layer.msg(ret.msg);
							}else{
								$('#view_pay_'+<?php echo $vo['id']; ?>).attr('src', ret.url);
							}
				    	}
					});
				});
			</script>
		<?php endforeach; endif; else: echo "" ;endif; ?><br />
	</ul>
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

<script type='text/javascript'>
setNav(0);
$('.payee li .col-md-6 img').click(function(){
	$(this).attr('src','/static/ace/img/order_xz.png');
	$(this).parents('li').find('.col-md-6 img').not($(this)).attr('src','/static/ace/img/order_wxz.png');
})


// 提交支付
var type;
function pay(e,id,trade_buy_id,order_id){
	var dom = $(e.target).parents(".clearfix");
	var type = dom.find(".pay_imgs img[src='/static/ace/img/order_xz.png']").data("type");
	var pay_pic = $('#view_pay_'+id).attr('src');
	var data = {
		id:id,
		type:type,
		pay_pic:pay_pic,
		trade_buy_id:trade_buy_id,
		order_id:order_id
	}
	$.ajax({
		type:'post',
		url:'<?php echo url("pay_sell"); ?>',
		data:data,
		success:function(ret){
			if(ret.code === 0){
				layer.msg(ret.msg);
			}else{
				layer.msg(ret.msg,{icon:ret.code,time:1500},function(){
					location.href = self.location.href;
				});
			}
		}
	});
}

</script>
