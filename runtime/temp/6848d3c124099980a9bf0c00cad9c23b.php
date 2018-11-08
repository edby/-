<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"D:\phpStudy\WWW\zcgj\public/../application/index\view\index\index.html";i:1541465241;s:64:"D:\phpStudy\WWW\zcgj\application\index\view\common\indexTop.html";i:1541205422;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1541407061;}*/ ?>
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
	                <p><a href="<?php echo url('Publics/userreg'); ?>">注册</a></p>
	            </div>
	        </div>
	    <?php else: ?>
	    	<div class="accout">
	            <span>ZC</span>
	            <?php echo $account; ?>
	            <div class="accout_menu">
	                <p><a href="<?php echo url('userCenter'); ?>">会员中心</a></p>
	                <p><a href="<?php echo url('Publics/logout'); ?>">退出登录</a></p>
	            </div>
	        </div>
	    <?php endif; ?>
	</div>
</div>
		
		<!---->
		<div class="top_ban">
			<div class="top_ban_t">
				<span>创新 金融 财富</span>
			</div>
			<div class="top_ban_m">
				激活会员，开启财富之路
			</div>
			<div class="top_ban_b">
				Vigorously-active member, Fuyu Emoto road
			</div>
		</div>
		<!---->
		<div class="trans">
			<ul class="container tran_blc">
				<li class="buy">
					<p>买入</p>
					<p>P U R C H A S E</p>
				</li>
				<li class="reser_buy">
					<p>预约买入</p>
					<p>RESERVATION LIST</p>
				</li>
				<li class="sell">
					<p>卖出</p>
					<p>D I S C O V E R Y</p>
				</li>
			</ul>
		</div>
		<!--优惠专区-->
		<div class="headline">
			<div>优惠专区</div>
			<p>FAVORABLE ZONE</p>
		</div>
		<div class="cabinet1">
        <div class="show1">
            <img src="<?php echo $preferential[0]['detail_pic']; ?>" onclick="item()">
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $preferential[0]['price']; ?></span> <span>积分</span></p>
                    <span>优惠券可以免费兑换</span>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
        <div class="flex">
            <div class="best">
                <div class="best_title">BEST</div>
                <div class="best_name">法国红酒</div>
                <div class="best_subhead">
                    <p>Most</p>
                    <p>beautiful sunset</p>
                </div>
                <span>优惠劵可以直接免费兑换哦！</span>
            </div>
            <div class="show2">
                <img src="<?php echo $preferential[1]['detail_pic']; ?>" onclick="item()">
                <div class="buyBox">
                    <div>
                        <p>售价：<span><?php echo $preferential[1]['price']; ?></span> <span>积分</span></p>
                        <span>优惠券可以免费兑换</span>
                    </div>
                    <button type="button" onclick="buy()">立即购买</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cabinet2">
        <div class="show3">
            <img src="<?php echo $preferential[2]['detail_pic']; ?>" onclick="item()">
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $preferential[2]['price']; ?></span> <span>积分</span></p>
                    <span>优惠券可以免费兑换</span>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
        <div class="show3">
            <img src="<?php echo $preferential[3]['detail_pic']; ?>" onclick="item()">
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $preferential[3]['price']; ?></span> <span>积分</span></p>
                    <span>优惠券可以免费兑换</span>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
        <div class="show3">
            <img src="<?php echo $preferential[4]['detail_pic']; ?>" onclick="item()">
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $preferential[4]['price']; ?></span> <span>积分</span></p>
                    <span>优惠券可以免费兑换</span>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
    </div>
    <p class="check_more"><a href="goods/preferential">查看更多</a></p>
		<!--进行中的订单-->
		<div class="headline" style="margin-bottom: 30px;">
			<h1><span>进行中的订单</span></h1>
			<p>PROGRESS MIDDLE CLASS</p>
		</div>
		<div class="container">
			<table class="table-responsive table going_order">
				<tr>
					<th>订单号</th>
					<th>匹配卖出订单</th>
					<th>金额</th>
					<th>创建时间</th>
					<th>状态</th>
					<th>最迟付款时间</th>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>201815895944</td>
					<td>1600.00</td>
					<td>2019-5-10 12:12</td>
					<td class="cor_red">未付款</td>
					<td>2018-10-17 12:20</td>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>201815895944</td>
					<td>1600.00</td>
					<td>2019-5-10 12:12</td>
					<td class="cor_red">未付款</td>
					<td>2018-10-17 12:20</td>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>201815895944</td>
					<td>1600.00</td>
					<td>2019-5-10 12:12</td>
					<td class="cor_red">未付款</td>
					<td>2018-10-17 12:20</td>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>201815895944</td>
					<td>1600.00</td>
					<td>2019-5-10 12:12</td>
					<td class="cor_red">未付款</td>
					<td>2018-10-17 12:20</td>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>201815895944</td>
					<td>1600.00</td>
					<td>2019-5-10 12:12</td>
					<td class="cor_red">未付款</td>
					<td>2018-10-17 12:20</td>
				</tr>
			</table>
			<!--分页-->
			<ul class="page clearfix">
				<li><a href="#"><</a></li>
				<li><a href="#" class="page_act">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">></a></li>
			</ul>
		</div>
		<!--申请订单列表-->
		<div class="headline" style="margin-bottom: 30px;">
			<h1><span>申请订单列表</span></h1>
			<p>APPLICATION SUMMARY TABLE</p>
		</div>
		<div class="container">
			<table class="table-responsive table going_order">
				<tr>
					<th>申请订单编号</th>
					<th>申请人</th>
					<th>金额</th>
					<th>数量</th>
					<th>状态</th>
					<th>创建时间</th>
					<th>其他</th>					
				</tr>
				<tr>
					<td>201815895944</td>
					<td>生生</td>
					<td>1600.00</td>
					<td>6688</td>
					<td class="cor_red">未付款</td>
					<td>2019-5-10 12:12</td>					
					<td>详情</td>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>生生</td>
					<td>1600.00</td>
					<td>6688</td>
					<td class="cor_red">未付款</td>
					<td>2019-5-10 12:12</td>					
					<td>详情</td>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>生生</td>
					<td>1600.00</td>
					<td>6688</td>
					<td class="cor_red">未付款</td>
					<td>2019-5-10 12:12</td>					
					<td>详情</td>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>生生</td>
					<td>1600.00</td>
					<td>6688</td>
					<td class="cor_red">未付款</td>
					<td>2019-5-10 12:12</td>					
					<td>详情</td>
				</tr>
				<tr>
					<td>201815895944</td>
					<td>生生</td>
					<td>1600.00</td>
					<td>6688</td>
					<td class="cor_red">未付款</td>
					<td>2019-5-10 12:12</td>					
					<td>详情</td>
				</tr>
			</table>
			<!--分页-->
			<ul class="page clearfix">
				<li><a href="#"><</a></li>
				<li><a href="#" class="page_act">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">></a></li>
			</ul>
		</div>

<script type="text/javascript" src="/static/ace/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/ace/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/ace/js/common.js"></script>

		<!--底部-->
		<div class="foot">
			<img src="/static/ace/img/logo_zc.png" class="foot_img" />
			<div class="foot_b">@2018.zhongchengguoji</div>
		</div>
		<!--优惠券-->
		<div class="coupon">
			<img src="/static/ace/img/yhq.png" class="yhq"/>
			<img src="/static/ace/img/close.png" class="cls" onclick="cls()"/>
		</div>
		<div class="mask"></div>
	</body>
	<script>
		function cls(){
			$('.coupon,.mask').hide();
		}
		var stat = document.cookie.split(";")[0].split("=")[1];
		setTimeout(function(){
			document.cookie="sata=0";
		},1500);
		console.log(document.cookie)
		if(stat == 1){
			$('.coupon,.mask').fadeIn();
		}else{
			$('.coupon,.mask').hide();
		}
	</script>
</html>
