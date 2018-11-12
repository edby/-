<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:75:"D:\phpStudy\WWW\zcgj\public/../application/admin\view\trade\trade_sell.html";i:1541638919;s:59:"D:\phpStudy\WWW\zcgj\application\admin\view\common\top.html";i:1522230592;s:62:"D:\phpStudy\WWW\zcgj\application\admin\view\common\header.html";i:1530500030;s:63:"D:\phpStudy\WWW\zcgj\application\admin\view\common\sidebar.html";i:1532051872;s:62:"D:\phpStudy\WWW\zcgj\application\admin\view\common\bottom.html";i:1490663526;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title><?php if(isset($info['name'])): ?><?php echo $info['name']; ?> - <?php endif; ?> <?php echo $pagename; ?> -  <?php echo config('WEB_SITE_NAME'); ?>管理后台</title>
<meta name="description" content=" <?php echo config('WEB_SITE_DESCRIPTION'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<link rel="stylesheet" href="/static/ace/css/bootstrap.css" />
<link rel="stylesheet" href="/static/ace/css/font-awesome.css" />
<link rel="stylesheet" href="/static/ace/css/ace-fonts.css" />
<link rel="stylesheet" href="/static/ace/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
<script src="/static/ace/js/ace-extra.js"></script>
<script type="text/javascript">window.jQuery || document.write("<script src='/static/ace/js/jquery.js'>"+"<"+"/script>");</script>
<script type="text/javascript">if('ontouchstart' in document.documentElement) document.write("<script src='/static/ace/js/jquery.mobile.custom.js'>"+"<"+"/script>");</script>
<style type="text/css">
input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"] {
  line-height: inherit;
}
.help-inline{
  line-height: 32px;
}
select{
	height: 34px;
}
.main-container .table tr td {
	vertical-align: middle;
}
.main-container .table tr td a{
	margin-right:10px;
}
#preview{
  height: 120px;
  width: auto;
}
</style>
<style type="text/css">
.search {text-indent:0.5em;}

.main-container .table tr td {
  vertical-align: middle;
}
.main-container .table tr td a{
  margin-right:10px;
}

/* 卖出状态开始 */
.trade_status_link {width:100px;height:26px;line-height:26px;text-align:center;color:white;border-radius:10px;background-color:yellowgreen;box-shadow:yellowgreen 1px 1px 2px;}
.trade_status_active {width:100px;height:26px;line-height:26px;text-align:center;color:white;border-radius:10px;background-color:deepskyblue;box-shadow:deepskyblue 1px 1px 2px;}
.trade_status_visited {width:100px;height:26px;line-height:26px;text-align:center;color:white;border-radius:10px;background-color:red;box-shadow:red 1px 1px 2px;}
.trade_status_hover {width:100px;height:26px;line-height:26px;text-align:center;color:white;border-radius:10px;background-color:green;box-shadow:green 1px 1px 2px;}
/* 卖出状态结束 */

</style>
</head>
<body class="no-skin">
<div id="navbar" class="navbar navbar-default">
  <div class="navbar-container" id="navbar-container">
  <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar"> <span class="sr-only">Toggle sidebar</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <div class="navbar-header pull-left"> <a href="<?php echo url('Index/index'); ?>" class="navbar-brand"> <small><?php echo \think\Config::get('WEB_SITE_NAME'); ?>网站管理后台 </small> </a> </div>
    <div class="navbar-buttons navbar-header pull-right" role="navigation">
      <ul class="nav ace-nav">
        <li class="light-blue"> <a data-toggle="dropdown" href="#" class="dropdown-toggle"> <img class="nav-user-photo" src="/static/ace/avatars/user.png" />
        <span class="user-info"><small>欢迎你</small><?php echo $_SESSION['think']['username']; ?></span> <i class="ace-icon fa fa-caret-down"></i> </a>
          <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li> <a href="<?php echo url('Index/repwd'); ?>"> <i class="ace-icon fa fa-cog"></i> 修改密码 </a></li>
            <li> <a href="<?php echo url('Publics/logout'); ?>"> <i class="ace-icon fa fa-power-off"></i> 退出后台 </a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="main-container" id="main-container"> <div id="sidebar" class="sidebar ">
  <div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
      <button class="btn btn-success">
      <i class="ace-icon fa fa-group"></i>
      </button>
      <button class="btn btn-info">
      <i class="ace-icon fa fa-list"></i>
      </button>
      <button class="btn btn-warning">
      <i class="ace-icon fa fa-arrow-circle-up"></i>
      </button>
      <button class="btn btn-danger">
      <i class="ace-icon fa fa-cog"></i>
      </button>
    </div>
    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
      <span class="btn btn-success"></span>
      <span class="btn btn-info"></span>
      <span class="btn btn-warning"></span>
      <span class="btn btn-danger"></span>
    </div>
  </div>
  <ul class="nav nav-list">
    <?php if(is_array($sidebar) || $sidebar instanceof \think\Collection || $sidebar instanceof \think\Paginator): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      <li <?php if($vo['name'] == $rule2): ?>class="open active"<?php endif; ?>><a href="<?php echo url('/'.$vo['name']); ?>" <?php if($vo['count'] != 0): ?>class="dropdown-toggle"<?php endif; ?>><i class="menu-icon fa fa-<?php echo $vo['icon']; ?>"></i><span class="menu-text"> <?php echo $vo['title']; ?> </span><b class="arrow <?php if($vo['count'] != 0): ?>fa fa-angle-down<?php endif; ?>"></b></a>
        <b class="arrow"></b>
        <ul class="submenu">
          <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
          <li <?php if($sub['name'] == $rule): ?>class="active"<?php endif; ?>><a href="<?php echo url('/'.$sub['name']); ?>"><i class="menu-icon fa fa-caret-right"></i> <?php echo $sub['title']; ?> </a><b class="arrow"></b></li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
  </div>
</div>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo url('Index/index'); ?>"><?php echo config('WEB_SITE_NAME'); ?></a> </li>
          <li class="active"><?php echo $pagename; ?></li>
        </ul>
      </div>
      <div class="page-content">
        <div class="page-header">
          <h1> <?php echo $pagename; ?> <small> <i class="ace-icon fa fa-angle-double-right"></i> 查询出<?php echo $data['count']; ?>条数据 </small> </h1>
        </div>
        <!-- /.page-header -->
        <div class="row">
          <div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
            <div class="row">
              <div class="col-xs-12" style="margin-bottom:10px;">
                <form action="<?php echo url('trade_sell'); ?>" method="get" class="form-inline" role="form">
                  
                  <div class="form-group">
                    <label>关键词</label>
                    <input name="keywords" type="text" class="form-control search" placeholder="卖出人手机号" />
                  </div>&nbsp;&nbsp;
                  
                  <div class="form-group">
                  	<label>奖金类型</label>
                    <select name="bonus_type" class="form-control" <!--onchange='look_trade_type(this)'-->>
                    	<option value="">全部</option>
                      <?php if(is_array($bouns_type) || $bouns_type instanceof \think\Collection || $bouns_type instanceof \think\Paginator): $i = 0; $__LIST__ = $bouns_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['value']; ?>" <?php if($get_bonus_type == $vo['value']): ?>selected='selected'<?php endif; ?>><?php echo $vo['key']; ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                  </div>&nbsp;&nbsp;
                  
                  <div class="form-group">
                  	<label>交易状态</label>
                    <select name="sell_status" class="form-control" <!--onchange='look_trade_type(this)'-->>
                    	<option value="">全部</option>
                      <?php if(is_array($trade_status) || $trade_status instanceof \think\Collection || $trade_status instanceof \think\Paginator): $i = 0; $__LIST__ = $trade_status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['value']; ?>" <?php if($get_trade_status == $vo['value']): ?>selected='selected'<?php endif; ?>><?php echo $vo['key']; ?></option>
                      <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                  </div>&nbsp;&nbsp;
                  
                  <button type="submit" class="btn btn-sm btn-primary">查询</button>
                  <button type="reset" class="btn btn-sm btn-danger hidden-xs" style="float:right;margin-right:10px;">清空查询条件</button>
                </form>
              </div>
              <div class="col-xs-12">
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th class="center">卖出ID</th>
                      <th>卖出人账号</th>
                      <th>卖出类型</th>
                      <th>卖出数量</th>
                      <th>卖出状态</th>
                      <th>卖出开始时间</th>
                      <th>卖出结束时间</th>
                      <th>关联买入ID</th>
                      <th>支付图片</th>
                      <th>关联订单ID</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(is_array($data['list']) || $data['list'] instanceof \think\Collection || $data['list'] instanceof \think\Paginator): $k = 0; $__LIST__ = $data['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                      <tr>
                        <td class="center"><?php echo $vo['id']; ?></td>
                        <td><?php echo $vo['account']; ?></td>
                        <td><?php echo $vo['bonus_type_text']; ?></td>
                        <td><?php echo $vo['number']; ?></td>
                        <td><div class='<?php echo $vo['sell_status_button']; ?>'><?php echo $vo['sell_status_text']; ?></div></td>
                        <td><?php echo $vo['start_date']; ?></td>
                        <td><?php echo $vo['end_date']; ?></td>
                        <td><?php if(!(empty($vo['trade_buy_id']) || (($vo['trade_buy_id'] instanceof \think\Collection || $vo['trade_buy_id'] instanceof \think\Paginator ) && $vo['trade_buy_id']->isEmpty()))): ?><?php echo $vo['trade_buy_id']; else: ?>-<?php endif; ?></td>
                        <td><?php if(!(empty($vo['pay_pic']) || (($vo['pay_pic'] instanceof \think\Collection || $vo['pay_pic'] instanceof \think\Paginator ) && $vo['pay_pic']->isEmpty()))): ?>-<?php else: ?><img src='<?php echo $vo['pay_pic']; ?>' /><?php endif; ?></td>
                        <td><?php if(!(empty($vo['order_id']) || (($vo['order_id'] instanceof \think\Collection || $vo['order_id'] instanceof \think\Paginator ) && $vo['order_id']->isEmpty()))): ?><?php echo $vo['order_id']; else: ?>-<?php endif; ?></td>
                      </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                  </tbody>
                </table>
                <div style="width:100%;margin: 0 auto; text-align:center;">
                  <ul class="pagination" >
                    <?php echo $data['page']; ?>
                  </ul>
                </div>
              </div>
              <!-- /.span -->
            </div>
            <!-- /.row --> 
            <!-- PAGE CONTENT ENDS --> 
          </div>
          <!-- /.col --> 
        </div>
        <!-- /.row --> 
      </div>
      <!-- /.page-content --> 
    </div>
  </div>
  <!-- /.main-content -->
  <div class="footer">
    <div class="footer-inner"> 
      <!-- #section:basics/footer -->
      <div class="footer-content"> <span class="bigger-120"> <span class="blue bolder"><?php echo config('WEB_SITE_NAME'); ?> </span><?php echo WEB_VERSION; ?>版 </span></div>
      <!-- /section:basics/footer --> 
    </div>
  </div>
  <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a> </div>
<!-- /.main-container --> 
<!-- basic scripts --> 
<script type="text/javascript">if($(window).width()<1024)  $("#sidebar").addClass('menu-min');</script>
<script src="/static/ace/js/bootstrap.js"></script>
<script src="/static/ace/js/ace/ace.js"></script> 
<script src="/static/ace/js/ace/ace.sidebar.js"></script> 
<script src="/static/ace/js/layer/layer.js"></script>
<script type="text/javascript">
  $('a[href="/Admin/Trade/trade_sell"]').parents().filter('li').addClass('open active');
  <?php if(input('get.keywords')): ?>
    $('input[name="keywords"]').val('<?php echo $_GET["keywords"]; ?>');
  <?php endif; if(is_numeric(input('get.trade_status'))): ?>
    $('select[name="trade_status"]').val(<?php echo $_GET['trade_status']; ?>);
  <?php endif; if(is_numeric(input('get.trade_type'))): ?>
    $('select[name="trade_type"]').val(<?php echo $_GET['trade_type']; ?>);
  <?php endif; ?>
</script>
<script type="text/javascript">
jQuery(function($) {
  //清除查询条件
  $(document).on('click', 'button:reset',function() {
    location.href = '<?php echo url('trade_sell'); ?>';
  }); 
});

//// 查看挂卖状态
//function look_trade_status(trade_status){
//	var val = $(trade_status).val();
//	var url = '<?php echo url("index"); ?>?get_trade_status=' + val;
//	window.location.href = url;
//}
//
//// 查看交易类型
//function look_trade_type(trade_type){
//	var val = $(trade_type).val();
//	var url = '<?php echo url("index"); ?>?get_trade_type=' + val;
//	window.location.href = url;
//}
</script>
</body>
</html>
