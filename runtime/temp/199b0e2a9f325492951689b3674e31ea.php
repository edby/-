<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"D:\phpStudy\WWW\zcgj\public/../application/index\view\index\sell_det.html";i:1541985549;s:64:"D:\phpStudy\WWW\zcgj\application\index\view\common\indexTop.html";i:1542367104;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1542683181;}*/ ?>
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
	<ul class="payee payee2">
		<li>
			<p>
				<span>收款人：<?php if(empty($order['trade_sell']['real_name']) || (($order['trade_sell']['real_name'] instanceof \think\Collection || $order['trade_sell']['real_name'] instanceof \think\Paginator ) && $order['trade_sell']['real_name']->isEmpty())): ?>&nbsp;-&nbsp;<?php else: ?>&nbsp;<?php echo $order['trade_sell']['real_name']; ?>&nbsp;<?php endif; ?>(<?php echo $order['trade_sell']['account']; ?>)</span>
				<span>需要打款：<font class="cor_red"><?php echo $order['order_number']; ?></font></span>
				<span>收款状态：<font class="cor_red"><?php echo $order['order_status_text']; ?></font></span>
				<span>打款时间：<?php echo $order['pay_date']; ?></span>
			</p>
			<div class="clearfix" style="margin-top: 15px;">
				<?php if(empty($order['pay_time']) || (($order['pay_time'] instanceof \think\Collection || $order['pay_time'] instanceof \think\Paginator ) && $order['pay_time']->isEmpty())): ?>
					<div class="col-md-3" style='width:80%;'>打款人信息：-</div>
					<div class="col-md-2">
						<button data-toggle="modal" style='background:gray;cursor:default;'>查看凭证</button>
						<button style='background:gray;cursor:default;'>确认提交</button>
					</div>
				<?php else: ?>
					<div class="col-md-3" style='width:80%;'>打款人信息：<?php echo $order['pay_info']['pay_account']; ?></div>
					<div class="col-md-2">
						<button data-toggle="modal" data-target="#view">查看凭证</button>
						<?php if(empty($order['clear_deal_btn']) || (($order['clear_deal_btn'] instanceof \think\Collection || $order['clear_deal_btn'] instanceof \think\Paginator ) && $order['clear_deal_btn']->isEmpty())): ?>
							<button onclick='deal(<?php echo $order['id']; ?>,<?php echo $order['trade_sell_ids']; ?>)'>确认提交</button>
						<?php else: ?>
							<button style='background:gray;cursor:default;'>确认提交</button>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</li>
	</ul>
</div>	

<!--查看凭证-->
<div class="modal fade" id="view" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">查看凭证</h4>
			</div>
			<div class="modal-body">
				<img src="<?php echo $order['pay_info']['pay_pic']; ?>" class="view_img"/>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn_red2" data-dismiss="modal">取消</button>
			</div>
		</div>
	</div>
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
<script type="text/javascript" src="/static/ace/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/ace/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/ace/js/common.js"></script>
<script type='text/javascript' src="/static/ace/js/layer/layer.js"></script>

<link rel="stylesheet" href="/static/layui/css/layui.css" media="all" />
<script type='text/javascript' src="/static/layui/layui.all.js"></script>
<script>
	setNav(0);
</script>
<script type='text/javascript'>
// 提交匹配订单
function deal(id,trade_sell_ids){
	layer.confirm('确定提交吗?',{
		btn: ['确定','关闭']
	},function(){
		$.ajax({
			type:'post',
			url:'<?php echo url("trade_deal"); ?>',
			data:{id:id,trade_sell_ids:trade_sell_ids},
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
	});
}
</script>
