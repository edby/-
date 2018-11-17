<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"D:\phpStudy\WWW\zcgj\public/../application/index\view\goods\index.html";i:1541753344;s:59:"D:\phpStudy\WWW\zcgj\application\index\view\common\top.html";i:1542416645;s:62:"D:\phpStudy\WWW\zcgj\application\index\view\common\banner.html";i:1541753592;}*/ ?>
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
                <a onclick="javascript:layer.msg('功能待开发',{time:1500,})" style="cursor:pointer" ><?php echo $vo['title']; ?></a>
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
            <input type="text" value="" id="search">
            <button type="button" class="search_btn" onclick="javascript:window.location.href='/index/goods/classify?search_text='+$('#search').val()">搜索</button>
        </div>
    </div>
</div>
<!---->


<main>
<!--banner图-->
<div id="myCarousel" class="carousel slide">
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
        <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $key = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$b_leader): $mod = ($key % 2 );++$key;?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $key-1; ?>" class="<?php echo $key==1?'active':''; ?>"></li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ol>
    <!-- 轮播（Carousel）项目 -->
    <div class="carousel-inner">
        <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $key = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$b): $mod = ($key % 2 );++$key;?>
        <div class="item <?php echo $key==1?' active':' '; ?>">
            <img src="<?php echo $b['link']; ?>" alt="Third slide">
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>

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

    <div class="headline">
        <div>优惠专区</div>
        <p>FAVORABLE ZONE</p>
    </div>
    <!--优惠专区显示区域-->
    <div class="cabinet1">
        <div class="show1">
            <a href="detail?id=<?php echo $preferential[0]['id']; ?>"><img src="<?php echo $preferential[0]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $preferential[0]['price']; ?></span> <span>积分</span></p>
                    <span>优惠券可以免费兑换</span>
                </div>
                <button type="button" onclick="buy(<?php echo $preferential[0]['id']; ?>)">立即购买</button>
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
                <a href="detail?id=<?php echo $feature[1]['id']; ?>"><img src="<?php echo $feature[1]['detail_pic']; ?>"></a>
                <div class="buyBox">
                    <div>
                        <p>售价：<span><?php echo $preferential[1]['price']; ?></span> <span>积分</span></p>
                        <span>优惠券可以免费兑换</span>
                    </div>
                    <button type="button" onclick="buy(<?php echo $preferential[1]['id']; ?>)">立即购买</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cabinet2">
        <div class="show3">
            <a href="detail?id=<?php echo $feature[2]['id']; ?>"><img src="<?php echo $feature[2]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $preferential[2]['price']; ?></span> <span>积分</span></p>
                    <span>优惠券可以免费兑换</span>
                </div>
                <button type="button" onclick="buy(<?php echo $preferential[2]['id']; ?>)">立即购买</button>
            </div>
        </div>
        <div class="show3">
            <a href="detail?id=<?php echo $feature[3]['id']; ?>"><img src="<?php echo $feature[3]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $preferential[3]['price']; ?></span> <span>积分</span></p>
                    <span>优惠券可以免费兑换</span>
                </div>
                <button type="button" onclick="buy(<?php echo $preferential[3]['id']; ?>)">立即购买</button>
            </div>
        </div>
        <div class="show3">
            <a href="detail?id=<?php echo $feature[4]['id']; ?>"><img src="<?php echo $feature[4]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $preferential[4]['price']; ?></span> <span>积分</span></p>
                    <span>优惠券可以免费兑换</span>
                </div>
                <button type="button" onclick="buy(<?php echo $preferential[4]['id']; ?>)">立即购买</button>
            </div>
        </div>
    </div>
    <p class="check_more"><a href="discounts.html">查看更多</a></p>
    <div class="headline">
        <div>特色专区</div>
        <p>SPECIAL AREA</p>
    </div>
    <!--特色专区-->
    <div class="cabinet1">
        <div class="show1">
            <a href="detail?id=<?php echo $feature[0]['id']; ?>"><img src="<?php echo $feature[0]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[0]['price']; ?></span> <span>消费券</span></p>
                </div>
                <button type="button" onclick="buy(<?php echo $feature[0]['id']; ?>)">立即购买</button>
            </div>
        </div>
        <div class="flex">
            <div class="show2">
                <a href="detail?id=<?php echo $feature[1]['id']; ?>"><img src="<?php echo $feature[1]['detail_pic']; ?>"></a>
                <div class="buyBox">
                    <div>
                        <p>售价：<span><?php echo $feature[1]['price']; ?></span> <span>消费券</span></p>
                    </div>
                    <button type="button" onclick="buy(<?php echo $feature[1]['id']; ?>)">立即购买</button>
                </div>
            </div>
            <div class="more_choices">
                <div>
                    <span><a href="feature.html">查看更多 >></a></span>
                    <p>More choices</p>
                </div>
            </div>
        </div>
    </div>
    <div class="cabinet2">
        <div class="show3">
            <a href="detail?id=<?php echo $feature[2]['id']; ?>"><img src="<?php echo $feature[2]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[2]['price']; ?></span> <span>消费券</span></p>
                </div>
                <button type="button" onclick="buy(<?php echo $feature[2]['id']; ?>)">立即购买</button>
            </div>
        </div>
        <div class="show3">
            <a href="detail?id=<?php echo $feature[3]['id']; ?>"><img src="<?php echo $feature[3]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[3]['price']; ?></span> <span>消费券</span></p>
                </div>
                <button type="button" onclick="buy(<?php echo $feature[3]['id']; ?>)">立即购买</button>
            </div>
        </div>
        <div class="show3">
            <a href="detail?id=<?php echo $feature[4]['id']; ?>"><img src="<?php echo $feature[4]['detail_pic']; ?>"></a>
            <div class="buyBox">
                <div>
                    <p>售价：<span><?php echo $feature[4]['price']; ?></span> <span>消费券</span></p>
                </div>
                <button type="button" onclick="buy(<?php echo $feature[4]['id']; ?>)">立即购买</button>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript" src="/static/ace/js/jquery.min.js" ></script>
<script type="text/javascript" src="/static/ace/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="/static/layui/layui.js"></script>
<script type="text/javascript" src="/static/ace/js/common.js" ></script>
<script type="text/javascript" src="/static/ace/js/store.js"></script>
{include file="common/bottom'}
<script>
    setNav(1);
    setStoreNav(0);
</script>

