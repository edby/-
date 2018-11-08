<?php
namespace  app\index\model;

use app\common\model\Base;
use think\Request;
use think\Db;
use think\Session;
class User extends Base
{

    const PAGE_LIMIT = '5';//用户表分页限制
    const PAGE_SHOW = '10';//显示分页菜单数量

    protected $insert = ['invitation_code','wallet']; 

    protected function setPasswordAttr($value)
    {
        return encrypt(trim($value));
    }

    /**
    *自动生成邀请码
    */
    public function setInvitationCodeAttr()
    {
        return make_coupon_card();
    }

    /**
     * 用户登录
     * @param  array $data 用户登录信息
     * @return array       返回登录结果
     */
    public function userLogin($data)
    {
        if (!$data['account'] || !$data['password']) {
            return array('code'=>0,'msg'=>'请填写完整!');
        }
        if(false == ($info = $this->where(['account'=>$data['account']])->find()) ){
            return array('code'=>0,'msg'=>'账号不存在!');
        }
        if($info['status'] == 2){
            return array('code'=>0,'msg'=>'禁止登录!');
        }
        if($info['password'] != encrypt(trim($data['password'])) ){
            return array('code'=>0,'msg'=>'密码不正确');
        }
        session('uid', $info['id']);
//        print_r($_SESSION);
//        exit();
        session('account', $info['account']);
        return array('code'=>1,'msg'=>'登录成功','url'=>url('Index/index'));
    }
	
	/**
	 * 注册获取验证码
	 */
	public function getVerify($data){
		if(!$data['account']){
 			return ['code' => 0,'msg' => '请输入手机号码!'];
 		}else{
 			if(is_phone($data['account']) === false){
 				return json(['code' => 0,'msg' => '手机号码格式不正确!']);
 			}
 			$exist = Db::name('user') -> where('account',$data['account']) -> find();
			switch($data['type']){
				case 1:
					if($exist){
						return ['code' => 0,'msg' => '该手机号已存在!'];
					}
					break;
				case 2:
					if(!$exist){
						return ['code' => 0,'msg' => '该手机号尚未注册!'];
					}
					break;
			}
 		}
 		
 		$code = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
 		return ['code' => 1,'msg' => '获取验证码成功!','data' => $code];
	}
	
    /**
     * 用户注册
     * @param  array $data 注册信息
     */
    public function userReg($data)
    {
    	if(!$data['account']){
    		return ['code' => 0,'msg' => '请输入手机号码!'];
    	}
    	if(!$data['password'] || !$data['repassword']){
    		return ['code' => 0,'msg' => '请输入密码!'];
    	}else{
    		if($data['password'] != $data['repassword']){
    			return ['code' => 0,'msg' => '两次输入的密码不同!'];
    		}
    		// 判断密码
	        if(!$data['password'] || strlen($data['password'] < 5)){
	        	return ['code' => 0,'msg' => '请输入不小于6位的密码'];
	       	}else{
	       		if($data['password'] != $data['repassword']){
	       			return ['code' => 0,'msg' => '两次输入的密码不同!'];
	       		}
	       	}
    	}
    	
    	// 判断用户名
    	if($data['account']){
    		$exist_account = Db::name('user') -> where('account',$data['account']) -> find();
    		if($exist_account){
				return ['code' => 0,'msg' => '用户账号已存在!'];
			}
    	}
        
        $data['password'] = encrypt(trim($data['password']));
        $data['invitation_code'] = make_coupon_card();
		$data['create_time'] = time();
		$data['status'] = 1;
		unset($data['code']);
		unset($data['repassword']);
		
		Db::startTrans();
		$condition = 0;
		try{
			// 注册用户
			$result_id = Db::name('user') -> insertGetId($data);
			
			// 在用户券表中添加信息
			$voucher = Db::name('voucher') -> field('id') -> select();
			foreach($voucher as $k => $v){
				$vou_in['uid'] = $result_id;
				$vou_in['vid'] = $v['id'];
				Db::name('user_vou') -> insert($vou_in);
			}
			
			// 在用户奖金中添加信息
			$dict_where['type'] = 'bouns_type';
			$bouns = Db::name('dict') -> where($dict_where) -> field('value') -> select();
			foreach($bouns as $k => $v){
				$bouns_in['uid'] = $result_id;
				$bouns_in['bouns_type'] = $v['value'];
				Db::name('user_bouns') -> insert($bouns_in);
			}
			
			Db::commit();
			$condition = 1;
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '注册成功!','url' => url('login')];
		}else{
			return ['code' => 0,'msg' => '注册失败!'];
		}
    }
 	
    /**
     * 忘记密码
     */
    public function forgetPwd($data)
    {
        if(trim($data['account'])){
        	$exist = $this -> where('account',$data['account']) -> find();
        	if(!$exist){
        		return ['code' => 0,'msg' => '该用户不存在!'];
        	}
        }
        
        if($data['user_verify'] != $data['verify']){
        	return ['code' => 0,'msg' => '验证码错误!'];
        }
        
        $where['account'] = $data['account'];
        $mod['password'] = encrypt(trim($data['password']));
        
        $result = $this -> where($where) -> update($mod);
        if($result){
        	return ['code' => 1,'msg' => '修改成功!'];
        }else{
        	return ['code' => 0,'msg' => '修改失败!'];
        }
    }

    /**
     * 修改密码
     * @param  array $data 传入数据
     */
    public function editPwd($data)
    {
        // 判断密码
        if(!$data['password'] || strlen($data['password'] < 5)){
        	return ['status' => 0,'info' => '请输入不小于6位的密码'];
       	}else{
       		if($data['password'] != $data['repassword']){
       			return ['status' => 0,'info' => '两次输入的密码不同!'];
       		}
       	}
       	
        $data['password'] = encrypt(trim($data['password']));
        if(!$this->save($data)){
            return ['status'=>'0','info'=>'修改密码失败!'];
        }
        return ['status'=>1,'info'=>'修改密码成功!','url'=>url('Public/logout')];
    }
	
	/**
	 * model 用户信息
	 */
	public function userInfo($uid){
		$user = Db::name('user') -> where('id',$uid) -> find();
		// 用户等级
		$dict_where['type'] = 'user_level';
		$dict_where['value'] = $user['level'];
		$user['level_text'] = Db::name('dict') -> where($dict_where) -> value('key');
		// 用户状态
		switch($user['status']){
			case 1:
				$user['status_text'] = '正常';
				break;
			case 2:
				$user['status_text'] = '已禁用';
				break;
		}
		return $user;
	}
	
    /**
     * model 修改用户信息
     */
    public function editUser($data)
    {
    	Db::startTrans();
    	$condition = 0;
    	try{
    		// 扣除用户的 修改券
    		$user_vou_where['uid'] = session('uid');
    		$user_vou_where['vid'] = 3;
    		Db::name('user_vou') -> where($user_vou_where) -> setDec('number');
    		
    		// 修改用户信息
    		$data['update_time'] = time();
        	$data['is_set'] = 1;
        	Db::name('user') -> where('id',session('uid')) -> update($data);
    		
    		$condition = 1;
    		Db::commit();
    	}catch(\exception $e){
    		Db::rollback();
    	}
    	
        if($condition === 1){
        	return ['code' => 1, 'msg' => '设置成功!'];
        }else{
        	return ['code' => 0, 'msg' => '设置失败!'];
        }
    }
	
	/**
	 * model 用户券
	 */
	public function userVou($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['vid']){
			return ['code' => 0,'msg' => '未获取券信息!'];
		}
		
		$user_vou = Db::name('user_vou') -> where($data) -> value('number');
		return ['code' => 1,'num' => $user_vou];
	}
	
	/**
	 * model 用户钱包
	 */
	public function userWallet($uid){
		/** 用户积分 **/
		// 用户账户奖金
		$dict_where['type'] = 'bouns_type';
		$dict = Db::name('dict') -> where($dict_where) -> field('value') -> select();
		$bouns_where['uid'] = $uid;
		foreach($dict as $k => $v){
			switch($v['value']){
				case 1:
					$bouns_where['bouns_type'] = $v['value'];
					$static = Db::name('user_bouns') -> where($bouns_where) -> sum('bouns_number');		// 静态奖金
					break;
				case 2:
					$bouns_where['bouns_type'] = $v['value'];
					$dynamic = Db::name('user_bouns') -> where($bouns_where) -> sum('bouns_number');	// 动态奖金
					break;
				case 3:
					$bouns_where['bouns_type'] = $v['value'];
					$welfare = Db::name('user_bouns') -> where($bouns_where) -> sum('bouns_number');	// 福利奖金
					break;
			}
		}
		$user_bouns = $static + $dynamic + $welfare;	// 未冻结奖金
		
		// 冻结奖金
		
		
		// 积分(所有奖金)
		
		
		
		/** 用户券 **/
		$voucher = Db::name('voucher') -> field('id,name,is_sell') -> select();
		foreach($voucher as $k => $v){
			$user_where['uid'] = $uid;
			$user_where['vid'] = $v['id'];
			$voucher[$k]['number'] = Db::name('user_vou') -> where($user_where) -> value('number');		// 券数量
			if($v['id'] === 6){
				$voucher[$k]['text'] = '';
			}else{
				$voucher[$k]['text'] = '张';
			}
		}
		
		$wallet['voucher'] = $voucher;
		
		return $wallet;
	}
	
	/**
	 * model 用户奖金额
	 */
	public function userBouns($uid){
		// 解冻区
		$bouns['thaw_bouns'] = Db::name('user_bouns') -> where('uid',$uid) -> select();
		foreach($bouns['thaw_bouns'] as $k => $v){
			$dict_where['type'] = 'bouns_type';
			$dict_where['value'] = $v['bouns_type'];
			$bouns['thaw_bouns'][$k]['name'] = Db::name('dict') -> where($dict_where) -> value('key');
		}
		// 冻结区
		$bouns['frozen_bouns'] = null;
		return $bouns;
	}
	
	/**
	 * model 执行奖金转券
	 */
	public function changeBonus($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['bouns_type']){
			return ['code' => 0,'msg' => '未获取奖金类型!'];
		}
		if(!$data['number']){
			return ['code' => 0,'msg' => '请输入要转换的数量!'];
		}else{
			$user_bouns_where['uid'] = $data['uid'];
			$user_bouns_where['bouns_type'] = $data['bouns_type'];
			$user_bouns = Db::name('user_bouns') -> where($user_bouns_where) -> value('bouns_number');
			if($user_bouns < $data['number']){
				return ['code' => 0,'msg' => '超出最大转换数量!'];
			}
		}
		
		Db::startTrans();
		$condition = 0;
		try{
			// 减去用户相应的奖金数量
			Db::name('user_bouns') -> where($user_bouns_where) -> setDec('bouns_number',$data['number']);
			// 增加用户消费券数量
			$user_vou_where['uid'] = $data['uid'];
			$user_vou_where['vid'] = 6;
			Db::name('user_vou') -> where($user_vou_where) -> setInc('number',$data['number']);
			
			$condition = 1;
			Db::commit();
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '转换成功!'];
		}else{
			return ['code' => 0,'msg' => '转换失败!'];
		}
	}
	
	/**
	 * model 提现
	 */
	public function withdraw($uid){
		// 奖金列表
		$bouns = Db::name('user_bouns') -> where('uid',$uid) -> order('bouns_type ASC') -> select();
		foreach($bouns as $k => $v){
			$dict_where['type'] = 'bouns_type';
			$dict_where['value'] = $v['bouns_type'];
			$bouns[$k]['name'] = Db::name('dict') -> where($dict_where) -> value('key');
			switch($v['bouns_type']){
				case 1:
					$bouns[$k]['select'] = '#static';
					$bouns[$k]['short_name'] = '静态';
					$bouns[$k]['div_id'] = 'static';
					break;
				case 2:
					$bouns[$k]['select'] = '#active';
					$bouns[$k]['short_name'] = '动态';
					$bouns[$k]['div_id'] = 'active';
					break;
				case 3:
					$bouns[$k]['select'] = '#welfare';
					$bouns[$k]['short_name'] = '福利';
					$bouns[$k]['div_id'] = 'welfare';
					break;
			}
			
			// 用户的银行卡
			$user_card_where['uid'] = $uid;
			$user_card_where['default'] = 2;
			$bouns[$k]['bank'] = Db::name('user_card') -> where($user_card_where) -> find();
			$bouns[$k]['bank']['bank_number'] = substr_replace($v['bank_number'],'********',4,12);
		}
		
		return $bouns;
	}
	
	/**
	 * model 提现规则
	 */
	public function withdrawRule(){
		$page = Db::name('page') -> where('id=3') -> find();
		return $page;
	}
	
	/**
	 * model 点击提现
	 */
	public function doWithdraw($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['type']){
			return ['code' => 0,'msg' => '未获取提现类型!'];
		}
		if(!$data['bonus_number']){
			return ['code' => 0,'msg' => '请填写提现数额!'];
		}else{
			if(!is_int($data['bonus_number']/100)){
				return ['code' => 0,'msg' => '提现须为100的倍数!'];
			}
		}
		if(!$data['user_card_id']){
			return ['code' => 0,'msg' => '请选择提现账户!'];
		}
		
		
		/*
		$data['service_charge'] = $data['cur_num'] - $data['service_charge'];
		$data['cur_num'] = '-'.$data['cur_num'];
		$data['cur_id'] = 1;
		$data['status'] = 1;
		$data['method_type'] = 2;
		$data['recharge_status'] = 1;
		$data['create_time'] = time();
		unset($data['payment_password']);
		$withdraw_id = Db::name('method') -> insertGetId($data);
		$data = Db::name('method') -> where('id',$withdraw_id) -> field('id,wallet_adress,cur_num,recharge_status,create_time') -> find();
		// 日期
		$data['create_date'] = date('Y-m-d H:i:s',$data['create_time']);
		// 提现状态
		$dict_where['type'] = 'identity_status';
		$dict_where['value'] = $data['recharge_status'];
		$data['recharge_status_text'] = Db::name('dict') -> where($dict_where) -> value('key');
		// 实际到账
		if($data['recharge_status'] === 2){
			$data['actual'] = trim($data['recharge_status'],'-') - $data['service_charge'];
		}else{
			$data['actual'] = 0;
		}
		
		if($data){
			return ['code' => 1,'msg' => '申请提现成功!','en_msg' => 'Apply for withdrawal!','data' => $data];
		}else{
			return ['code' => 0,'msg' => '申请提现失败!','en_msg' => 'Application withdrawal failed!'];
		}
		*/
	}
	
	/**
	 * model 获取券名称
	 */
	public function getVou(){
		$voucher = Db::name('voucher') -> field('id,name') -> select();
		foreach($voucher as $k => $v){
			switch($v['id']){
				case 1:
					$voucher[$k]['href'] = '#off';
					$voucher[$k]['div_id'] = 'off';
					break;
				case 2:
					$voucher[$k]['href'] = '#tip';
					$voucher[$k]['div_id'] = 'tip';
					break;
				case 3:
					$voucher[$k]['href'] = '#change';
					$voucher[$k]['div_id'] = 'change';
					break;
				case 4:
					$voucher[$k]['href'] = '#activation';
					$voucher[$k]['div_id'] = 'activation';
					break;
				case 5:
					$voucher[$k]['href'] = '#enter';
					$voucher[$k]['div_id'] = 'enter';
					break;
				case 6:
					$voucher[$k]['href'] = '#con';
					$voucher[$k]['div_id'] = 'con';
					break;
			}
		}
		return $voucher;
	}
	
	/**
	 * model 执行转账
	 */
	public function doTransfer($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['vid']){
			return ['code' => 0,'msg' => '未获取券信息!'];
		}
		if(!$data['number']){
			return ['code' => 0,'msg' => '请输入转账数量!'];
		}else{
			$vou_where['uid'] = $data['uid'];
			$vou_where['vid'] = $data['vid'];
			$user_vou_number = Db::name('user_vou') -> where($vou_where) -> value('number');
			if($data['number'] > $user_vou_number){
				return ['code' => 0,'msg' => '超出您的库存!'];
			}
		}
		if(!$data['account']){
			return ['code' => 0,'msg' => '请输入转账账户!'];
		}else{
			$exist = Db::name('user') -> where('account',$data['account']) -> find();
			if(!$exist){
				return ['code' => 0,'msg' => '该账户不存在!'];
			}
		}
		
		Db::startTrans();
		$condition = 0;
		try{
			// 扣除当前用户账户中的券数量
			Db::name('user_vou') -> where($vou_where) -> setDec('number',$data['number']);
			
			// 为目标用户账户添加相应的数量
			$vou_where['uid'] = $exist['id'];
			Db::name('user_vou') -> where($vou_where) -> setInc('number',$data['number']);
			
			Db::commit();
			$condition = 1;
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '转账成功!'];
		}else{
			return ['code' => 1,'msg' => '转账失败!'];
		}
	}
	
	/**
	 * model 用户银行卡列表
	 */
	public function userCard($uid){
		$list = Db::name('user_card') -> where('uid',$uid) -> order('default','DESC') -> select();
		foreach($list as $k => $v){
			$list[$k]['bank_number'] = substr_replace($v['bank_number'],'********',4,12);
			switch($v['default']){
				case 1:
					$list[$k]['default_class'] = 'default';
					$list[$k]['default_text'] = '设置为默认卡';
					break;
				default:
					$list[$k]['default_class'] = 'default_btn';
					$list[$k]['default_text'] = '默认银行卡';
			}
		}
		return $list;
	}
	
	/**
	 * model 设置默认银行卡
	 */
	public function setBankDefault($data){
		if(!$data['id']){
			return ['code' => 0,'msg' => '未获取银行卡信息!'];
		}
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['type']){
			return ['code' => 0,'msg' => '未获取银行卡状态!'];
		}
		
		Db::startTrans();
		$condition = 0;
		try{
			// 设置该ID的银行卡为默认银行卡
			$where['id'] = $data['id'];
			$where['uid'] = $data['uid'];
			$mod['default'] = $data['type'];
			Db::name('user_card') -> where($where) -> update($mod);
			
			// 修改该用户其它的银行卡为非默认银行卡
			$where2['uid'] = $data['uid'];
			$where2['id'] = array('neq',$data['id']);
			Db::name('user_card') -> where($where2) -> update(['default' => 1]);
			
			$condition = 1;
			Db::commit();
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '设置默认银行卡成功!'];
		}else{
			return ['code' => 0,'msg' => '设置默认银行卡失败!'];
		}
	}
	
	/**
	 * model 解绑银行卡
	 */
	public function bankUntie($id){
		if(!$id){
			return ['code' => 0,'msg' => '未获取银行卡信息!'];
		}
		
		$result = Db::name('user_card') -> where('id',$id) -> delete();
		if($result){
			return ['code' => 1,'msg' => '解绑银行卡成功!'];
		}else{
			return ['code' => 0,'msg' => '解绑银行卡失败!'];
		}
	}
	
    /**
	 * model 点击绑定银行卡
	 */
	public function bandBank($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['bank_user']){
			return ['code' => 0,'msg' => '请输入账户名!'];
		}
		if(!$data['bank_name']){
			return ['code' => 0,'msg' => '请输入银行名称!'];
		}
		if(!$data['bank_number']){
			return ['code' => 0,'msg' => '请输入银行卡号!'];
		}
		if(!$data['bank_branch']){
			return ['code' => 0,'msg' => '请输入分行名称!'];
		}
		$data['create_time'] = time();
		$result = Db::name('user_card') -> insert($data);
		if($result){
			return ['code' => 1,'msg' => '绑定银行卡成功!'];
		}else{
			return ['code' => 0,'msg' => '绑定银行卡失败!'];
		}
	}
	
	/**
	 * model 修改密码
	 */
	public function modPwd($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['payment_password'] || !$data['re_payment_password']){
			return ['code' => 0,'msg' => '请输入安全密码!'];
		}else{
			if(!preg_match('/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9]{8,14}/',$data['payment_password'])){
				return ['code' => 0,'msg' => '安全密码必须为8~14位并包含大小写和数字!'];
			}
			if($data['payment_password'] != $data['re_payment_password']){
				return ['code' => 0,'msg' => '两次输入的安全密码不相同!'];
			}
			$data['payment_password'] = encrypt(trim($data['payment_password']));
		}
		
		$result = Db::name('user') -> where('id',$data['uid']) -> update(['payment_password' => $data['payment_password']]);
		if($result){
			return ['code' => 1,'msg' => '修改成功!'];
		}else{
			return ['code' => 0,'msg' => '修改失败!'];
		}
	}
	
	/**
	 * model 地址列表
	 */
	public function addressList($uid){
		$list = Db::name('user_addr') -> where('uid',$uid) -> order('default','DESC') -> select();
		foreach($list as $k => $v){
			switch($v['default']){
				case 1:
					$list[$k]['default_class'] = 'default';
					$list[$k]['default_text'] = '设置为默认卡';
					break;
				default:
					$list[$k]['default_class'] = 'default_btn';
					$list[$k]['default_text'] = '默认银行卡';
			}
		}
		return $list;
	}
	
	/**
	 * model 添加地址
	 */
	public function addAddr($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['username']){
			return ['code' => 0,'msg' => '请输入您的姓名!'];
		}
		if(!$data['tel']){
			return ['code' => 0,'msg' => '请输入您的手机号!'];
		}
		if(!$data['address']){
			return ['code' => 0,'msg' => '请输入您的收货地址!'];
		}
		$data['create_time'] = time();
		
		$result = Db::name('user_addr') -> insert($data);
		if($result){
			return ['code' => 1,'msg' => '添加收货地址成功!'];
		}else{
			return ['code' => 0,'msg' => '添加收货地址失败!'];
		}
	}
	
	/**
	 * model 编辑地址信息
	 */
	public function editAddrInfo($id){
		if(!$id){
			return ['code' => 0,'msg' => '未获取地址信息!'];
		}
		$info = Db::name('user_addr') -> where('id',$id) -> find();
		if($info){
			return ['code' => 1,'data' => $info];
		}else{
			return ['code' => 0,'msg' => '获取地址信息失败!'];
		}
	}
	
	/**
	 * model 编辑地址
	 */
	public function editAddr($data){
		if(!$data['id']){
			return ['code' => 0,'msg' => '未获取地址信息!'];
		}
		if(!$data['username']){
			return ['code' => 0,'msg' => '请输入您的姓名!'];
		}
		if(!$data['tel']){
			return ['code' => 0,'msg' => '请输入您的手机号!'];
		}
		if(!$data['address']){
			return ['code' => 0,'msg' => '请输入您的收货地址!'];
		}
		
		$where['id'] = $data['id'];
		$mod['username'] = $data['username'];
		$mod['tel'] = $data['tel'];
		$mod['address'] = $data['address'];
		$result = Db::name('user_addr') -> where($where) -> update($mod);
		if($result){
			return ['code' => 1,'msg' => '编辑地址成功!'];
		}else{
			return ['code' => 0,'msg' => '编辑地址失败!'];
		}
	}
	
	/**
	 * model 设置默认地址
	 */
	public function setAddrDefault($data){
		if(!$data['id']){
			return ['code' => 0,'msg' => '未获取地址信息!'];
		}
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}
		if(!$data['type']){
			return ['code' => 0,'msg' => '未获取地址状态!'];
		}
		
		Db::startTrans();
		$condition = 0;
		try{
			// 设置该ID的地址为默认地址
			$where['id'] = $data['id'];
			$where['uid'] = $data['uid'];
			$mod['default'] = $data['type'];
			Db::name('user_addr') -> where($where) -> update($mod);
			
			// 修改该用户其它的地址为非默认地址
			$where2['uid'] = $data['uid'];
			$where2['id'] = array('neq',$data['id']);
			Db::name('user_addr') -> where($where2) -> update(['default' => 1]);
			
			$condition = 1;
			Db::commit();
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '设置默认地址成功!'];
		}else{
			return ['code' => 0,'msg' => '设置默认地址失败!'];
		}
	}
	
	/**
	 * model 删除地址
	 */
	public function delAddr($id){
		if(!$id){
			return ['code' => 0,'msg' => '未获取地址信息!'];
		}
		$result = Db::name('user_addr') -> where('id',$id) -> delete();
		if($result){
			return ['code' => 1,'msg' => '删除地址成功!'];
		}else{
			return ['code' => 0,'msg' => '删除地址失败!'];
		}
	}
	
	/**
	 * model 关于我们
	 */
	public function aboutUs(){
		$page = Db::name('page') -> where('id=2') -> find();
		return $page;
	}
	
	
	
	/**
	 * model 我的订单
	 */
	public function my_order(){
		
	}
	
	/**
	 * model 入驻商城申请
	 */
	public function join_shop($data){
		if(!$data['uid']){
			return ['code' => 0,'msg' => '未获取用户信息!'];
		}else{
			// 判断是否达到入驻条件
			$user = Db::name('user') -> where('id',$data['uid']) -> field('level') -> find();
			if($user['level'] === 1){
				return ['code' => 0,'msg' => '很抱歉，您还未达到入驻条件!'];
			}
			
			// 判断是否已入驻
			$exist = Db::name('user_shop') -> where('uid',$data['uid']) -> field('examine') -> find();
			if($exist){
				switch($exist['examine']){
					case 1:
						return ['code' => 0,'msg' => '您的信息已提交，请等待审核!'];
						break;
					case 2:
						return ['code' => 0,'msg' => '您已入驻为商家了!'];
						break;
					case 3:
						return ['code' => 0,'msg' => '您的审核未通过!'];
						break;
				}
			}
			
			// 判断用户是否有入驻券
			$user_vou_where['uid'] = $data['uid'];
			$user_vou_where['vid'] = 5;
			$user_vou = Db::name('user_vou') -> where($user_vou_where) -> value('number');
			if($user_vou === 0){
				return ['code' => 0,'msg' => '请先购买入驻券!'];
			}
		}
		if(!$data['contact']){
			return ['code' => 0,'msg' => '请填写公司法人!'];
		}
		if(!$data['contact_file']){
			return ['code' => 0,'msg' => '请填写法人身份证号!'];
		}
		if(!$data['business']){
			return ['code' => 0,'msg' => '请填写经营范围!'];
		}
		if(!$data['tel']){
			return ['code' => 0,'msg' => '请填写手机号码!'];
		}
		if(!$data['address']){
			return ['code' => 0,'msg' => '请填写详细地址!'];
		}
		if(!$data['license']){
			return ['code' => 0,'msg' => '请上传营业执照!'];
		}
		$data['create_time'] = time();
		
		Db::startTrans();
		$condition = 0;
		try{
			// 扣除用户的入驻券
			Db::name('user_vou') -> where($user_vou_where) -> setDec('number');
			// 向 用户商城申请详情表 添加信息
			Db::name('user_shop') -> insert($data);
			$condition = 1;
			Db::commit();
		}catch(\exception $e){
			Db::rollback();
		}
		
		if($condition === 1){
			return ['code' => 1,'msg' => '信息已提交，请等待审核!'];
		}else{
			return ['code' => 0,'msg' => '提交申请失败!'];
		}
	}
	
}