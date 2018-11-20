<?php
namespace app\admin\model;

use app\common\model\Base;
use think\Request;
use think\Db;

class Trade extends Base
{
	const PATH_LIMIT = 10;	// 用户表分页限制
	const PATH_SHOW = 10;	// 显示分页菜单数量
	
	/**
	 * model 买入设置
	 */
	public function price_list(){
		$list = Db::name('set_buy_list') -> select();
		return $list;
	}
	
	/**
	 * model 添加买入金额
	 */
	public function buyNumber($type){
		if($type == 1){
			$last = Db::name('set_buy_list') -> order('id DESC') -> find();
			$in_set_buy['number'] = $last['number'] + 2000;
			$result = Db::name('set_buy_list') -> insert($in_set_buy);
			if($result){
				return ['code' => 1,'msg' => '添加成功!'];
			}else{
				return ['code' => 0,'msg' => '添加失败!'];
			}
		}else{
			$last = Db::name('set_buy_list') -> order('id DESC') -> find();
			$result = Db::name('set_buy_list') -> where('id',$last['id']) -> delete();
			if($result){
				return ['code' => 1,'msg' => '减去成功!'];
			}else{
				return ['code' => 0,'msg' => '减去失败!'];
			}
		}
	}
	
	/**
	 * model 交易买入列表
	 */
	public function tradeBuy($map,$p){
		// 搜索挂卖人名称
		if($map['account']){
			$user['account'] = $map['account'];
			$user_seller_id = Db::name('user') -> field('id') -> where($user) -> select();
			$seller_id = '';
			foreach($user_seller_id as $k => $v){
				$seller_id .= $v['id'].',';
			}
			unset($map['account']);
			$map['uid'] = array('in',trim($seller_id,','));
		}
		
		$list = Db::name('trade_buy') -> where($map) -> order('matching ASC,id ASC') -> page($p,self::PATH_LIMIT) -> select();
		$count = Db::name('trade_buy') -> where($map) -> count();
		$request = Request::instance();
		$page = boot_page($count,self::PATH_LIMIT,self::PATH_SHOW,$p,$request -> action());
		foreach($list as $k => $v){
			// 买入人账号
			$list[$k]['account'] = Db::name('user') -> where('id',$v['uid']) -> value('account');
			
			// 买入款类
			$dict_where['type'] = 'class_type';
			$dict_where['value'] = $v['class'];
			$list[$k]['class_text'] = Db::name('dict') -> where($dict_where) -> value('key');
			
			// 买入状态
			$dict_where['type'] = 'trade_status';
			$dict_where['value'] = $v['buy_status'];
			$list[$k]['buy_status_text'] = Db::name('dict') -> where($dict_where) -> value('key');
			switch($v['buy_status']){
				case 1:
					$list[$k]['buy_status_button'] = 'trade_status_link';
					break;
				case 2:
					$list[$k]['buy_status_button'] = 'trade_status_active';
					break;
				case 3:
					$list[$k]['buy_status_button'] = 'trade_status_visited';
					break;
				case 4:
					$list[$k]['buy_status_button'] = 'trade_status_hover';
					break;
			}
			
			// 日期
			$list[$k]['start_date'] = date('Y-m-d H:i:s',$v['start_time']);
			if($v['end_date']){
				$list[$k]['end_date'] = date('Y-m-d H:i:s',$v['end_time']);
			}else{
				$list[$k]['end_date'] = '-';
			}
			
			// 关联卖出ID
			$list[$k]['trade_sell_ids'] = trim($v['trade_sell_ids'],',');
		}
		
		$return['list'] = $list;
		$return['count'] = $count;
		$return['page'] = $page;
		return $return;
	}
	
	/**
	 * model 交易买入绑定卖出列表
	 */
	public function bindSellList($trade_buy_id,$sell_where,$p){
		// 获取要绑定的买入信息
		$trade_buy = Db::name('trade_buy') -> where('id',$trade_buy_id) -> find();
		// 搜索挂卖人名称
		if($sell_where['account']){
			$user['account'] = $sell_where['account'];
			$user_seller_id = Db::name('user') -> field('id') -> where($user) -> select();
			$seller_id = '';
			foreach($user_seller_id as $k => $v){
				$seller_id .= $v['id'].',';
			}
			unset($sell_where['account']);
			$sell_where['uid'] = array('in',trim($seller_id,','));
		}
		$sell_where['matching'] = 1;
		
		// 获取相应的须绑定的卖出信息
		$sell_where['sell_status'] = 1;
		$list = Db::name('trade_sell') -> where($sell_where) -> where('number <= '.$trade_buy['number']) -> order('id DESC') -> select();
		$count = Db::name('trade_sell') -> where($sell_where) -> where('number <= '.$trade_buy['number']) -> count();
		$request = Request::instance();
		$page = boot_page($count,self::PATH_LIMIT,self::PATH_SHOW,$p,$request -> action());
		foreach($list as $k => $v){
			// 卖出人账号
			$list[$k]['account'] = Db::name('user') -> where('id',$v['uid']) -> value('account');
			
			// 奖金类型
			$dict_where['type'] = 'bouns_type';
			$dict_where['value'] = $v['bonus_type'];
			$list[$k]['bonus_type_text'] = Db::name('dict') -> where($dict_where) -> value('key');
			
			// 日期
			$list[$k]['start_date'] = date('Y-m-d H:i:s',$v['start_time']);
			$list[$k]['end_date'] = date('Y-m-d H:i:s',$v['end_time']);
		}
		$return['trade_buy'] = $trade_buy;
		$return['list'] = $list;
		$return['count'] = $count;
//		$return['page'] = $page;
		return $return;
	}
	
	/**
	 * model 执行绑定
	 */
	public function doBind($data){
		if(!$data['trade_buy_id']){
			return ['code' => 0,'msg' => '未获取买单信息!'];
		}
		if(!$data['number']){
			return ['code' => 0,'msg' => '未获取买单数量!'];
		}
		if($data['need_number'] != 0){
			return ['code' => 0,'msg' => '数值信息错误!'];
		}
		if(!$data['trade_sell_ids']){
			return ['code' => 0,'msg' => '未获取卖单信息!'];
		}else{
			$trade_sell_ids = trim($data['trade_sell_ids'],',');
		}
		
		Db::startTrans();
		$condition = 0;
		try{
			// 修改 交易买入表 信息
			$trade_buy_mod['trade_sell_ids'] = ','.$trade_sell_ids.',';
			$trade_buy_mod['matching'] = 2;
			Db::name('trade_buy') -> where('id',$data['trade_buy_id']) -> update($trade_buy_mod);
			
			// 修改 交易卖出表 信息
			$arr_trade_sell_ids = explode(',',$trade_sell_ids);
			$sell_uids = '';
			foreach($arr_trade_sell_ids as $k => $v){
				$trade_sell_mod['trade_buy_id'] = $data['trade_buy_id'];
				$trade_sell_mod['matching'] = 2;
				Db::name('trade_sell') -> where('id',$v) -> update($trade_sell_mod);
				
				// 获取卖出人ID
				$sell_uids .= Db::name('trade_sell') -> where('id',$v) -> value('uid').',';
				
				// 在订单表中插入 卖出 数据
				$in_sell_order['order'] = generateOrderNumber();	// 订单编号
				$in_sell_order['order_number'] = Db::name('trade_sell') -> where('id',$v) -> value('number');	// 交易数量
				$in_sell_order['buyer_id'] = Db::name('trade_buy') -> where('id',$data['trade_buy_id']) -> value('uid');	// 买家ID
				$in_sell_order['seller_ids'] = Db::name('trade_sell') -> where('id',$v) -> value('uid');	// 卖家ID
				$in_sell_order['create_time'] = time();	// 创建时间
				$in_sell_order['trade_buy_id'] = $data['trade_buy_id'];	// 交易买入表ID
				$in_sell_order['trade_sell_ids'] = $v;	// 交易卖出表ID
				$in_sell_order['trade_type'] = 1;	// 交易类型 1出售 2求购
				$get_order_id = Db::name('order') -> insertGetId($in_sell_order);
				
				// 在 交易卖出表 中添加订单编号
				Db::name('trade_sell') -> where('id',$v) -> update(['order_id' => $get_order_id]);
			}
			
			// 在订单表中插入 买入 数据
			$in_buy_order['order'] = generateOrderNumber();	// 订单编号
			$in_buy_order['order_number'] = $data['number'];	// 交易数量
			$in_buy_order['buyer_id'] = Db::name('trade_buy') -> where('id',$data['trade_buy_id']) -> value('uid');	// 买家ID
			$in_buy_order['seller_ids'] = trim($sell_uids,',');	// 卖家ID(可能匹配多个)
			$in_buy_order['create_time'] = time();	// 创建时间
			$in_buy_order['trade_buy_id'] = $data['trade_buy_id'];	// 交易买入表ID
			$in_buy_order['trade_sell_ids'] = ','.$trade_sell_ids.',';	// 交易卖出表ID(可能匹配多个)
			$in_buy_order['trade_type'] = 2;	// 交易类型 1出信 2求购
			$get_order_id = Db::name('order') -> insertGetId($in_buy_order);
			
			// 在 交易买入表 中添加订单编号
			Db::name('trade_buy') -> where('id',$data['trade_buy_id']) -> update(['order_id' => $get_order_id]);
			
			$condition = 1;
			Db::commit();
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '匹配成功!','url' => url('trade_buy')];
		}else{
			return ['code' => 0,'msg' => '匹配失败!'];
		}
	}
	
	/**
	 * model 交易卖出列表
	 */
	public function tradeSell($map,$p){
		// 搜索挂卖人名称
		if($map['account']){
			$user['account'] = $map['account'];
			$user_seller_id = Db::name('user') -> field('id') -> where($user) -> select();
			$seller_id = '';
			foreach($user_seller_id as $k => $v){
				$seller_id .= $v['id'].',';
			}
			unset($map['account']);
			$map['uid'] = array('in',trim($seller_id,','));
		}
		
		$list = Db::name('trade_sell') -> where($map) -> order('matching ASC,id ASC') -> page($p,self::PATH_LIMIT) -> select();
		$count = Db::name('trade_sell') -> where($map) -> count();
		$request = Request::instance();
		$page = boot_page($count,self::PATH_LIMIT,self::PATH_SHOW,$p,$request -> action());
		foreach($list as $k => $v){
			// 卖出人账号
			$list[$k]['account'] = Db::name('user') -> where('id',$v['uid']) -> value('account');
			
			// 奖金类型
			$dict_where['type'] = 'bouns_type';
			$dict_where['value'] = $v['bonus_type'];
			$list[$k]['bonus_type_text'] = Db::name('dict') -> where($dict_where) -> value('key');
			
			// 卖出状态
			$dict_where['type'] = 'trade_status';
			$dict_where['value'] = $v['sell_status'];
			$list[$k]['sell_status_text'] = Db::name('dict') -> where($dict_where) -> value('key');
			switch($v['sell_status']){
				case 1:
					$list[$k]['sell_status_button'] = 'trade_status_link';
					break;
				case 2:
					$list[$k]['sell_status_button'] = 'trade_status_active';
					break;
				case 3:
					$list[$k]['sell_status_button'] = 'trade_status_visited';
					break;
				case 4:
					$list[$k]['sell_status_button'] = 'trade_status_hover';
					break;
			}
			
			// 日期
			$list[$k]['start_date'] = date('Y-m-d H:i:s',$v['start_time']);
			if($v['end_date']){
				$list[$k]['end_date'] = date('Y-m-d H:i:s',$v['end_time']);
			}else{
				$list[$k]['end_date'] = '-';
			}
		}
		
		$return['list'] = $list;
		$return['count'] = $count;
		$return['page'] = $page;
		return $return;
	}
	
}


