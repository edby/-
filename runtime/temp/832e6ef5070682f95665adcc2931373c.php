<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"D:\phpStudy\WWW\zcgj\public/../application/index\view\goods\classify.html";i:1541238383;s:59:"D:\phpStudy\WWW\zcgj\application\index\view\common\top.html";i:1541157962;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1541407061;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>全部分类</title>
    <link rel="stylesheet" href="/static/ace/css/common.css" />
    <link rel="stylesheet" href="/static/ace/css/zhongyu.css" />
    <link rel="stylesheet" href="/static/ace/css/bootstrap.css" />
    <link rel="stylesheet" href="/static/ace/css/store.css" />
    <link rel="stylesheet" href="/static/ace/css/item.css" />
    <link rel="stylesheet" href="/static/ace/css/clear.css" />
    <link rel="stylesheet" href="/static/ace/css/shopCart.css" />
    <link rel="stylesheet" href="/static/ace/css/userCenter.css">
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
<!--商城导航栏-->
<div class="store_nav">
    <div class="store_nav_box">
        <ul class="store_nav_r">
            <li><a href="store.html">商城首页</a></li>
            <li><a href="allSale.html">全部分类</a></li>
            <li><a href="activate.html">激活券</a></li>
            <li><a href="discounts.html">优惠专区</a></li>
            <li><a href="feature.html">特色专区</a></li>
        </ul>
        <div>
            <input type="text" id="search">
            <button type="button" class="search_btn" onclick="searchBtn()">搜索</button>
        </div>
    </div>
</div>
<!---->


<main>
    <!--banner图-->
    <div id="myCarousel" class="carousel slide">
        <!-- 轮播（Carousel）指标 -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <!-- 轮播（Carousel）项目 -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="/static/ace/img/banner1.png" alt="First slide">
            </div>
            <div class="item">
                <img src="/static/ace/img/banner1.png" alt="Second slide">
            </div>
            <div class="item">
                <img src="/static/ace/img/banner1.png" alt="Third slide">
            </div>
        </div>
        <!-- 轮播（Carousel）导航 -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!--分类列表-->
    <div class="headline">
        <!--<ul class="all-sale">
            <li><a href="#">生活/办公</a></li>
            <li><a href="#">数码/手机</a></li>
            <li><a href="#">食品/百货</a></li>
            <li><a href="#" class="red">烟酒/副食</a></li>
            <li><a href="#">鞋靴/箱包</a></li>
            <li><a href="#">男装/女装</a></li>
            <li><a href="#">工具/五金</a></li>
            <li><a href="#">眼镜/手表</a></li>
            <li><a href="#">美妆/洗护</a></li>
            <li><a href="#" style="font-weight: 600;">...</a></li>
        </ul>-->
    	<ul class="all-sale">
	        <?php if(is_array($classify) || $classify instanceof \think\Collection || $classify instanceof \think\Paginator): $$key = 0; $__LIST__ = $classify;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$classify): $mod = ($$key % 2 );++$$key;?>
	    		<li><a href = "classify?classify=<?php echo $classify['id']; ?>"><?php echo $classify['name']; ?></a></li>
	        <?php endforeach; endif; else: echo "" ;endif; ?>
            <li><a href="#" style="font-weight: 600;">...</a></li>
            <li><a href="#" style="font-weight: 600;">...</a></li>
    	</ul>
    </div>
    <!--商品展示-->
    <div class="container">
        <?php if(is_array($goods_detail) || $goods_detail instanceof \think\Collection || $goods_detail instanceof \think\Paginator): $key = 0; $__LIST__ = $goods_detail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($key % 2 );++$key;?>
		    <div class="show3 col-md-4">
		        <a href="detail?id=<?php echo $goods['id']; ?>"><img src="<?php echo $goods['detail_pic']; ?>"></a>
		        <div class="buyBox">
		            <div>
		                <p>售价：<span><?php echo $goods['price']; ?></span> <span>消费券</span></p>
		            </div>
		            <button type="button" >立即购买</button>
		        </div>
		    </div>
        
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
   <center> <?php echo $pages; ?>  </center>
    <!--分页-->
    <!--<ul class="page">
        <li><a href="#"><</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">...</a></li>
        <li><a href="#">></a></li>
    </ul>-->
</main>


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
<script type="text/javascript" src="/static/ace/js/jquery.min.js" ></script>
<script type="text/javascript" src="/static/ace/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="/static/layui/layui.js"></script>
<script type="text/javascript" src="/static/ace/js/common.js" ></script>
<script type="text/javascript" src="/static/ace/js/store.js"></script>
<script>
    setNav(1);
    setStoreNav(1);
</script>
<!--<script type="text/javascript">
	function get_appoint_goods(type_id)
	{
		if(isNaN(type_id))
		{
			return false;
		}
		var data = {
			'type':1,
			'classify':type_id
		}
		$.ajax({
			type:"post",
			data:data,
			url:"get_goods_by_type",
			success:function(result){
				result = JSON.parse(result);
//				console.log(result['data']['goods']['data']);
//					console.log(result);
					$(".cabinet2").html('');	
				var html = '';
				for(var i = 0;i<result['data']['goods']['data'].length;i++){
					if(parseInt(i/3) == 0){
						html = '<div class="show3">'+
							'<img src="'+
//							result['data']['goods']['data'][i]['picture']+
							'" onclick="item()"><div class="buyBox"><div><p>售价：<span>'+
							result['data']['goods']['data'][i]['original_price']+
							'</span> <span>消费券</span></p></div><button type="button" onclick="buy()">立即购买</button></div></div>';
						$(".cabinet2").append(html);
					}
//					console.log(result['data']['goods']['data'][i]['original_price']);
				}
				console.log(result['data']['page']);
				$(".cabinet2").after(result['data']['page']);
			},
			error:function(result){
				result = JSON.parse(result);
				console.log(result);
			},
			async:true
		});
		
	}
</script>-->

