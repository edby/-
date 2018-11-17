<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"D:\phpStudy\WWW\zcgj\public/../application/index\view\index\index.html";i:1542426238;s:64:"D:\phpStudy\WWW\zcgj\application\index\view\common\indexTop.html";i:1542367104;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1542013201;}*/ ?>
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
		<div class="trans" data-id='<?php echo $uid; ?>'>
			<ul class="container tran_blc">
				<li class="buy" data-toggle="modal" data-target="#buy">
					<p>买入</p>
					<p>P U R C H A S E</p>
				</li>
				<!-- <li class="reser_buy" data-toggle="modal" data-target="#reser_buy"> -->
				<li onclick='continued()'>
					<p>预约买入</p>
					<p>RESERVATION LIST</p>
				</li>
				<li class="sell" data-toggle="modal" data-target="#sell">
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
                <a href = "../goods/detail?id=<?php echo $pre[0]['id']; ?>">
				<img src="<?php echo $pre[0]['detail_pic']; ?>">
                </a>
				<div class="buyBox">
					<div>
						<p>售价：<span><?php echo $pre[0]['price']; ?>积分</span></p>
						<span>优惠券可以免费兑换</span>
					</div>
					<button type="button" onclick="buy(<?php echo $pre[0]['id']; ?>)">立即购买</button>
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
                    <a href = "../goods/detail?id=<?php echo $pre[1]['id']; ?>">
                        <img src="<?php echo $pre[1]['detail_pic']; ?>">
                    </a>
					<div class="buyBox">
						<div>
							<p>售价：<span><?php echo $pre[1]['price']; ?></span> <span>积分</span></p>
							<span>优惠券可以免费兑换</span>
						</div>
						<button type="button" onclick="buy(<?php echo $pre[1]['id']; ?>)">立即购买</button>
					</div>
				</div>
			</div>
		</div>
		<div class="cabinet2">
			<div class="show3">
                <a href = "../goods/detail?id=<?php echo $pre[2]['id']; ?>">
                    <img src="<?php echo $pre[2]['detail_pic']; ?>">
                </a>
				<div class="buyBox">
					<div>
						<p>售价：<span><?php echo $pre[2]['price']; ?></span> <span>积分</span></p>
						<span>优惠券可以免费兑换</span>
					</div>
					<button type="button" onclick="buy(<?php echo $pre[2]['id']; ?>)">立即购买</button>
				</div>
			</div>
			<div class="show3">
                <a href = "../goods/detail?id=<?php echo $pre[3]['id']; ?>">
                    <img src="<?php echo $pre[3]['detail_pic']; ?>">
                </a>
				<div class="buyBox">
					<div>
						<p>售价：<span><?php echo $pre[3]['price']; ?></span> <span>积分</span></p>
						<span>优惠券可以免费兑换</span>
					</div>
					<button type="button" onclick="buy(<?php echo $pre[3]['id']; ?>)">立即购买</button>
				</div>
			</div>
			<div class="show3">
                <a href = "../goods/detail?id=<?php echo $pre[4]['id']; ?>">
                    <img src="<?php echo $pre[4]['detail_pic']; ?>" >
                </a>
				<div class="buyBox">
					<div>
						<p>售价：<span><?php echo $pre[4]['price']; ?></span> <span>积分</span></p>
						<span>优惠券可以免费兑换</span>
					</div>
					<button type="button" onclick="buy(<?php echo $pre[4]['id']; ?>)">立即购买</button>
				</div>
			</div>
		</div>
		<p class="check_more">
			<a href="discounts.html">查看更多</a>
		</p>
		<!--申请买入订单-->
		<div class="headline" style="margin-bottom: 30px;" id='buy_count' data-count='<?php echo $count['buy']; ?>'>
			<h1><span>申请买入订单</span></h1>
			<p>APPLICATION FOR PURCHASE ORDER</p>
		</div>
		<div class="container">
			<table class="table-responsive table going_order">
				<tr>
					<th>买入编号</th>
					<th>申请人</th>
					<th>金额</th>
					<th>状态</th>
					<th>创建时间</th>
				</tr>
				<tbody id='buy_list'>
					
				</tbody>
			</table>
			<!--分页-->
			<ul class="page clearfix" id='buy_page' style='width:auto;text-align:center;'>
				
			</ul>
		</div>
		<!--申请卖出订单-->
		<div class="headline" style="margin-bottom: 30px;" id='sell_count' data-count='<?php echo $count['sell']; ?>'>
			<h1><span>申请卖出订单</span></h1>
			<p>APPLICATION FOR SALE ORDER</p>
		</div>
		<div class="container">
			<table class="table-responsive table going_order">
				<tr>
					<th>卖出编号</th>
					<th>申请人</th>
					<th>奖金类型</th>
					<th>金额</th>
					<th>状态</th>
					<th>创建时间</th>
				</tr>
				<tbody id='sell_list'>
					
				</tbody>
			</table>
			<!--分页-->
			<ul class="page clearfix" id='sell_page' style='width:auto;text-align:center;'>
				
			</ul>
		</div>
		<!--进行中的订单-->
		<div class="headline" style="margin-bottom: 30px;" id='order_count' data-count='<?php echo $count['order']; ?>'>
			<h1><span>进行中的订单</span></h1>
			<p>PROGRESS MIDDLE CLASS</p>
		</div>
		<div class="container">
			<table class="table-responsive table going_order">
				<tr>
					<th>订单号</th>
					<th>类型</th>
					<th>款类</th>
					<th>金额</th>
					<th>创建时间</th>
					<th>状态</th>
					<th>最迟付款时间</th>
					<th>其他</th>
				</tr>
				<tbody id='order_list'>
					
				</tbody>
			</table>
			<!--分页-->
			<ul class="page clearfix" id='order_page' style='width:auto;text-align:center;'>
				
			</ul>
		</div>
		
		<!--买入弹窗-->
		<div class="modal fade" id="buy" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">买入</h4>
					</div>
					<div class="modal-body" style='text-align:center;'>
						<!--<input id='buy_number' name='number' placeholder="请输入买入金额" class="modol_ipt" />-->
						<select id='buy_number' name='number'>
							<option class="modol_ipt" value=''>请选择</option>
							<?php if(is_array($data['buy_num']) || $data['buy_num'] instanceof \think\Collection || $data['buy_num'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['buy_num'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
								<option class="modol_ipt" value='<?php echo $vo['number']; ?>'><?php echo $vo['number']; ?></option>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<p>积分必须是2000的整数倍</p>
					</div>
					<div class="modal-footer">
                		<button type="button" class="btn_red" onclick='trade_buy()'>提交</button>
						<button type="button" class="btn_red2" data-dismiss="modal">取消</button>
					</div>
				</div>
			</div>
		</div>
		<!--预约买入-->
		<div class="modal fade" id="reser_buy" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">预约买入</h4>
					</div>
					<div class="modal-body">
						<div class="clearfix time_sel">
							<span data-timing='1'>1天</span>
							<span data-timing='2'>2天</span>
							<span data-timing='3'>3天</span>
							<span data-timing='4'>4天</span>
							<span data-timing='5'>5天</span>
							<span class="time_sel_act" data-timing='0'>关闭</span>
						</div>
						<p>积分必须是2000的整数倍</p>
					</div>
					<div class="modal-footer">
                		<button type="button" class="btn_red" onclick='set_timing()'>确定</button>
						<button type="button" class="btn_red2" data-dismiss="modal">取消</button>
					</div>
				</div>
			</div>
		</div>
		<!--卖出-->
		<div class="modal fade" id="sell" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">卖出</h4>
					</div>
					<div class="modal-body">
						<!--<div class="bank clearfix">
							<span>银行卡号：</span>
							<select>
								<option>601382370011907</option>
								<option>601382370011907</option>
								<option>601382370011907</option>
							</select>
						</div>-->
						<div class="account clearfix">
							<span>提现账户：</span>
							<select id='bonus_type' name='bonus'>
								<option value='0'>请选择</option>
								<?php if(is_array($bonus) || $bonus instanceof \think\Collection || $bonus instanceof \think\Paginator): $i = 0; $__LIST__ = $bonus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
									<option value='<?php echo $vo['value']; ?>'><?php echo $vo['key']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<input id='sell_number' name='number' placeholder="金额" />
						</div>
						<div class="alert">温馨提示：不同奖金提现条件不同，请及时了解</div>
					</div>
					<div class="modal-footer">
                		<button type="button" class="btn_red" onclick='trade_sell()'>提交</button>
						<button type="button" class="btn_red2" data-dismiss="modal">取消</button>
					</div>
				</div>
			</div>
		</div>
<script type="text/javascript" src="/static/ace/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/ace/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/ace/js/common.js"></script>
<link rel="stylesheet" href="/static/layui/css/layui.css" media="all" />
<script type='text/javascript' src="/static/layui/layui.js"></script>
<script type="text/javascript" src="/static/ace/js/store.js"></script>
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
function continued(){
	layer.alert('功能待开发');
}
</script>

<script type='text/javascript'>
    // 实例化layui
    layui.use(['layer', 'form'], function(){
        var layer = layui.layer,form = layui.form;
    });
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
$('.time_sel span').click(function(){
	$(this).addClass('time_sel_act');
	$('.time_sel span').not($(this)).removeClass('time_sel_act');

});

// 点击买入
function trade_buy(){
	layer.confirm('确定要买入吗?',{
		btn: ['确定','关闭']
	},function(){
		var data = {
			uid:$('.trans').data('id'),
			number:$('#buy_number').val(),
		}
		$.ajax({
			type:'post',
			url:'<?php echo url("trade_buy"); ?>',
			data:data,
			success:function(ret){
				if(ret.code === 0){
					if(ret.url){
						layer.msg(ret.msg,{icon:ret.code,time:1500},function(){
							location.href = ret.url;
						});
					}else{
						layer.msg(ret.msg);
					}
				}else{
					layer.msg(ret.msg,{icon:ret.code,time:1500},function(){
						location.href = self.location.href;
					});
				}
			}
		});
	});
}

// 点击设置预约
function set_timing(){
	// 获取预约天数
	if($('.time_sel span').hasClass('time_sel_act')){
		var timing = $('.time_sel_act').data('timing');
	}
	var data = {
		uid:$('.trans').data('id'),
		timing:timing
	}
	$.ajax({
		type:'post',
		url:'<?php echo url("set_timing"); ?>',
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

// 点击卖出
function trade_sell(){
	layer.confirm('确定要卖出吗?',{
		btn: ['确定','关闭']
	},function(){
		var data = {
			uid:$('.trans').data('id'),
			bonus_type:$('#bonus_type').val(),
			number:$('#sell_number').val(),
		}
		$.ajax({
			type:'post',
			url:'<?php echo url("trade_sell"); ?>',
			data:data,
			success:function(ret){
				if(ret.code === 0){
					if(ret.url){
						layer.msg(ret.msg,{icon:ret.code,time:1500},function(){
							location.href = ret.url;
						});
					}else{
						layer.msg(ret.msg);
					}
				}else{
					layer.msg(ret.msg,{icon:ret.code,time:1500},function(){
						location.href = self.location.href;
					});
				}
			}
		});
	});
}


var page;
var uid = $('.trans').data('id');
$(document).ready(function(){
	// 读取买入列表分页
	buy_list();
	layui.use('laypage', function(){
	  var logpage = layui.laypage;
	  // 执行一个laypage实例
	  logpage.render({
	    elem: 'buy_page', 	// 注意，这里的 msg_page 是 ID，不用加 # 号
	    count: $('#buy_count').attr('data-count'), 			// 数据总数，从服务端得到
	    curr: page,
		limit: 8,
	    layout: ['count','prev','page','next','refresh', 'skip'],
	    jump: function(obj,first){
	      page = obj.curr;
	      if(!first){
	      	buy_list(page);
	      }
	    }
	  });
	});
	
	// 读取卖出列表分页
	sell_list();
	layui.use('laypage', function(){
	  var logpage = layui.laypage;
	  // 执行一个laypage实例
	  logpage.render({
	    elem: 'sell_page', 	// 注意，这里的 msg_page 是 ID，不用加 # 号
	    count: $('#sell_count').attr('data-count'), 			// 数据总数，从服务端得到
	    curr: page,
		limit: 8,
	    layout: ['count','prev','page','next','refresh', 'skip'],
	    jump: function(obj,first){
	      page = obj.curr;
	      if(!first){
	      	sell_list(page);
	      }
	    }
	  });
	});
	
	// 读取进行中的列表分页
	order_list();
	layui.use('laypage', function(){
	  var logpage = layui.laypage;
	  // 执行一个laypage实例
	  logpage.render({
	    elem: 'order_page', 	// 注意，这里的 msg_page 是 ID，不用加 # 号
	    count: $('#order_count').attr('data-count'), 			// 数据总数，从服务端得到
	    curr: page,
		limit: 8,
	    layout: ['count','prev','page','next','refresh', 'skip'],
	    jump: function(obj,first){
	      page = obj.curr;
	      if(!first){
	      	order_list(page);
	      }
	    }
	  });
	});
});

// 调用买入分页
function buy_list(page){
	var data = {
		uid:uid,
		page:page,
	}
	var buy_html = '';
	$.ajax({
		type:'post',
		async:false, 
		url:'<?php echo url("buy_list"); ?>',
		data:data,
		success:function(ret){
			if(ret.code === 0){
				buy_html = '<tr class="no_data"><td colspan="5">暂无数据</td></tr>';
			}else{
				$.each(ret.buy,function(k,v){
					buy_html += '<tr><td>'+v.id+'</td>';
					buy_html += '<td>'+v.account+'</td>';
					buy_html += '<td>'+v.number+'</td>';
					buy_html += '<td class="'+v.matching_class+'">'+v.matching_text+'</td>';
					buy_html += '<td>'+v.start_date+'</td></tr>';
				})
			}
			$('#buy_list').html(buy_html);
		}
	});
}

// 调用卖出分页
function sell_list(page){
	var data = {
		uid:uid,
		page:page,
	}
	var sell_html = '';
	$.ajax({
		type:'post',
		async:false, 
		url:'<?php echo url("sell_list"); ?>',
		data:data,
		success:function(ret){
			if(ret.code === 0){
				sell_html = '<tr class="no_data"><td colspan="6">暂无数据</td></tr>';
			}else{
				$.each(ret.sell,function(k,v){
					sell_html += '<tr><td>'+v.id+'</td>';
					sell_html += '<td>'+v.account+'</td>';
					sell_html += '<td>'+v.bonus_name+'</td>';
					sell_html += '<td>'+v.number+'</td>';
					sell_html += '<td class="'+v.matching_class+'">'+v.matching_text+'</td>';
					sell_html += '<td>'+v.start_date+'</td></tr>';
				})
			}
			$('#sell_list').html(sell_html);
		}
	});
}

// 调用进行中的分页
function order_list(page){
	var data = {
		uid:uid,
		page:page,
	}
	var order_html = '';
	$.ajax({
		type:'post',
		async:false, 
		url:'<?php echo url("order_list"); ?>',
		data:data,
		success:function(ret){
			if(ret.code === 0){
				order_html = '<tr class="no_data"><td colspan="8">暂无数据</td></tr>';
			}else{
				$.each(ret.order,function(k,v){
					order_html += '<tr><td>'+v.order+'</td>';
					order_html += '<td class="'+v.trade_type_class+'" style="cursor:default">'+v.trade_type_text+'</td>';
					order_html += '<td class="'+v.trade_type_class+'">'+v.class_text+'</td>';
					order_html += '<td>'+v.order_number+'</td>';
					order_html += '<td>'+v.create_date+'</td>';
					order_html += '<td class="cor_red">'+v.order_status_text+'</td>';
					order_html += '<td>'+v.deadline+'</td>';
					if(!v.class || v.class === 1){
						order_html += '<td class="'+v.trade_type_class+'" style="cursor:pointer" onclick="trade_page('+v.trade_type+','+v.id+')">详情</td></tr>';
					}else{
						if(v.open_click){
							order_html += '<td class="'+v.trade_type_class+'" style="cursor:pointer" onclick="trade_page('+v.trade_type+','+v.id+')">'+v.detail_text+'</td></tr>';
						}else{
							order_html += '<td class="'+v.trade_type_class+'">'+v.detail_text+'</td></tr>';
						}
					}
				})
			}
			$('#order_list').html(order_html);
		}
	});
}

// 查看跳转进行中的详情
function trade_page(trade_type,id){
	switch(trade_type){
		case 1:
			location.href = '<?php echo url("sell_det"); ?>?id='+id;
			break;
		case 2:
			location.href = '<?php echo url("buy_det"); ?>?id='+id;
			break;
	}
}

</script>