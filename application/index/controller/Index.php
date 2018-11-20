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
		$this -> assign('data',model('Index') -> tradeCount($uid));

	    $page_size = 5;
	    //获取优惠专区商品
	    $preferential = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->limit($page_size)->where(['area_type' =>1,'status'=>3])->select();
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
     * controller 买家超过12小时未打款情况(将买家封号处理,并将卖家信息设置为重新匹配)(每天00:00:00执行)
     */
    public function pass_pay_time(){
    	$time = time();
    	$twelve = 60*60*12;
    	// 获取订单状态为 待支付 的数据
    	$order_where['order_status'] = 1;
    	$order_where['trade_type'] = 2;	// 搜索 交易类型 为求购(相应的数据比较全)
    	$order = Db::name('order') -> where($order_where) -> select();
    	foreach($order as $k => $v){
    		// 判断是否超过12个小时
    		$actual = $time - $order['create_time'];
    		if($actual >= $twelve){
				// 修改 买家状态为 封号
				Db::name('user') -> where('id',$order['buyer_id']) -> update(['status' => 3]);
				// 修改 买单信息为 已取消
				Db::name('trade_buy') -> where('id',$v['trade_buy_id']) -> update(['buy_status' => 5]);
				// 修改 用户交易烧伤记录表 中状态为 已取消
				$burn_buy_id = ','.$v['trade_buy_id'].',';
				Db::name('trade_burn') -> where('trade_buy_ids','LIKE','%'.$burn_buy_id.'%') -> update(['status' => 2]);
				// 修改 卖家信息设置为重新匹配
				$sell_mod['trade_buy_id'] = '';
				$sell_mod['matching'] = 1;
				$trade_sell_ids = explode(',',$v['trade_sell_ids']);
				foreach($trade_sell_ids as $sell_k => $sell_v){
					Db::name('trade_sell') -> where('id',$sell_v) -> update($sell_mod);
				}
				// 修改 订单状态为 已取消
				Db::name('order') -> where('trade_buy_id',$v['trade_buy_id']) -> update(['order_status' => 5]);
			}
			
		}
    }
    
    /**
     * controller 卖家超过5个小时未确认惩罚(扣除10%下一轮静态奖金)(每10分钟执行一次)
     */
    public function pass_confirm_time(){
    	$time = time();
    	$five = 60*60*5;
    	// 获取订单状态为 已支付 的数据
    	$order_where['order_status'] = 2;
    	$order_where['trade_type'] = 2;
    	$order_where['pay_time'] = array('neq',null);
    	$order = Db::name('order') -> where($order_where) -> select();
    	foreach($order as $k => $v){
    		// 判断是否超过5个小时
    		$actual = $time - $order['pay_time'];
    		if($actual >= $five){
    			// 执行确认订单
    			$data['id'] = $v['id'];
    			$data['trade_sell_ids'] = $v['trade_sell_ids'];
    			model('Index') -> tradeDeal($data);
    			// 记录卖家惩罚信息
    			$seller_ids = explode(',',$v['seller_ids']);
    			foreach($seller_ids as $seller_k => $seller_v){
    				Db::name('user_bouns') -> where('uid',$seller_v) -> update(['next_trade_condition' => 1]);
    			}
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
    	$burn_where['status'] = array('neq',2);
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
			
			// 返还上一层用户福利奖
			if($burn['welfare1_id']){
				$this -> back_bonus($burn['welfare1_id'],3,$burn['welfare1_num']);
			}
			// 返还上二层用户福利奖
			if($burn['welfare2_id']){
				$this -> back_bonus($burn['welfare2_id'],3,$burn['welfare2_num']);
			}
			// 返还上三层用户福利奖
			if($burn['welfare3_id']){
				$this -> back_bonus($burn['welfare3_id'],3,$burn['welfare3_num']);
			}
			// 返还上四层用户福利奖
			if($burn['welfare4_id']){
				$this -> back_bonus($burn['welfare4_id'],3,$burn['welfare4_num']);
			}
    	}
    }
    // 执行返奖金
    public function back_bonus($uid,$type,$number){
    	$user_where['uid'] = $uid;
    	$user_where['bouns_type'] = $type;
    	Db::name('user_bouns') -> where($user_where) -> setInc('bouns_number',$number);
    	Db::name('user_bouns') -> where($user_where) -> setDec('frozen_bouns_number',$number);
    }
    
}