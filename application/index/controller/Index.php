<?php
namespace app\index\controller;

use app\common\controller\Base;
use think\Request;
use think\Session;
use app\index\controller\Goods;
use think\Db;

class Index extends Base
{   

    /**
     * controller 首页
     */
    public function index(){
    	// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('uid',$uid);
		$this -> assign('bonus',model('Common/Dict') -> showList('bouns_type'));
		$this -> assign('count',model('Index') -> tradeCount($uid));

	    $page_size = 5;
	    //获取优惠专区商品
	    $preferential = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->limit($page_size)->where('area_type = 1')->select();
	    //		传递优惠专区
	    $this->assign('pre',$preferential);

        return $this -> fetch();
    }
    
    /**
     * controller 买入列表(layui分页)
     */
    public function buy_list(){
    	if(Request::instance() -> isPost()){
    		return json(model('Index') -> buyList(input('post.')));
    	}
    }
    
    /**
     * controller 设置预约买入
     */
    public function set_timing(){
    	if(Request::instance() -> isPost()){
    		return json(model('Index') -> setTiming(input('post.')));
    	}
    }
    
    /**
     * controller 卖出列表(layui分页)
     */
    public function sell_list(){
    	if(Request::instance() -> isPost()){
    		return json(model('Index') -> sellList(input('post.')));
    	}
    }
    
    /**
     * controller 进行中的列表(layui分页)
     */
    public function order_list(){
    	if(Request::instance() -> isPost()){
    		return json(model('Index') -> orderList(input('post.')));
    	}
    }
    
    /**
     * controller 买入
     */
    public function trade_buy(){
    	if(Request::instance() -> isPost()){
    		return json(model('Index') -> tradeBuy(input('post.')));
    	}
    }
    
    /**
     * controller 卖出
     */
    public function trade_sell(){
    	if(Request::instance() -> isPost()){
    		return json(model('User') -> doWithdraw(input('post.')));
    	}
    }
    
    /**
     * controller 买入订单详情
     */
    public function buy_det($id){
    	$this -> assign('order',model('Index') -> buyDet($id));
    	return $this -> fetch();
    }
    
    /**
     * controller 提交支付单个匹配卖单
     */
    public function pay_sell(){
    	if(Request::instance() -> isPost()){
    		return json(model('Index') -> paySell(input('post.')));
    	}
    }
    
    /**
     * controller 卖出订单详情
     */
    public function sell_det($id){
    	$this -> assign('order',model('Index') -> sellDet($id));
    	return $this -> fetch();
    }
    
    /**
     * controller 提交确认交易
     */
    public function trade_deal(){
    	if(Request::instance() -> isPost()){
    		return json(model('Index') -> tradeDeal(input('post.')));
    	}
    }
    
    // 上传图片
    public function upload_pay(){
    	$type = trim(input('type'));
    	$buyer_id = input('buyer_id');	// 店铺ID
    	if(!$type || !$buyer_id){
    		$ret = ['code' => 0,'msg' => '参数错误!'];
    	}else{
    		$file = request() -> file('file');
    		if($file){
    			$info = $file -> move(ROOT_PATH . 'public' . DS . 'upload/' . $type . '/' . $buyer_id,true,true,2);
    			if($info){
    				$link = '/upload/' . $type . '/' . $buyer_id . '/' . $info -> getSaveName();
    				$ret = ['code' => 1,'msg' => '上传成功!','url' => $link];
    			}else{
    				$ret = ['code' => 0,'msg' => $file -> getError()];
    			}
    		}else{
    			$ret = ['code' => 0,'msg' => '未上传!'];
    		}
    	}
    	return json($ret);
    }
    
    
    
    
    
    
    
    /**
     * controller 判断用户是否设置预约(每天00:00:00执行)
     */
    public function set_timing_buy(){
    	// 获取天数
    	$endToday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;	// 获取当天23:59:59的时间戳
    	$two_day = $endToday - 60*60*24*2;		// 两天
    	$three_day = $endToday - 60*60*24*3;	// 三天
    	$four_day = $endToday - 60*60*24*4;		// 四天
    	$five_day = $endToday - 60*60*24*5;		// 五天
    	$ten_day = $endToday - 60*60*24*10;		// 十天
    	
    	// 获取设置天数用户ID
    	$users_where['status'] = 1;
    	$users_where['timing'] = array('neq',0);
    	$users = Db::name('user') -> where($users_where) -> field('id,timing') -> select();
    	foreach($users as $k => $v){
    		switch($v['timing']){
    			case 1:
    				// 查询用户一天内是否有交易
    				$have_trade = Db::name('trade_burn') -> where('uid',$v['id']) -> whereTime('create_time','today') -> count();
    				if(!$have_trade){
    					$data['uid'] = $v['id'];
    					$data['number'] = 2000;
    					model('Index') -> tradeBuy($data);
    				}
    				break;
    				
    			case 2:
    				// 查询用户二天内是否有交易
    				$have_trade = Db::name('trade_burn') -> where('uid',$v['id']) -> whereTime('create_time','between',[$two_day,$endToday]) -> count();
    				if(!$have_trade){
    					$data['uid'] = $v['id'];
    					$data['number'] = 2000;
    					model('Index') -> tradeBuy($data);
    				}
    				break;
    				
    			case 3:
    				// 查询用户三天内是否有交易
    				$have_trade = Db::name('trade_burn') -> where('uid',$v['id']) -> whereTime('create_time','between',[$three_day,$endToday]) -> count();
    				if(!$have_trade){
    					$data['uid'] = $v['id'];
    					$data['number'] = 2000;
    					model('Index') -> tradeBuy($data);
    				}
    				break;
    				
    			case 4:
    				// 查询用户四天内是否有交易
    				$have_trade = Db::name('trade_burn') -> where('uid',$v['id']) -> whereTime('create_time','between',[$four_day,$endToday]) -> count();
    				if(!$have_trade){
    					$data['uid'] = $v['id'];
    					$data['number'] = 2000;
    					model('Index') -> tradeBuy($data);
    				}
    				break;
    				
    			case 5:
    				// 查询用户五天内是否有交易
    				$have_trade = Db::name('trade_burn') -> where('uid',$v['id']) -> whereTime('create_time','between',[$five_day,$endToday]) -> count();
    				if(!$have_trade){
    					$data['uid'] = $v['id'];
    					$data['number'] = 2000;
    					model('Index') -> tradeBuy($data);
    				}
    				break;
    				
    			default:
    				// 查询用户十天内是否有交易
    				$have_trade = Db::name('trade_burn') -> where('uid',$v['id']) -> whereTime('create_time','between',[$ten_day,$endToday]) -> count();
    				if(!$have_trade){
    					$data['uid'] = $v['id'];
    					$data['number'] = 2000;
    					model('Index') -> tradeBuy($data);
    				}
    				break;
    		}
    	}
    }
    
    /**
     * controller 判断用户冻结是否已过10天(每天00:00:00点执行)
     */
    public function thaw_bonus(){
    	$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));	// 当天00:00:00点时间戳
    	$ten_day = $beginToday - 60*60*24*10;	// 10天前的00:00:00点时间戳
    	
    	// 获取烧伤表中未解冻的数据
    	$burn_where['start_timezone'] = array('neq',null);
    	$burn_where['end_timezone'] = array('neq',null);
    	$burn_where['create_time'] = array('<=',$ten_day);
    	$burn = Db::name('trade_burn') -> where($burn_where) -> select();
    	foreach($burn as $k => $v){
    		// 修改用户冻结的静态奖金
    		$this -> back_bonus($v['uid'],1,$v['frozen_bouns_number']);	// 静态奖
    		$this -> back_bonus($v['uid'],2,$v['frozen_bouns_number']);	// 动态奖
    		
    		// 修改上一级用户烧伤(动态)
			if($v['one_number'] != 0){
    			$this -> back_bonus($v['one_id'],2,$v['one_number']);	// 动态奖
			}
			// 修改上二级用户烧伤(动态)
			if($v['two_number'] != 0){
    			$this -> back_bonus($v['two_id'],2,$v['two_number']);	// 动态奖
			}
			// 修改上三级用户烧伤(动态)
			if($burn['three_number'] != 0){
    			$this -> back_bonus($v['three_id'],2,$v['three_number']);	// 动态奖
			}
    	}
    }
    // 执行返奖金
    public function back_bonus($uid,$type){
    	$user_where['uid'] = $uid;
    	$user_where['bouns_type'] = $type;
    	Db::name('user_bouns') -> where($user_where) -> setInc('bouns_number',$v['back_status_bonus']);
    	Db::name('user_bouns') -> where($user_where) -> setDec('frozen_bouns_number',$v['back_status_bonus']);
    }
    
}