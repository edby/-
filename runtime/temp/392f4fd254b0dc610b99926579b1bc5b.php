<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"D:\phpStudy\WWW\zcgj\public/../application/index\view\goods\feature.html";i:1541398393;s:59:"D:\phpStudy\WWW\zcgj\application\index\view\common\top.html";i:1541157962;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1541407061;}*/ ?>
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

    <div class="cabinet_head">
        <div>
            <label>折扣</label>
            <p>特色专区</p>
            <span>BEST</span>
        </div>
        <span>优惠折扣尽在特色专区！</span>
    </div>
    <!--折扣-->
    <div class="cabinet3">
        <div class="show4">
        	<a href="detail?id=<?php echo $feature[0]['id']; ?>"><img src="<?php echo $feature[0]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[0]['price']; ?></span> <span>消费券</span></p>
                    <s>原价<?php echo $feature[0]['original_price']; ?>消费券</s>
                    <span class="off">5折</span>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
        <div class="show4">
        	<a href="detail?id=<?php echo $feature[1]['id']; ?>"><img src="<?php echo $feature[1]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[1]['price']; ?></span> <span>消费券</span></p>
                    <s>原价<?php echo $feature[1]['original_price']; ?>消费券</s>
                    <span class="off">5折</span>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
    </div>
    <div class="cabinet4">
        <div class="show5">
        	<a href="detail?id=<?php echo $feature[2]['id']; ?>"><img src="<?php echo $feature[2]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div class="flex4">
                    <div>
                        <label>超级折扣日：</label>
                        <s>原价<?php echo $feature[1]['price']; ?>消费券</s>
                    </div>
                    <p>
                        现价5折优惠价：
                        <span><?php echo $feature[2]['original_price']; ?></span>
                        <span>消费券</span>
                    </p>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
    </div>

    <div class="cabinet_head">
        <div>
            <label>特惠</label>
            <p>特色专区</p>
            <span>BEST</span>
        </div>
        <span>优惠折扣尽在特色专区！</span>
    </div>
    <!--特惠-->
    <div class="cabinet1">
        <div class="show1">
        	<a href="detail?id=<?php echo $feature[3]['id']; ?>"><img src="<?php echo $feature[3]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[3]['price']; ?></span> <span>消费券</span></p>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
        <div class="flex">
            <div class="show2">
        	<a href="detail?id=<?php echo $feature[4]['id']; ?>"><img src="<?php echo $feature[4]['detail_pic']; ?>"></a>
                <div class="buyBox">
                    <div>
                        <p>售价：<span><?php echo $feature[4]['price']; ?></span> <span>消费券</span></p>
                    </div>
                    <button type="button" onclick="buy()">立即购买</button>
                </div>
            </div>
            <div class="more_choices">
                <div>
                    <span>Make shopping</span>
                    <p>happier</p>
                </div>
            </div>
        </div>
    </div>
    <div class="cabinet2">
        <div class="show3">
        	<a href="detail?id=<?php echo $feature[5]['id']; ?>"><img src="<?php echo $feature[5]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[5]['price']; ?></span> <span>消费券</span></p>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
        <div class="show3">
        	<a href="detail?id=<?php echo $feature[6]['id']; ?>"><img src="<?php echo $feature[6]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[6]['price']; ?></span> <span>消费券</span></p>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
        <div class="show3">
        	<a href="detail?id=<?php echo $feature[7]['id']; ?>"><img src="<?php echo $feature[7]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[7]['price']; ?></span> <span>消费券</span></p>
                </div>
                <button type="button" onclick="buy()">立即购买</button>
            </div>
        </div>
    </div>
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
    <center>
    	<?php echo $page; ?>
    </center>
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
<script type="text/javascript" src="/static/ace/js/common.js" ></script>
<script type="text/javascript" src="/static/ace/js/store.js"></script>
<script>
    setNav(1);
    setStoreNav(4);
</script>

