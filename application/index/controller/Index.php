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
    
    
    
}