<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\phpStudy\WWW\zcgj\public/../application/index\view\goods\select_addr.html";i:1542246236;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>选择地址</title>
</head>
<body>
<?php if(is_array($addrs) || $addrs instanceof \think\Collection || $addrs instanceof \think\Paginator): $key = 0; $__LIST__ = $addrs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($key % 2 );++$key;?>
<div class="rec_details">
    <span>姓名：<?php echo $a['username']; ?></span>
    <span>电话：<?php echo $a['tel']; ?></span>
    <span>收货地址：<?php echo $a['address']; ?></span>
</div>
<?php endforeach; endif; else: echo "" ;endif; ?>
</body>
</html>