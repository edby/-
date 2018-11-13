<?php
namespace app\index\model;
use app\common\model\Base;
use think\Request;
use think\Session;
class Profit extends Base
{
	private $user;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->user = new User();
    }
	/**
	 * 会员福利
	 */
	public function welfare()
	{
		$id = is_login('uid');//获取ID
		$number = trim(input('number'));//获取数量暂时用不到 因为目前来说不回按照比例
		$myself = $this->user->where('id',$id)->value('level');//本人等级
		$pid = $this->user->where('id',$id)->value('parent_id');//父级ID
		$parent = $this->user->where('id',$pid)->find();//父级信息
		$time = time();
		if($parent){
			//判断一下上级的等级 并且 本人的等级 小于 上级的等级
			if($parent['level'] == 2 && $myself < $parent['level']){

				db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',2);//输入表名 看查询条件 自增字段填写一下 2不用管

				$result = $this->parent($parent['parent_id'],2);

			}elseif($parent['level'] == 3 && $myself < $parent['level']){
				db('user_bonus')->where('uid',$pid)->db('frozen_bouns_number',4);//输入表名 看查询条件 自增字段填写一下 4不用管

				$result = $this->parent($parent['parent_id'],3);

			}elseif($parent['level'] == 4 && $myself < $parent['level']){

				db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',6);//输入表名 看查询条件 自增字段填写一下 6不用管

				$result = $this->parent($parent['parent_id'],4);

			}elseif($parent_['level'] == 5 && $myself < $parent['level']){
				//本人的父级等级如果是5 那么代表着 本人直属 董事级管理 只给予董事级福利
				db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',10);//输入表名 看查询条件 自增字段填写一下 10不用管
			}else{
				return array(0,'该会员的上级没有福利');
			}
		}else{
			return array(0,'该会员没有上级');
		}
	}
	/**
	 * 查询上级
	   $id 是判断里面传过来的父级ID 通过这个ID查询这个父级的父级信息
	   $type 一个判断 参数2 3 4
	 */
	public function parent($id,$type)
	{
		$myself = $this->user->where('id',$id)->value('level');//本人等级
		$pid = $this->user->where('id',$id)->value('parent_id');//父级ID
		$parent = $this->user->where('id',$pid)->find();//父级信息
		if($type == 2){
			if($myself < $parent['level']){
				if($myself < $parent['level'] && $parent['level'] == 3){
					db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',2); 
					$this->orther_cases($parent['parent_id'],3);
				}elseif($myself < $parent['level'] && $parent['level'] == 4){
					db('user_bonus')->where('uid',$pid)->db('frozen_bouns_number',4); 
					$this->orther_cases($parent['parent_id'],4);
				}elseif($myself < $parent['level'] && $parent['level'] == 5){
					db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',8);
				}else{
					return array(0,'该会员没有上级');
				}
			}
		}elseif($type == 3) {
			if($myself < $parent['level'] && $parent['level'] == 4){
				db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',2);//输入表名 看查询条件 自增字段填写一下 2不用管
				$this->orther_cases($parent['parent_id'],4);
			}elseif($myself < $parent['level'] && $parent['level'] == 5){
				db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',6);//输入表名 看查询条件 自增字段填写一下 2不用管
			}else{
				return array(0,'该会员没有上级');
			}
		}elseif($type == 4){
			if($myself < $parent['level']){
				//如果我的等级 小于 上级等级 必定等于5 如果不等于五就到头了
				db('user_bonus')->where('uid',$pid)->db('frozen_bouns_number',4);
			}else{
				return array(0,'该会员没有上级');
			}
		}
	}
	/**
	 * 查询上级
	   $id 是判断里面传过来的是父级的父级ID 通过这个ID查询这个父级的父级的父级信息
	   $type 一个判断 参数 3 4
	 */
	public function orther_cases($id,$type){
		$myself = $this->user->where('id',$id)->value('level');//本人等级
		$pid = $this->user->where('id',$id)->value('parent_id');//父级ID
		$parent = $this->user->where('id',$pid)->find();//父级信息
		if($type == 3){
			if($myself < $parent['level'] && $parent['level'] == 4){
				db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',2);
				$this->orther_data($parent['parent_id']);
			}elseif($myself < $parent['level'] && $parent['level'] == 5){
				db('user_bonus')->where('uid',$pid)->setInc('frozen_bouns_number',6);
			}else{
				return array(0,'该会员没有上级');
			}
		}else{
			if($myself < $parent['level']){
				//如果我的等级 小于 上级等级
				db('user_bonus')->where('uid',$parent['id'])->db('frozen_bouns_number',4);//输入表名 看查询条件 自增字段填写一下 4不用管
			}
		}
	}
	/**
	 * 查询上级
	   $id 是判断里面传过来的是父级的父级ID 通过这个ID查询这个父级的父级的父级信息
	   $type 一个判断 参数 4
	 */
	  public function orther()
	  {
	  	$myself = $this->user->where('id',$id)->value('level');//本人等级
		$pid = $this->user->where('id',$id)->value('parent_id');//父级ID
		$parent = $this->user->where('id',$pid)->find();//父级信息
		if($myself < $parent['level']){
			//如果我的等级 小于 上级等级
			db('user_bonus')->where('uid',$parent['id'])->setInc('frozen_bouns_number',4);//输入表名 看查询条件 自增字段填写一下 4不用管
		}else{
			return array(0,'该会员没有上级');
		}
	  }
}