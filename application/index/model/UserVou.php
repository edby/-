<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/10
 * Time: 17:22
 */

namespace app\index\model;


use think\Db;
use think\Exception;
use think\Model;

class UserVou extends Model
{

	/**
	 * @param $uid 用户id
	 * @param $bouns_type 消耗的积分类型
	 * @param $bouns_dec_number 积分减少量
	 * @param $vou_type 券类型
	 * @param $vou_inc_number 券增加量
	 * @return array 返回的$r
	 * @throws \think\exception\DbException
	 */
    static public function buy_ticket($uid,$bouns_type,$bouns_dec_number,$vou_type,$vou_inc_number)
	{
		$r = null;
		$r = deal_json(1,'开始处理积分与券');
		$user = User::get(['id'=>$uid]);
		$user_bouns = UserBouns::get(['uid'=>$uid,'bouns_type'=>$bouns_type]);
		if(!$user_bouns){
			return deal_json(-1,'用户数据错误');
		}
		if($user_bouns['bouns_number'] < $bouns_dec_number){
			return deal_json(-1,'积分不足');
		}
		Db::startTrans();
		try{
//			减少相应的积分
			$UserBouns = new UserBouns();
			if(!$UserBouns->where(['uid'=>$uid,'bouns_type'=>$bouns_type])->setDec('bouns_number',$bouns_dec_number)){
				throw new Exception('用户积分不足');
			}
//			增加用户相应券的数量
			$UserVou = new UserVou();
			if(!$UserVou->where(['uid'=>$uid,'vid'=>$vou_type])->setInc('number',$vou_inc_number)){
				throw new Exception('处理用户手续费失败');
			}
			Db::commit();
			return deal_json(1,'购买成功');
		}catch (\Exception $e){
			Db::rollback();
			return deal_json(-1,$e->getMessage());
		}
	}
}