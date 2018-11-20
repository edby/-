<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;
use think\Db;

class Trade extends Admin
{
	
	/**
	 * controller 交易买入设置
	 */
	public function index(){
		
		$this -> assign('list',model('Trade') -> price_list());
		$this -> assign('pagename','买入设置');
		return $this -> fetch();
	}
	
	/**
	 * controller 添加/减去 交易买入金额
	 */
	public function buy_number($type){
		return json(model('Trade') -> buyNumber($type));
	}
	
	/**
	 * controller 交易买入列表
	 */
	public function trade_buy($p = 1){
		// 买入人手机号
		$keywords = trim(input('get.keywords')) ? trim(input('get.keywords')) : null;
		if($keywords){
			$map['account'] = array('like','%'.$keywords.'%');
		}
		
		// 交易状态
		$trade_status = input('buy_status');
		if($trade_status){
			$map['buy_status'] = $trade_status;
		}
		$this -> assign('get_trade_status',$trade_status);
		
		$this -> assign('pagename','交易买入列表');
		$this -> assign("trade_status", model("Common/Dict") -> showList('trade_status'));
		$this -> assign('data',model('trade') -> tradeBuy($map,$p));
		return $this -> fetch();
	}
	
	/**
	 * controller 交易买入绑定卖出
	 */
	public function trade_buy_bind($trade_buy_id,$p = 1){
		if(!$trade_buy_id){
			echo "<script type='text/javascript'>alert('未获取买入信息!');window.location.href='/Admin/Trade/trade_buy'</script>";
		}
		
		// 买入人手机号
		$keywords = trim(input('get.keywords')) ? trim(input('get.keywords')) : null;
		if($keywords){
			$map['account'] = array('like','%'.$keywords.'%');
		}
		
		// 奖金类型
		$bonus_type = input('bonus_type');
		if($bonus_type){
			$map['bonus_type'] = $bonus_type;
		}
		$this -> assign('get_bonus_type',$bonus_type);
		
		$this -> assign('pagename','交易买入匹配');
		$this -> assign('trade_buy_id',$trade_buy_id);
		$this -> assign("bouns_type", model("Common/Dict") -> showList('bouns_type'));
		$this -> assign('data',model('trade') -> bindSellList($trade_buy_id,$map,$p));
		return $this -> fetch();
	}
	
	/**
	 * controller 执行绑定
	 */
	public function do_bind(){
		if(Request::instance() -> isPost()){
			return json(model('trade') -> doBind(input('post.')));
		}
	}
	
	/**
	 * controller 交易卖出列表
	 */
	public function trade_sell($p = 1){
		// 买入人手机号
		$keywords = trim(input('get.keywords')) ? trim(input('get.keywords')) : null;
		if($keywords){
			$map['account'] = array('like','%'.$keywords.'%');
		}
		
		// 奖金类型
		$bonus_type = input('bonus_type');
		if($bonus_type){
			$map['bonus_type'] = $bonus_type;
		}
		$this -> assign('get_bonus_type',$bonus_type);
		
		// 交易状态
		$trade_status = input('sell_status');
		if($trade_status){
			$map['sell_status'] = $trade_status;
		}
		$this -> assign('get_trade_status',$trade_status);
		
		$this -> assign('pagename','交易卖出列表');
		$this -> assign("bouns_type", model("Common/Dict") -> showList('bouns_type'));
		$this -> assign("trade_status", model("Common/Dict") -> showList('trade_status'));
		$this -> assign('data',model('trade') -> tradeSell($map,$p));
		return $this -> fetch();
	}
}

