<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"D:\phpStudy\WWW\zcgj\public/../application/index\view\user\userCenter.html";i:1542021244;s:59:"D:\phpStudy\WWW\zcgj\application\index\view\common\top.html";i:1542021420;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1542013201;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>全部分类</title>
    <link rel="stylesheet" href="/static/ace/css/common.css" />
    <link rel="stylesheet" href="/static/ace/css/zhongyu.css" />
    <link rel="stylesheet" href="/static/ace/css/bootstrap.css" />
    <link rel="stylesheet" href="/static/ace/css/store.css" />
    <!--<link rel="stylesheet" href="/static/ace/css/item.css" />-->
    <link rel="stylesheet" href="/static/ace/css/clear.css" />
    <link rel="stylesheet" href="/static/ace/css/shopCart.css" />
    <link rel="stylesheet" href="/static/ace/css/userCenter.css">
</head>
<body>
<!--悬浮窗-->
<div class="suspend" id = "floating_window">
    <a href="/index/goods/car" title="购物车" class="shop">
        <img src="/static/ace/img/shop.png">
    </a>
    <a href="/index/goods/my_promotion" title="个人中心" class="mine">
        <img src="/static/ace/img/my.png">
    </a>
    <a href="#" title="回顶部" class="backTop">
        <img src="/static/ace/img/top.png">
    </a>
</div>
<!--头部-->
<div class="top_nav">
    <div class="container clearfix">
        <div class="top_nav_l">
            <img src="/static/ace/img/logo_zc.png"/>
        </div>
        <ul class="top_nav_r clearfix">
            <?php if(is_array($sidebar) || $sidebar instanceof \think\Collection || $sidebar instanceof \think\Paginator): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li>
                <?php if(($key == 2) OR ($key == 3)): ?>
                <a onclick="javascript:layer.alert('功能待开发',{time:2000,title:'温馨提示'})" style="cursor:pointer" ><?php echo $vo['title']; ?></a>
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
	                <p><a href="<?php echo url('Publics/userreg'); ?>">注册</a></p>
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
<!--商城导航栏-->
<div class="store_nav">
    <div class="store_nav_box">
        <ul class="store_nav_r">
            <li><a href="/index/goods/index">商城首页</a></li>
            <li><a href="/index/goods/classify">全部分类</a></li>
            <li><a href="activate.html">激活券</a></li>
            <li><a href="/index/goods/preferential">优惠专区</a></li>
            <li><a href="feature.html">特色专区</a></li>
        </ul>
        <div>
            <input type="text" id="search">
            <button type="button" class="search_btn" onclick="searchBtn()">搜索</button>
        </div>
    </div>
</div>
<!---->

<style type='text/css'>
.file_up {cursor:pointer;}
</style>
<main>
    <div class="cabinet_head">
        <div>
            <label>个人中心</label>
            <p>我的订单</p>
            <span>BEST</span>
        </div>
        <span>查看个人信息</span>
    </div>
    <div class="order_form">
        <ul class="nav nav-tabs">
            <li <?php if($type == null): ?> class="active" <?php endif; ?>>
                <a href="my_promotion">全部订单</a>
            </li>
            <li <?php if($type == 1): ?> class="active" <?php endif; ?> >
                <a href="my_promotion?type=1">待付款</a>
            </li>
            <li <?php if($type == 2): ?> class="active" <?php endif; ?>>
                <a href="my_promotion?type=2">待发货</a>
            </li>
            <li <?php if($type == 3): ?> class="active" <?php endif; ?>>
                <a href="my_promotion?type=3">已收货</a>
            </li>
            <li <?php if($type == 4): ?> class="active" <?php endif; ?>>
                <a href="my_promotion?type=4">已完成</a>
            </li>
        </ul>

        <div class="tab-content">
            <!--全部订单-->
            <div class="tab-pane fade in active" id="all">
            <?php if(is_array($order) || $order instanceof \think\Collection || $order instanceof \think\Paginator): $key = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$o): $mod = ($key % 2 );++$key;?>
                <div class="indent">
                    <div class="indent_box">
                        <div class="indent_left">
                            <img src="<?php echo $o['detail_pic']; ?>">
                            <div class="indent_detail">
                                <p class=""><?php echo $o['name']; ?></p>
                                <p>
                                    <span><?php echo $o['money']; ?></span>
                                    <span>消费券</span>
                                </p>
                                <p>
                                    数量
                                    <span><?php echo $o['g_number']; ?></span>
                                </p>
                                <p>
                                    时间：
                                    <span><?php echo date("Y-m-d H:i:s",$o['create_time']); ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="indent_center">
                            <p>
                                订单号：
                                <span><?php echo $o['order_number']; ?></span>
                            </p>
                        </div>
                        <div class="indent_right">
                            <div></div>
                            <div>
                                <?php switch($o['order_status']): case "1": ?><input type="button" class="indentBtn_on" onclick="use_indent(this)" value="待支付" disabled><?php break; case "2": ?><input type="button" class="indentBtn_on" onclick="use_indent(this)" value="待发货" disabled><?php break; case "3": ?><input type="button" class="indentBtn_on" onclick="use_indent(this)" value="已签收" disabled><?php break; case "4": ?><input type="button" class="indentBtn_on" onclick="use_indent(this)" value="已完成" disabled><?php break; endswitch; ?>
                            </div>
                        </div>
                    </div>
                </div>
             <?php endforeach; endif; else: echo "" ;endif; ?>
                <center><?php echo $page; ?></center>
            </div>
        </div>
    </div>
    <div class="cabinet_head">
        <div>
            <label>入住商城</label>
            <p>申请入驻</p>
            <span>BEST</span>
            <small class="vip_rank">
                我的会员等级：
                <small>
                    省代
                    <img src="/static/ace/img/moon.png">
                    <img src="/static/ace/img/moon.png">
                    <img src="/static/ace/img/moon.png">
                </small>
            </small>
        </div>
        <span>县代以上才能成为商家哦</span>
    </div>
    <div class="enter_store">
        <ul class="com_detail">
            <li>
                <div>
                    <p>公司法人：</p>
                    <input id='contact' type="text" name="contact" placeholder="请填写公司法人">
                </div>
            </li>
            <li>
                <div>
                    <p>法人证件：</p>
                    <input id='contact_file' type="number" name="contact_file" placeholder="请填写法人身份证号">
                </div>
            </li>
            <li>
                <div>
                    <p>经营范围：</p>
                    <input id='business' type="text" name="business" placeholder="请填写经营范围">
                </div>
            </li>
            <li>
                <div>
                    <p>联系电话：</p>
                    <input id='tel' type="number" name="tel" placeholder="请填写手机号码">
                </div>
            </li>
            <li id="com_address">
                <div>
                    <p>公司详细地址</p>
                    <input id='address' type="text" name="address" placeholder="请填写详细地址">
                </div>
            </li>
        </ul>
        <div class="up_permit">
            <p>请上传营业执照：</p>
            <div class="permit">
                <div class="file_up" id='upload'>
                    <input id='license' type="hidden" name="license" class="fileInput" />
                    <img src="/static/ace/img/up.png" class="up_img">
                    <img src="" id="frontImg">
                </div>
                <span>上传营业执照</span>
            </div>
            <input id='uid' type='hidden' name='uid' value='<?php echo $uid; ?>' />
            <button type="button" onclick="apply_for()">提交申请</button>
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
<script type="text/javascript" src="/static/ace/js/jquery.min.js" ></script>
<script type="text/javascript" src="/static/ace/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="/static/layui/layui.js"></script>
<script type="text/javascript" src="/static/ace/js/common.js" ></script>
<script type="text/javascript" src="/static/ace/js/store.js"></script>
<script type="text/javascript" src="/static/ace/js/userCenter.js"></script>
<script>
    setNav(1);
</script>

<script type="text/javascript" src="/static/ace/js/layer/layer.js"></script>
<link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
<script type="text/javascript" src="/static/layui/layui.js"></script>
<script type='text/javascript'>
// 上传营业执照
layui.use('upload', function(){
  var upload = layui.upload;
  var uid = $('#uid').val();
  //执行实例
  var uploadInst = upload.render({
    elem: '#upload' //绑定元素
    ,url: "<?php echo url('User/upload'); ?>" //上传接口
    ,data: {type: 'license',uid:uid}
    ,done: function(res){
      // console.log(res)
      //上传完毕回调
      if(res.code == 0){
        layer.msg(res.msg, {icon: res.code,time: 1500});
      }else{
        //返回路径
        $("input[name=license]").val(res.url);
        //给IMG返回路径
        $('.up_img').hide();
        $('#frontImg').show();
        $("#frontImg").attr("src",res.url)
        layer.msg(res.msg, {icon: res.code,time: 1500});
      }
    }
  });
});

//提交申请
function apply_for() {
    var data = {
    	uid:$('#uid').val(),
    	contact:$('#contact').val(),
    	contact_file:$('#contact_file').val(),
    	business:$('#business').val(),
    	tel:$('#tel').val(),
    	address:$('#address').val(),
    	license:$('#license').val()
    }
	$.ajax({
		type:'post',
		url:'<?php echo url("usercenter"); ?>',
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
}
</script>


