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
	 * model 设置豫约买入
	 */
	public function setTiming($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['timing']){
			return ['code' => 0,'msg' => '未获取设置信息!'];
		}
		$result = Db::name('user') -> where('id',$data['uid']) -> update(['timing' => $data['timing']]);
		if($result){
			return ['code' => 1,'msg' => '设置成功!'];
		}else{
			return ['code' => 0,'msg' => '设置失败!'];
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
		// 查询 当前用户买入订单
		$buy = Db::name('trade_buy') -> alias('b') -> join('order o','b.id=o.trade_buy_id') -> where('o.trade_type=2 AND b.uid='.$data['uid']) -> field('b.class,o.*') -> select();
		// 查询 当前用户卖出订单
		$sell_where['seller_ids'] = array('in',$data['uid']);
		$sell_where['trade_type'] = 1;
		$sell = Db::name('order') -> where($sell_where) ->select();
		// 合并 买入&卖出 数组
		$order = array_merge($buy,$sell);
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
			// 交易款类
			if($v['class']){
				// 获取款类中文
				$dict_where['type'] = 'class_type';
				$dict_where['value'] = Db::name('trade_buy') -> where('id',$v['trade_buy_id']) -> value('class');
				$order[$k]['class_text'] = Db::name('dict') -> where($dict_where) -> value('key');
				// 判断当付款条件为 尾款 时设置条件为 首款 支付后的 3~5 天之间可付尾款
				if($v['class'] === 2){
					// 获取同一用户同一笔交易中关联的ID
					$same_user_orders = Db::name('trade_burn') -> where('trade_buy_ids','LIKE','%'.$v['trade_buy_id']) -> value('trade_buy_ids');
					$trade_class_1_order_id = Db::name('trade_buy') -> where('id','in',$same_user_orders) -> value('order_id');	// 查询同一用户同一笔交易中 首款 的对应 order 表中的ID
					$order_class_1_pay = Db::name('order') -> where('id',$trade_class_1_order_id) -> value('pay_time');	// 获取同一用户同一笔交易中 首款 支付的时间
					$order[$k]['aaaaaaaaaaaaaaaa'] = $same_user_orders;
					$order[$k]['bbbbbbbbbbbbbbbb'] = $trade_class_1_order_id;
					$order[$k]['cccccccccccccccc'] = $order_class_1_pay;
					// 如果用户是否已付首款
					if($order_class_1_pay){	// 已付
						// 判断尾款的可付款日期
						$time = time();
						$order[$k]['start_can_pay'] = $order_class_1_pay + 60*60;	// 3天
						$order[$k]['end_can_pay'] = $order_class_1_pay + 60*60*5;	// 5天
						if($time < $order[$k]['start_can_pay']){	// 判断用户付款后 3 天之内的提示(不可点击)
							$order[$k]['detail_text'] = '未到付款时间';
						}else{
							if($time > $order[$k]['end_can_pay']){	// 判断用户是否已过 5 天的付款日期(不可点击)
								$order[$k]['detail_text'] = '已过付款时间';
							}else{	// 可付款(可点击)
								$order[$k]['detail_text'] = '详情';
								$order[$k]['open_click'] = 1;
							}
						}
					}else{	// 未付
						$order[$k]['detail_text'] = '请先付首款';
					}
				}
			}else{
				$order[$k]['class_text'] = '-';
			}
			// 创建时间
			$order[$k]['create_date'] = date('Y-m-d H:i:s',$v['create_time']);
			// 订单状态
			$dict_where['type'] = 'trade_status';
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
	
	/**
	 * controller 买入订单详情
	 */
	public function buyDet($id){
		if(!$id){
			echo '<script type="text/javascript">alert("未获取订单信息!");window.location.href="/index"</script>';
		}
		
		// 获取匹配订单信息
		$order = Db::name('order') -> where('id',$id) -> find();
		
		// 订单状态
		$dict_where['type'] = 'order_status';
		$dict_where['value'] = $order['order_status'];
		$order['order_status_text'] = Db::name('dict') -> where($dict_where) -> value('key');
		// 隐藏手机号
		$order['real_name'] = Db::name('user') -> where('id',$order['buyer_id']) -> value('real_name');
		$order['account'] = substr_replace(Db::name('user') -> where('id',$order['buyer_id']) -> value('account'),'****',3,4);
		// 打款最迟时间
		$order['last_pay_date'] = date('Y-m-d H:i:s',$order['create_time'] + 60*60*12);
		
		// 获取匹配的卖出交易信息
		$trade_sell_ids = explode(',',$order['trade_sell_ids']);
		foreach($trade_sell_ids as $k => $v){
			$order['trade_sell'][$k] = Db::name('trade_sell') -> where('id',$v) -> find();
			$order['trade_sell'][$k]['start_date'] = date('Y-m-d H:i:s',$order['trade_sell'][$k]['start_time']);
			// 获取卖出人信息
			$sell_user_info = Db::name('user') -> where('id',$order['trade_sell'][$k]['uid']) -> find();	// 账号信息
			$order['trade_sell'][$k]['real_name'] = $sell_user_info['real_name'];					// 卖出人姓名
			$order['trade_sell'][$k]['account'] = substr_replace($sell_user_info['account'],'****',3,4);	// 卖出人手机号
			$card_where['uid'] = $order['trade_sell'][$k]['uid'];
			$card_where['default'] = 2;
			$sell_user_card = Db::name('user_card') -> where($card_where) -> find();	// 默认银行卡信息
			
			// 判断当前用户对某一卖家是否已支付
			$sell = Db::name('trade_sell') -> where('id',$v) -> field('sell_status,pay_type,pay_pic') -> find();
			if($sell['sell_status'] === 1){	// 判断用户未支付
				$order['trade_sell'][$k]['pay']['user_pay_type'] = 1;	// 未支付传到前台判断样式
				$order['trade_sell'][$k]['pay']['alipay_accout'] = $sell_user_info['alipay_accout'];	// 卖出人的支付信息
				$order['trade_sell'][$k]['pay']['wechat_accout'] = $sell_user_info['wechat_accout'];	// 卖出人的微信信息
				$order['trade_sell'][$k]['pay']['bank_name'] = $sell_user_card['bank_name'];			// 卖出人的银行卡银行名
				$order['trade_sell'][$k]['pay']['bank_user'] = $sell_user_card['bank_user'];			// 卖出人的银行卡用户名
				$order['trade_sell'][$k]['pay']['bank_number'] = $sell_user_card['bank_number'];		// 卖出人的银行卡号
			}else{	// 判断用户已支付
				$order['trade_sell'][$k]['pay']['user_pay_type'] = 2;	// 已支付传到前台判断样式
				$order['trade_sell'][$k]['pay']['pay_type'] = $sell['pay_type'];	// 前台判断支付类型
				$order['trade_sell'][$k]['pay']['img_src'] = 'order_xz.png';	// 支付类型选中样式图片
				$order['trade_sell'][$k]['pay']['pay_pic'] = $sell['pay_pic'];	// 支付截图
				// 获取当前用户支付类型
				switch($sell['pay_type']){
					case 1:
						$order['trade_sell'][$k]['pay']['alipay_accout'] = $sell_user_info['alipay_accout'];
						break;
					case 2:
						$order['trade_sell'][$k]['pay']['wechat_accout'] = $sell_user_info['wechat_accout'];
						break;
					case 3:
						$order['trade_sell'][$k]['pay']['bank_name'] = $sell_user_card['bank_name'];
						$order['trade_sell'][$k]['pay']['bank_user'] = $sell_user_card['bank_user'];
						$order['trade_sell'][$k]['pay']['bank_number'] = $sell_user_card['bank_number'];
						break;
				}
			}
		}
		return $order;
	}
	
	/**
	 * model 提交支付单个匹配卖单
	 */
	public function paySell($data){
		if(!$data['id']){
			return ['code' => 0,'msg' => '未获取卖单信息!'];
		}
		if(!$data['trade_buy_id']){
			return ['code' => 0,'msg' => '未获取买单信息!'];
		}
		if(!$data['order_id']){
			return ['code' => 0,'msg' => '未获取订单信息!'];
		}
		if(!$data['type']){
			return ['code' => 0,'msg' => '请选择支付类型!'];
		}
		if($data['pay_pic'] === '/static/ace/img/upload.png'){
			return ['code' => 0,'msg' => '请上传支付截图!'];
		}
		
		Db::startTrans();
		$condition = 0;
		try{
			// 修改 交易卖出信息 
			$sell_mod['sell_status'] = 2;
			$sell_mod['pay_pic'] = $data['pay_pic'];
			$sell_mod['pay_type'] = $data['type'];
			Db::name('trade_sell') -> where('id',$data['id']) -> update($sell_mod);
			
			// 判断修改 买入&订单 状态
			$sell_ids = Db::name('trade_buy') -> where('id',$data['trade_buy_id']) -> value('trade_sell_ids');
			$sell_count = Db::name('trade_sell') -> where('id','in',$sell_ids) -> count();
			$sell_pay_count_where['id'] = array('in',$sell_ids);
			$sell_pay_count_where['pay_type'] = array('neq',null);
			$sell_pay_count = Db::name('trade_sell') -> where('id','in',$sell_ids) -> where('pay_type<>0') -> count();
			if($sell_pay_count === $sell_count){
				// 修改 交易买入信息
				$buy_mod['buy_status'] = 2;
				Db::name('trade_buy') -> where('id',$data['trade_buy_id']) -> update($buy_mod);
				// 修改 订单信息
				$trade_sell_ids = Db::name('order') -> where('id',$data['order_id']) -> value('trade_sell_ids');	// 获取 买入&卖出 订单关联的 trade_sell_ids 的ID
				$trade_sell_ids = explode(',',$trade_sell_ids);
				foreach($trade_sell_ids as $k => $v){	// 修改 买入&卖出 相关联的订单
					$order_mod['order_status'] = 2;
					$order_mod['pay_time'] = time();
					Db::name('order') -> where('trade_sell_ids','LIKE','%'.$v) -> update($order_mod);
				}
			}
			
			$condition = 1;
			Db::commit();
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '提交成功!'];
		}else{
			return ['code' => 0,'msg' => '提交失败!'];
		}
	}
	
	/**
	 * model 卖出订单详情
	 */
	public function sellDet($id){
		if(!$id){
			echo '<script type="text/javascript">alert("未获取订单信息!");window.location.href="/index"</script>';
		}
		
		// 获取匹配订单信息
		$order = Db::name('order') -> where('id',$id) -> find();
		
		// 订单状态
		$dict_where['type'] = 'order_status';
		$dict_where['value'] = $order['order_status'];
		$order['order_status_text'] = Db::name('dict') -> where($dict_where) -> value('key');
		// 隐藏手机号
		$order['real_name'] = Db::name('user') -> where('id',$order['buyer_id']) -> value('real_name');
		$order['account'] = substr_replace(Db::name('user') -> where('id',$order['buyer_id']) -> value('account'),'****',3,4);
		// 打款最迟时间
		$order['last_pay_date'] = date('Y-m-d H:i:s',$order['create_time'] + 60*60*12);
		// 打款时间
		if($order['pay_time']){
			$order['pay_date'] = date('Y-m-d H:i:s',$order['pay_time']);
			// 获取打款信息
			$order['pay_info'] = Db::name('trade_sell') -> where('id',$order['trade_sell_ids']) -> field('pay_pic,pay_type') -> find();
			// 获取卖出人信息
			$sell_user_info = Db::name('user') -> where('id',$order['seller_ids']) -> find();	// 账号信息
			$order['trade_sell']['real_name'] = $sell_user_info['real_name'];					// 卖出人姓名
			$order['trade_sell']['account'] = substr_replace($sell_user_info['account'],'****',3,4);	// 卖出人手机号
			$card_where['uid'] = $order['seller_ids'];
			$card_where['default'] = 2;
			$sell_user_card = Db::name('user_card') -> where($card_where) -> find();	// 默认银行卡信息
			// 获取买家支付当前用户的账户类型
			switch($order['pay_info']['pay_type']){
				case 1:
					$order['pay_info']['pay_account'] = '支付宝  '.$sell_user_info['alipay_accout'];
					break;
				case 2:
					$order['pay_info']['pay_account'] = '微信  '.$sell_user_info['wechat_accout'];
					break;
				case 3:
					$order['pay_info']['pay_account'] = '银行卡  '.$sell_user_card['bank_name'].' '.$sell_user_card['bank_user'].' '.$sell_user_card['bank_number'];
					break;
			}
			if($order['order_status'] === 4 || $order['order_status'] === 3){
				$order['clear_deal_btn'] = 1;
			}
		}else{
			$order['pay_date'] = '-';
		}
		
		// 获取匹配的卖出交易信息
		$order['trade_sell'] = Db::name('trade_sell') -> where('id',$order['trade_sell_ids']) -> find();
		$order['trade_sell']['start_date'] = date('Y-m-d H:i:s',$order['trade_sell']['start_time']);
		// 获取卖出人信息
		$sell_user_info = Db::name('user') -> where('id',$order['trade_sell']['uid']) -> find();	// 账号信息
		$order['trade_sell']['real_name'] = $sell_user_info['real_name'];					// 卖出人姓名
		$order['trade_sell']['account'] = substr_replace($sell_user_info['account'],'****',3,4);	// 卖出人手机号
		
		return $order;
	}
	
	/**
	 * model 提交确认交易
	 */
	public function tradeDeal($data){
		if(!$data['id']){
			return ['code' => 0,'msg' => '未获取订单信息!'];
		}
		if(!$data['trade_sell_ids']){
			return ['code' => 0,'msg' => '未获取交易信息!'];
		}
		
		Db::startTrans();
		$condition = 0;
		try{
			// 修改 买入交易 信息
			$trade_buy_id = Db::name('order') -> where('id',$data['id']) -> value('trade_buy_id');	// 获取 交易买入ID
			$buy_mod['buy_status'] = 4;
			$buy_mod['end_time'] = time();
			Db::name('trade_buy') -> where('id',$trade_buy_id) -> update($buy_mod);
			
			// 修改 订单
			$trade_sell_ids = explode(',',$data['trade_sell_ids']);
			foreach($trade_sell_ids as $k => $v){
				// 修改 卖出交易 信息
				$sell_mod['sell_status'] = 4;
				$sell_mod['end_time'] = time();
				$result = Db::name('trade_sell') -> where('id','LIKE',$v) -> update($sell_mod);
				
				// 修改 订单 信息
				$order_mod['order_status'] = 4;
				$order_mod['done_time'] = time();
				Db::name('order') -> where('trade_sell_ids','LIKE',$v) -> update($order_mod);
			}
			
			$condition = 1;
			Db::commit();
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '提交确认成功!'];
		}else{
			return ['code' => 0,'msg' => '提交确认失败!'];
		}
		
	}
	
	
	
}