<?php
namespace app\admin\model;

use app\common\model\Base;
use think\Request;
use think\Db;

class Method extends Base
{
	const PAGE_LIMIT = 10;	// 用户表分页限制
	const PAGE_SHOW = 10;	// 显示分页菜单数量
	
    public function index($map, $p){
        $list = db('order') -> where($map) -> order('create_time DESC') -> page($p, self::PAGE_LIMIT) -> select();
        $count = db('order') -> where($map) -> count();
       	foreach($list as $k=>$v){
        	// 买家信息
        	$list[$k]['buy_name'] = db('user')->where('id',$v['buyer_id'])->value('account');
          	$name = db('user')->where('id',in,$v['seller_ids'])->field('account')->select();
          	foreach ($name as $kk=>$vv){
            	$names[$kk] = $vv['account'];
            }
            
            // 状态
          	$list[$k]['sell_name'] = implode(',',$names); 
          	if($v['trade_type'] == 1){
            	$list[$k]['trade_type_text'] = '出售';
            	$list[$k]['trade_btn'] = 'type_sell';
            }else{
            	$list[$k]['trade_type_text'] = '求购';
            	$list[$k]['trade_btn'] = 'type_buy';
            }
            
            // 订单状态
            $dict_where['type'] = 'trade_status';
            $dict_where['value'] = $v['order_status'];
          	$list[$k]['order_status_text'] = Db::name('dict') -> where($dict_where) -> value('key');
            
            // 日期格式
          	$list[$k]['create_date'] = date('Y-m-d H:i:s',$v['create_time']);
          	$list[$k]['pay_date'] = $v['pay_time']?date('Y-m-d H:i:s',$v['pay_time']):'暂无';
          	$list[$k]['done_date'] = $v['done_time']?date('Y-m-d H:i:s',$v['done_time']):'暂无';
        }
        $return['count'] = $count;
        $return['list'] = $list;
        $request= Request::instance();
        $return['page'] = boot_page($return['count'], self::PAGE_LIMIT, self::PAGE_SHOW, $p,$request -> action());
        return $return;
    }
}


