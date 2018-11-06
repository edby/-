<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"D:\phpStudy\WWW\zcgj\public/../application/index\view\goods\clear.html";i:1541407612;s:59:"D:\phpStudy\WWW\zcgj\application\index\view\common\top.html";i:1541126397;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1541407061;}*/ ?>
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
</head>
<body>
<!--头部-->
<div class="top_nav">
    <div class="container clearfix">
        <div class="top_nav_l">
            <img src="/static/ace/img/logo_zc.png"/>
        </div>
        <ul class="top_nav_r clearfix">
            <li><a href="#">首页</a></li>
            <li><a href="#">众成商城</a></li>
            <li><a href="#">交易中心</a></li>
            <li><a href="#">中心矿机</a></li>
        </ul>
        <div class="accout">
            <span>ZC</span>
            张三
            <div class="accout_menu">
                <p><a href="#">会员中心</a></p>
                <p><a href="#">退出登录</a></p>
            </div>
        </div>
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
    <div class="cabinet_head">
        <div>
            <label>结算</label>
            <p>提交订单</p>
            <span>BEST</span>
        </div>
        <span>抓紧时间去结算哦</span>
    </div>

    <div class="clear_subhead">
        <div class="clear_nav">
            <div class="clearItem">结算订单</div>
        </div>
    </div>

    <!--订单信息-->
    <div class="clear_shop">
        <div class="clearShop_box">
            <img src="/static/ace/img/show1.jpg">
            <div class="shop_name">
                <p>法国梧桐Realmadrid红酒</p>
                <span>红酒美味无限</span>
            </div>
            <div class="shop_price">
                <s>
                    <span>400</span>
                    <span>消费券</span>
                </s>
                <p>
                    <span>200</span>
                    <span>消费券</span>
                </p>
            </div>
            <div class="shop_num">
                <div>
                    <button type="button" onclick="clear_menus()">-</button>
                    <input type="number" id="clearNum" min="1" max="5" value="1">
                    <button type="button" onclick="clear_add()">+</button>
                </div>
                <span>限购5件</span>
            </div>
            <div class="total_price">
                <span>200</span>
                <dd>消费券</dd>
            </div>
        </div>
    </div>

    <!--收货信息-->
    <div class="recipients">
        <div class="rec_box">
            <div class="rec_title">
                <span>收货信息：</span>
                <img src="/static/ace/img/next.png">
            </div>
            <div class="rec_details">
                <span>张三</span>
                <span>13300000001</span>
                <span>河南省 郑州市 金水区花园路35号院</span>
                <a href="#">编辑</a>
            </div>
        </div>
        <div class="freight">
            <span>运费：</span>
            <p><span>10</span>元</p>
        </div>
    </div>
    <div class="line"></div>

    <!--底部合计-->
    <div class="figure">
        <div class="figure_box">
            <span class="figure_total">合计：</span>
            <p>
                <span class="figure_price">200</span>
                <span>消费券</span>
            </p>
            <span>（包含运费）</span>
            <button type="button" onclick="submit_order()">提交订单</button>
        </div>
    </div>
</main>


<script type="text/javascript" src="/static/ace/js/jquery.min.js" ></script>
<script type="text/javascript" src="/static/ace/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="/static/layui/layui.js"></script>
<script type="text/javascript" src="/static/ace/js/common.js" ></script>
<script type="text/javascript" src="/static/ace/js/store.js"></script>
<script type="text/javascript" src="/static/ace/js/clear.js"></script>

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
<script>
    setNav(1);
</script>

