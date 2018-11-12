<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:75:"D:\phpStudy\WWW\zcgj\public/../application/admin\view\shop\goods_order.html";i:1542012408;s:59:"D:\phpStudy\WWW\zcgj\application\admin\view\common\top.html";i:1522230592;s:62:"D:\phpStudy\WWW\zcgj\application\admin\view\common\header.html";i:1530500030;s:63:"D:\phpStudy\WWW\zcgj\application\admin\view\common\sidebar.html";i:1542003834;s:62:"D:\phpStudy\WWW\zcgj\application\admin\view\common\bottom.html";i:1490663526;}*/ ?>
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
    .record_red {width:50px;height:26px;line-height:26px;text-align:center;color:white;border-radius:10px;background-color:red;box-shadow:#006666 1px 1px 2px;}
    .record_green {width:50px;height:26px;line-height:26px;text-align:center;color:white;border-radius:10px;background-color:green;box-shadow:#18A665 1px 1px 2px;}
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
<div class="main-container" id="main-container">
    <div id="sidebar" class="sidebar ">
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
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo url('/Admin/shop'); ?>"><?php echo config('WEB_SITE_NAME'); ?></a> </li>
                    <li> <a href="<?php echo url('goods_order'); ?>">商城管理</a> </li>
                    <li class="active"><?php echo $pagename; ?></li>
                </ul>
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1> <?php echo $pagename; ?> <small> <i class="ace-icon fa fa-angle-double-right"></i> 查询出<?php echo $record['count']; ?>条数据 </small> </h1>
                </div>
                <!-- /.page-header -->
                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                            <div class="col-xs-12" style="margin-bottom:10px;">
                                <form action="<?php echo url('goods_order'); ?>" method="get" class="form-inline" role="form">
                                    <div class="form-group">
                                        <label>关键词</label>
                                        <input name="keywords" type="text" class="form-control search" placeholder="订单号" />
                                    </div>&nbsp;&nbsp;
                                    <div class="form-group">
                                        <label>交易类型</label>
                                        <select name="record_type" class="form-control" >
                                            <option value="0" <?php echo $record_type=="0"?'selected':''; ?>>全部</option>
                                            <option value="1" <?php echo $record_type=="1"?'selected':''; ?>>待支付</option>
                                            <option value="2" <?php echo $record_type=="2"?'selected':''; ?>>待发货</option>
                                            <option value="3" <?php echo $record_type=="3"?'selected':''; ?>>已收货</option>
                                            <option value="4" <?php echo $record_type=="4"?'selected':''; ?>>已完成</option>
                                        <?php if(is_array($record_type) || $record_type instanceof \think\Collection || $record_type instanceof \think\Paginator): $i = 0; $__LIST__ = $record_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['value']; ?>" <?php if($get_record_type == $vo['value']): ?>selected='selected'<?php endif; ?>><?php echo $vo['key']; ?></option>
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
                                        <th class="center">序号</th>
                                        <th>商品名</th>
                                        <th>商家id</th>
                                        <th>交易数量</th>
                                        <th>交易金额</th>
                                        <th>交易状态</th>
                                        <th>创建时间</th>
                                        <th>订单号</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($goods_order) || $goods_order instanceof \think\Collection || $goods_order instanceof \think\Paginator): $k = 0; $__LIST__ = $goods_order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                                    <tr>
                                        <td class="center"><?php echo $k; ?></td>
                                        <td><?php echo $vo['name']; ?></td>
                                        <td><?php echo $vo['gid']; ?></td>
                                        <td><?php echo $vo['g_number']; ?></td>
                                        <td><?php echo $vo['money']; ?></td>
                                        <td class="center">
                                            <?php switch($vo['order_status']): case "1": ?>待支付<?php break; case "2": ?>待发货<?php break; case "4": ?>已收货<?php break; case "5": ?>已完成<?php break; endswitch; ?>
                                        </td>
                                        <td><?php echo date("Y年m月d日 H:i:s",$vo['create_time']); ?></td>
                                        <td><?php echo $vo['order_number']; ?></td>
                                        <td>删除</td>
                                    </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                                <div style="width:100%;margin: 0 auto; text-align:center;">
                                    <ul class="pagination" >
                                        <?php echo $page; ?>
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
    $('a[href="/Admin/shop/goods_order"]').parents().filter('li').addClass('open active');
    <?php if(input('get.keywords')): ?>
    $('input[name="keywords"]').val('<?php echo $_GET["keywords"]; ?>');
    <?php endif; if(is_numeric(input('get.record_type'))): ?>
        $('select[name="record_type"]').val(<?php echo $_GET['state']; ?>);
        <?php endif; ?>
</script>
<script type="text/javascript">
    jQuery(function($) {
        //清除查询条件
        $(document).on('click', 'button:reset',function() {
            location.href = '<?php echo url('record'); ?>';
        });
    });

    //// 查看交易类型
    //function look_type(record_type){
    //	var val = $(record_type).val();
    //	var url = '<?php echo url("index"); ?>?get_type=' + val;
    //	window.location.href = url;
    //}

    // 删除交易记录
    function deleteInfo(obj,id){
        layer.confirm('确定要删除吗？<br>该条记录所有的信息都将被完全删除，不可恢复！', {
            btn:['确定','关闭']
        },function(){
            $.post("<?php echo url('record_del'); ?>",{id:id}).success(function(data){
                if(data.cdoe == 0){
                    layer.msg(data.msg,{icon:data.code,time:1500},function(){
                        location.href = self.location.href;
                    });
                }else{
                    layer.msg(data.msg,{icon:data.code,time:1500},function(){
                        location.href = self.location.href;
                    });
                }
            });
        });
    }
</script>
</body>
</html>
