<?php
namespace app\index\controller;

use app\common\controller\Base;
use think\Db;
use think\Request;
use think\Session;
use think\Exception;

class User extends Base
{
	
	/**
	 * controller 判断用户是否被禁用
	 */
	public function user_status($uid){
		return json(model('User') -> userStatus($uid));
	}
	
    /**
     * controller 去帮新会员注册
     */
    public function userreg()
    {
        if (Request::instance()->isPost()) {
            return json(model('User') -> userReg(input('post.')));
        }
        // 获取用户ID
		$uid = is_login($uid);
		$this -> assign('uid',$uid);
		$this -> assign('user',model('User') -> userInfo($uid));
        return $this -> fetch();
    }
	
	/**
	 * controller 注册获取手机验证码
	 */
	public function get_verify($account){
		return json(model('User') -> getVerify(input('post.')));
	}
	
	/**
	 * controller 个人中心
	 */
	public function usercenter(){
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('uid',$uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		if(Request::instance() -> isPost()){
			return json(model('User') -> join_shop(input('post.')));
		}
		return $this -> fetch();
	}
	
	/**
	 * controller 完善/修改个人信息
	 */
	public function editUser(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> editUser(input('post.')));
		}
	}
	
	/**
	 *  controller 获取用户券
	 */
	public function user_vou(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> userVou(input('post.')));
		}
	}
	
	/**
	 * 钱包
	 */
	public function wallet(){
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('uid',$uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('wallet',model('User') -> userWallet($uid));
		$this -> assign('bouns_in_outcome',model('User') -> userInOutcome($uid));
		return $this -> fetch();
	}
	
	/**
	 * controller 奖金
	 */
	public function bonus(){
		// 执行奖金转消费券
		if(Request::instance() -> isPost()){
			return json(model('User') -> changeBonus(input('post.')));
		}
		
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('bonus',model('User') -> userBouns($uid));
		return $this -> fetch();
	}


	public function active_user()
	{
		$r = [
			'code'=>1,
			'msg'=>'初始化用户激活方法',
		];
		$user_active = Db::name('user_vou')->where(['uid'=>$_SESSION['think']['uid'],'vid'=>4])->find();
//		检查用户激活券状态
		if(!($user_active && $user_active['number'] >0)){
			$r = [
				'code'=>-1,
				'msg'=>'用户激活券不足2张',
			];
			return json_encode($r);
		}
		Db::startTrans();
		try{
			$user_info = Db::name('user')->where(['id'=>$_SESSION['think']['uid']])->find();
//		用户为三类封号
			if($user_info['status'] != 3){
				throw new Exception('非封号类禁用!请联系上级进行激活');
			}
			if(!Db::name('user')->where(['id'=>$_SESSION['think']['uid']])->update(['status'=>1])){
				throw new Exception("修改用户状态失败");
			}
			if(!Db::name('user_vou')->where(['uid'=>$_SESSION['think']['uid'],'vid'=>4])->setDec('number',2)){
				throw new Exception('修改用户激活券失败');
			}
			Db::commit();
			$r = [
				'code'=>1,
				'msg'=>'激活成功'
			];

		}catch (\Exception $e){
			Db::rollback();
			$r = [
				'code'=>-1,
				'msg'=>$e->getMessage()
			];
		}
		return json_encode($r);
	}

	/**
	 * controller 提现
	 */
	public function withdraw(){
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('list',model('User') -> withdraw($uid));
		$this -> assign('page',model('User') -> withdrawRule());
		$this -> assign('count',model('User') -> withdrawCount($uid));
		return $this -> fetch();
	}
	
	/**
	 * controller 点击提现
	 */
	public function do_withdraw(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> doWithdraw(input('post.')));
		}
	}
	
	/**
     * controller 提现列表分页 (layui分页)
     */
    public function withdraw_list(){
    	if(Request::instance() -> isPost()){
    		return json(model('User') -> withdrawList(input('post.')));
    	}
    }
	
	/**
	 * controller 转账
	 */
	public function transfer(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> doTransfer(input('post.')));
		}
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('voucher',model('User') -> getVou());
		$this -> assign('count',model('User') -> transferCount($uid));
		return $this -> fetch();
	}
	
	/**
     * controller 转账列表分页 (layui分页)
     */
    public function transfer_list(){
    	if(Request::instance() -> isPost()){
    		return json(model('User') -> transferList(input('post.')));
    	}
    }
	
	/**
	 * controller 银行卡
	 */
	public function bank(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> bandBank(input('post.')));
		}
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('card',model('User') -> userCard($uid));
		return $this -> fetch();
	}
	
	/**
	 * controller 设置默认银行卡
	 */
	public function set_bank_default(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> setBankDefault(input('post.')));
		}
	}
	
	/**
	 * controller 解绑银行卡
	 */
	public function bank_untie(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> bankUntie(input('post.')));
		}
	}
	
	/**
	 * controller 修改密码
	 */
	public function mod_pwd(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> modPwd(input('post.')));
		}
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		return $this -> fetch();
	}
	
	/**
	 * controller 地址列表
	 */
	public function address(){
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('address',model('User') -> addressList($uid));
		return $this -> fetch();
	}
	
	/**
	 * controller 添加地址
	 */
	public function add_addr(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> addAddr(input('post.')));
		}
	}
	
	/**
	 * controller 编辑地址信息
	 */
	public function edit_addr_info($id){
		return json(model('User') -> editAddrInfo($id));
	}
	
	/**
	 * controller 编辑地址
	 */
	public function edit_addr(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> editAddr(input('post.')));
		}
		
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('addr',Db::name('user_addr') -> where('uid',$uid) -> find());
		return $this -> fetch();
	}
	
	/**
	 * controller 设置默认地址
	 */
	public function set_addr_default(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> setAddrDefault(input('post.')));
		}
	}
	
	/**
	 * controller 删除地址
	 */
	public function del_addr(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> delAddr(input('post.')));
		}
	}
	
	/**
	 * controller 我的推广
	 */
	public function my_promotion(){
		if(Request::instance() -> isPost()){
			return json(model('User') -> activation(input('post.')));
		}
		
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('promotion',model('User') ->myPromotion($uid));
		return $this -> fetch();
	}
	
	/**
	 * controller 关于我们
	 */
	public function about_us(){
		// 获取用户ID
		$uid = is_login($uid);
		$this -> assign('user',model('User') -> userInfo($uid));
		$this -> assign('page',model('User') -> aboutUs());
		return $this -> fetch();
	}
	
	// 上传图片
    public function upload(){
    	$type = trim(input('type'));
    	$uid = input('uid');
    	if(!$type || !$uid){
    		$ret = ['code' => 0,'msg' => '参数错误!'];
    	}else{
    		$file = request() -> file('file');
    		if($file){
    			$info = $file -> move(ROOT_PATH . 'public' . DS . 'upload/' . $type . '/' . $uid,true,true,2);
    			if($info){
    				$link = '/upload/' . $type . '/' . $uid . '/' . $info -> getSaveName();
    				$ret = ['code' => 1,'msg' => '上传成功!','url' => $link];
    			}else{
    				$ret = ['code' => 0,'msg' => $file -> getError()];
    			}
    		}else{
    			$ret = ['code' => 0,'msg' => '未上传!'];
    		}
    	}
    	return json($ret);
    }
    
}