<?php
namespace app\admin\controller;

use app\common\controller\BaseAdmin;
use think\Request;
use think\Db;

class Method extends Admin
{
	/**
	 * controller 财务列表
	 */
	public function index($p = 1){
		
		// 订单号查询
		$keywords = trim(input('keywords'));
		if($keywords){
			$map['order'] = array('LIKE','%'.$keywords.'%');
		}
		
		// 订单状态
		$order_status = input('order_status');
		if($order_status){
			$map['order_status'] = $order_status;
		}
		$this -> assign('get_status',$order_status);
		
		// 交易类型
		$trade_type = input('trade_type');
		if($trade_type){
			$map['trade_type'] = $trade_type;
		}
		$this -> assign('get_type',$trade_type);
		
		$this -> assign('pagename','财务管理');
		$this -> assign('trade_status',model('Common/Dict') -> showList('trade_status'));
		$this -> assign('trade_type',model('Common/Dict') -> showList('trade_type'));
		$this -> assign('data', model("Method")->index($map,$p));
		return $this -> fetch();
	}
}


