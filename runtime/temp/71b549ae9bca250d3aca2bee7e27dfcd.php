<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"D:\phpStudy\WWW\zcgj\public/../application/index\view\goods\car.html";i:1541126359;s:59:"D:\phpStudy\WWW\zcgj\application\index\view\common\top.html";i:1541126397;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\bottom.html";i:1541122096;}*/ ?>
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
            <label>商品</label>
            <p>购物车</p>
            <span>BEST</span>
        </div>
        <span>抓紧时间去结算哦</span>
    </div>
    <div class="shopCart_subhead">
        <div class="shopCart_nav">
            <div class="allItem">全部商品</div>
            <div class="clearing">
                <span>已选商品（不含运费）</span>
                <p class="red"><span>200</span>消费券</p>
                <button type="button" onclick="clearing()">结算</button>
            </div>
        </div>
    </div>
    <!--顶部全选-->
    <div class="shopNav">
        <input type="checkbox" name="all" id="navAll1">
        <label for="navAll1" class="navAll1"></label>
        <span class="ctrl1">全选</span>
        <span class="ctrl2">商品信息</span>
        <span class="ctrl3">单价</span>
        <span class="ctrl4">数量</span>
        <span class="ctrl5">金额</span>
        <span class="ctrl6">操作</span>
    </div>

    <!--商品详情-->
    <div class="clear_shop">
        <div class="clearShop_box">
            <input type="checkbox" name="shop" id="shop1" value="0">
            <label for="shop1" class="shop1"></label>
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
                    <button type="button" onclick="cart_menus(this)">-</button>
                    <input type="number" id="shopNum1" min="1" max="5" value="1">
                    <button type="button" onclick="cart_add(this)">+</button>
                </div>
                <span>限购5件</span>
            </div>
            <div class="total_price">
                <span>200</span>
                <dd>消费券</dd>
            </div>
            <button type="button" class="delete" onclick="del()">删除</button>
        </div>
    </div>
    <!--商品详情-->
    <div class="clear_shop">
        <div class="clearShop_box">
            <input type="checkbox" name="shop" id="shop2" value="1">
            <label for="shop2" class="shop2"></label>
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
                    <button type="button" onclick="cart_menus(this)">-</button>
                    <input type="number" id="shopNum2" min="1" max="5" value="1">
                    <button type="button" onclick="cart_add(this)">+</button>
                </div>
                <span>限购5件</span>
            </div>
            <div class="total_price">
                <span>200</span>
                <dd>消费券</dd>
            </div>
            <button type="button" class="delete" onclick="del()">删除</button>
        </div>
    </div>

    <!--底部全选-->
    <div class="total_clear">
        <div class="totalBox">
            <div class="totalBox_left">
                <input type="checkbox" name="all" id="navAll2">
                <label for="navAll2" class="navAll2"></label>
                <span>全选</span>
            </div>
            <div class="totalBox_right">
                <span class="shopNum">已选商品<b>1</b>件</span>
                <span>合计（不含运费）：</span>
                <div class="clear_price">
                    <span>200</span>
                    <dd>消费券</dd>
                </div>
                <button type="button" onclick="clearing()">结算</button>
            </div>
        </div>
    </div>

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
		setNav(0);
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
<script type="text/javascript" src="/static/ace/js/shopCart.js"></script>
<script>
    setNav(1);
</script>

