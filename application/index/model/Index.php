<?php
namespace  app\index\model;
use app\common\model\Base;
use think\Request;
use think\db;
use think\Validate;
use think\Session;
class Index extends Base
{
    /**
     * model 首页数据
     */
    public function tradeCount($uid){
    	// 买入列表总数
    	$buy = Db::name('trade_buy') -> where('uid',$uid) -> count();
        // 卖出列表总数
        $sell = Db::name('trade_sell') -> where('uid',$uid) -> count();
        // 订单列表总数
        $order_where['buyer_id'] = $uid;
        $order_where['seller_ids'] = array('in',$uid);
        $order = Db::name('order') -> whereOr($order_where) -> count();
        
        $result['buy'] = $buy;
        $result['sell'] = $sell;
        $result['order'] = $order;
        return $result;
    }
	
	/**
	 * model 买入列表(layui分页)
	 */
	public function buyList($data){
		if($data['page']){
			$page_start = $data['page'] * 8 - 8;
		}else{
			$page_start = 0;
		}
		$page_end = 8;
		$buy = Db::name('trade_buy') -> where('uid',$data['uid']) -> order('id DESC') -> limit($page_start,$page_end) -> select();
		foreach($buy as $k => $v){
			// 用户账号
			$buy[$k]['account'] = Db::name('user') -> where('id',$data['uid']) -> value('account');
			// 状态
			switch($v['matching']){
				case 1:
					$buy[$k]['matching_text'] = '正在匹配';
					$buy[$k]['matching_class'] = 'cor_red';
					break;
				case 2:
					$buy[$k]['matching_text'] = '已匹配';
					break;
			}
			// 创建时间
			$buy[$k]['start_date'] = date('Y-m-d H:i:s',$v['start_time']);
		}
		if($buy){
			return ['code' => 1,'buy' => $buy];
		}else{
			return ['code' => 0];
		}
	}
	
	/**
	 * model 卖出列表(layui分页)
	 */
	public function sellList($data){
		if($data['page']){
			$page_start = $data['page'] * 8 - 8;
		}else{
			$page_start = 0;
		}
		$page_end = 8;
		$sell = Db::name('trade_sell') -> where('uid',$data['uid']) -> order('id DESC') -> limit($page_start,$page_end) -> select();
		foreach($sell as $k => $v){
			// 用户账号
			$sell[$k]['account'] = Db::name('user') -> where('id',$data['uid']) -> value('account');
			// 奖金类型
			$dict_where['type'] = 'bouns_type';
			$dict_where['value'] = $v['bonus_type'];
			$sell[$k]['bonus_name'] = Db::name('dict') -> where($dict_where) -> value('key');
			// 状态
			switch($v['matching']){
				case 1:
					$sell[$k]['matching_text'] = '正在匹配';
					$sell[$k]['matching_class'] = 'cor_red';
					break;
				case 2:
					$sell[$k]['matching_text'] = '已匹配';
					break;
			}
			// 创建时间
			$sell[$k]['start_date'] = date('Y-m-d H:i:s',$v['start_time']);
		}
		if($sell){
			return ['code' => 1,'sell' => $sell];
		}else{
			return ['code' => 0];
		}
	}
	
	/**
	 * model 进行中的列表(layui分页)
	 */
	public function orderList($data){
		if($data['page']){
			$page_start = $data['page'] * 8 - 8;
		}else{
			$page_start = 0;
		}
		$page_end = 8;
		$order_where['buyer_id'] = $data['uid'];
        $order_where['seller_ids'] = array('in',$data['uid']);
		$order = Db::name('order') -> whereOr($order_where) -> order('id DESC') -> limit($page_start,$page_end) -> select();
		foreach($order as $k => $v){
			// 交易类型
			$dict_where['type'] = 'trade_type';
			$dict_where['value'] = $v['trade_type'];
			$order[$k]['trade_type_text'] = Db::name('dict') -> where($dict_where) -> value('key');
			// 根据 交易类型 改变"详情"颜色和跳转路径
			switch($v['trade_type']){
				case 1:
					$order[$k]['trade_type_class'] = 'cor_51b8ff';
					break;
				case 2:
					$order[$k]['trade_type_class'] = '';
					break;
			}
			// 创建时间
			$order[$k]['create_date'] = date('Y-m-d H:i:s',$v['create_time']);
			// 订单状态
			$dict_where['type'] = 'order_status';
			$dict_where['value'] = $v['order_status'];
			$order[$k]['order_status_text'] = Db::name('dict') -> where($dict_where) -> value('key');
			// 最迟付款时间
			$order[$k]['deadline'] = date('Y-m-d H:i:s',$v['create_time'] + 60*60*12);
		}
		if($order){
			return ['code' => 1,'order' => $order];
		}else{
			return ['code' => 0];
		}
	}
	
	/**
	 * model 买入
	 */
	public function tradeBuy($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['number']){
			return ['code' => 0,'msg' => '请输入买入数量!'];
		}else{
			if(!is_int($data['number']/2000)){
				return ['code' => 0,'msg' => '买入只能为2000的倍数!'];
			}
		}
		// 判断一天只能买一次
		$burn_where['uid'] = $data['uid'];
		$burn_count = Db::name('trade_burn') -> where($burn_where) -> whereTime('create_time','today') -> count();
		if($burn_count >= 1){
			return ['code' => 0,'msg' => '一天最多只能交易一次!'];
		}
		
		Db::startTrans();
		$condition = 0;
		try{
			// 插入用户交易表(两条记录,一条为首款,一条为尾款。总金额插入下方 烧伤奖金记录表 中)
			$first_money = $data['number'] * 0.2;			// 首款
			$last_money = $data['number'] - $first_money;	// 尾款
			
			$in_trade_buy['uid'] = $data['uid'];
			$in_trade_buy['number'] = $first_money;
			$in_trade_buy['start_time'] = time();
			$in_trade_buy['class'] = 1;
			$first_trade_id = Db::name('trade_buy') -> insertGetId($in_trade_buy);	// 在买入交易表中插入首款记录
			$in_trade_buy['number'] = $last_money;
			$in_trade_buy['class'] = 2;
			$last_trade_id = Db::name('trade_buy') -> insertGetId($in_trade_buy);	// 在买入交易表中插入尾款记录
			
			// 将当前的记录插入 用户交易烧伤记录表 中
			$in_trade_burn['uid'] = $data['uid'];
			$in_trade_burn['number'] = $data['number'];
			$in_trade_burn['create_time'] = time();
			$in_trade_burn['trade_buy_ids'] = $first_trade_id.','.$last_trade_id;;
			$trade_burn_id = Db::name('trade_burn') -> insertGetId($in_trade_burn);
			
			// 执行用户对上级烧伤奖金记录
			$this -> bonus($data['uid'],$data['number'],$trade_burn_id);
			
			$condition = 1;
			Db::commit();
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '买入成功!'];
		}else{
			return ['code' => 0,'msg' => '买入失败!'];
		}
	}
	
	/**
	 * 用户对上级烧伤奖金记录
	 * $uid 	当前购买用户ID
	 * $number 	当前用户购买数量
	 */
	public function bonus($uid,$number,$trade_buy_ids){
		
		// 上一级用户
		$one_id = Db::name('user') -> where('id',$uid) -> value('parent_id');	// 获取上一级用户ID
		if($one_id){
			$one = Db::name('user') -> where('id',$one_id) -> find();	// 查询上一级用户信息
			// 记录 当前用户交易烧伤记录表 中对上一级用户的烧伤奖金
			$last_one_trade = Db::name('trade_burn') -> where('uid',$one_id) -> order('create_time DESC') -> value('number');
			// 判断当前用户的交易金额和上一级用户相比取最小的值
			if($last_one_trade > $number){
				$trade_burn_one_mod['one_number'] = $number * 0.02;
			}else{
				$trade_burn_one_mod['one_number'] = $last_one_trade * 0.02;
			}
			$trade_burn_one_where['id'] = $trade_burn_id;
			$trade_burn_one_where['one_id'] = $one_id;
			Db::name('trade_burn') -> where($trade_burn_one_where) -> update($trade_burn_one_mod);
			
			// 上二级用户
			$two_id = Db::name('user') -> where('id',$one_id) -> value('parent_id');	// 获取上二级用户ID
			if($two_id){
				$two = Db::name('user') -> where('id',$two_id) -> find();	// 查询上二级用户信息
				// 记录 当前用户交易烧伤记录表 中对上二级用户的烧伤奖金
				$last_two_trade = Db::name('trade_burn') -> where('uid',$two_id) -> order('create_time DESC') -> value('number');
				// 判断当前用户的交易金额和上二级用户相比取最小的值
				if($last_two_trade > $number){
					$trade_burn_two_mod['two_number'] = $number * 0.03;
				}else{
					$trade_burn_two_mod['two_number'] = $last_two_trade * 0.03;
				}
				$trade_burn_two_where['id'] = $trade_burn_id;
				$trade_burn_two_where['two_id'] = $two_id;
				Db::name('trade_burn') -> where($trade_burn_two_where) -> update($trade_burn_two_mod);
				
				// 上三级用户
				$three_id = Db::name('user') -> where('id',$one_id) -> value('parent_id');	// 获取上三级用户ID
				if($three_id){
					$three = Db::name('user') -> where('id',$three_id) -> find();	// 查询上三级用户信息
					// 记录 当前用户交易烧伤记录表 中对上三级用户的烧伤奖金
					$last_three_trade = Db::name('trade_burn') -> where('uid',$three_id) -> order('create_time DESC') -> value('number');
					// 判断当前用户的交易金额和上三级用户相比取最小的值
					if($last_three_trade > $number){
						$trade_burn_three_mod['three_number'] = $number * 0.05;
					}else{
						$trade_burn_three_mod['three_number'] = $last_three_trade * 0.05;
					}
					$trade_burn_three_where['id'] = $trade_burn_id;
					$trade_burn_three_where['three_id'] = $three_id;
					Db::name('trade_burn') -> where($trade_burn_three_where) -> update($trade_burn_three_mod);
				}
			}
 		}
	}
	
   
}