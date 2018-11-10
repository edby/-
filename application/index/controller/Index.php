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

//	    print_r($preferential);
//	    exit;
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
     * controller 判断用户是否设置预约
     */
    public function set_timing_buy(){
    	// 获取天数
    	$endToday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;	// 获取当天23:59:59的时间戳
    	$two_day = $endToday - 60*60*24*2;		// 两天
    	$three_day = $endToday - 60*60*24*3;	// 三天
    	$four_day = $endToday - 60*60*24*4;		// 四天
    	$five_day = $endToday - 60*60*24*5;		// 五天
    	
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
    				
    		}
    	}
    }
    
}