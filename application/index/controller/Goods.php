<?php
namespace app\index\controller;

use app\admin\model\Banner;
use app\common\controller\Base;
use app\index\model\GoodsOrder;
use app\index\model\UserBouns;
use app\index\model\UserVou;
use think\Build;
use think\Db;
use think\Exception;
use think\Request;
use app\index\model\Goods as GoodsModel;
use app\index\model\GoodClassify;
class Goods extends Base
{

	private $banner;

	/**
	 *
	 * 获取轮播图
	 * Goods constructor.
	 * @param Request|null $request
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function __construct(Request $request = null)
	{
		parent::__construct($request);

//		获得优惠券后提示
		$pre_card = Db::name('user_vou')->where(['uid'=>$_SESSION['think']['uid']])->where(['notice'=>1])->find();
		Db::startTrans();
		try{
			Db::name('user_vou')->where(['id'=>$pre_card['id']])->update(['notice'=>0]);
			$this->assign('pre_card',$pre_card);
			Db::commit();
		}catch (\Exception $e){
			Db::rollback();
		}

//		获取轮播图
		$banners = Db::name('banner')->where(['state'=>1])->limit(4)->order(['sort'])->select();
//		echo Db::name('banner')->getLastSql();
//		exit;
//		传递轮播图
		$this->banner = $banners;
	}

	/**
	 *
	 * 获取优惠专区和特色专区的数据
	 * @return mixed
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	 public function index(){
		$page_size = 5;
		//获取优惠专区图片

		$preferential = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->limit($page_size)->where(['area_type '=> 2,'status'=>3])->select();
		//		传递优惠专区
		$this->assign('preferential',$preferential);

		//获取特色专区商品
		$feature = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->limit($page_size)->where(['area_type'=>1,'status'=>3])->select();
		//        传递特色专区
		 $this->assign('feature',$feature);
//		print_r($feature);

//		 传递轮播图
		 $this->assign('banner',$this->banner);
		return $this -> fetch();
	}

	/**
	 * 输出商品分类
	 * @return mixed
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function classify(){
		$good_types = Db::name('goods_classify')->select();
		$this->assign("classify",$good_types);
		if($_GET['search_text']){
//				exit;
			$pagesize = 6;
			$seach_area = null;
			$seach_area = [
				['name','LIKE','%'.$_GET['search_text'].'%'],
			];
			$configs = ['query'=>['search_text'=>$_GET['search_text']]];
			$goods = Db::name('goods_detail')->where('name','like','%'.$_GET['search_text'].'%')->where(['status'=>3])->paginate($pagesize,false,$configs);
			$pages = $goods->render();
			$this->assign('pages',$pages);
			$this->assign('goods_detail',$goods);
			return $this->fetch();
			exit;
//			print_r($goods);
//			exit;
		}
		try{
//			print_r($_GET);
			if(!$_GET['classify']){
//				 "首次访问当前页面";
				$echo_goods = $this->get_goods_by_type(1,1);
			}else if(!$_GET['page']){
//				首次访问某一类别，page为1
				$echo_goods = $this->get_goods_by_type($_GET['classify'],1);
			}else{
				$echo_goods = $this->get_goods_by_type($_GET['classify'],$_GET['page']);
			}
		}catch (\Exception $e){
			$echo_goods = $this->get_goods_by_type(1,1);
		}

			return $this->fetch();

//		 传递轮播图
		$this->assign('banner',$this->banner);

	}


	/**
	 *
	 * 根据类别获取商品并分页
	 * @param $classify
	 * @param $page
	 * @throws \think\exception\DbException
	 */
	public function get_goods_by_type($classify,$page)
    {
		$page_size = 6;
//
		$configs = ['query'=>['classify'=>$classify]];
//		print_r($configs);
		$goods = Db::name('goods_detail')->where(['cid'=>$classify])->where(['status'=>3])->paginate($page_size,false,$configs);
		$pages = $goods->render();
		$this->assign('pages',$pages);
		$this->assign('goods_detail',$goods);
		//		 传递轮播图
		$this->assign('banner',$this->banner);

//		exit();



    }
    /**
     *
     *优惠专区
     * @return mixed
     * @throws \think\exception\DbException
     */
	public function preferential(){
	    $page_size = 6 ;

		$preferential = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->where(['area_type '=>1])->where(['b.status'=>3])->paginate($page_size);
		$page = $preferential->render();
		$this->assign("preferential",$preferential);
		$this->assign("pre_page",$page);
		//		 传递轮播图
		$this->assign('banner',$this->banner);
		return $this->fetch();


	}

    /**
     * 特色专区
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function feature(){
        $page_size = 8;

    //        传递特色专区
    //查询特色专区
        $feature = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->where('area_type = 2')->where(['status'=>3])->paginate($page_size);
        $page = $feature->render();
        $this->assign('feature',$feature);
        $this->assign('page',$page);
//            print_r($feature[0]);
//            exit;
        return $this -> fetch();


//		 传递轮播图
	    $this->assign('banner',$this->banner);
    }


	/**
	 * 处理该订单信息，生成订单号
	 * @return false|string
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
    public function product_order()
    {
//    	未接收到购买信息
//	    print_r($_POST);
//	    exit();
    	if(!$_POST){
			$r = [
				'code'=>-1,
				'msg'=>'提交失败！',
				'data'=>''
			];
			return json_encode($r);
	    }
//	    print_r($_SESSION);
	    $user_info = Db::name('user')->where(['id'=>$_SESSION['think']['uid']])->find();
//    	echo Db::name('user')->getLastSql();
//    	print_r($user_info);
//    	exit();
	    if($user_info['status'] == 2){
			$r = [
				'code'=>-1,
				'msg'=>'您的账户已被限制交易，请购买激活券激活后进行交易'
			];
	        return json_encode($r);
	    }

//      数据库未读取到商品信息
//	    print_r($_POST);
//	    print_r(Db::table('sn_goods')->where(['id'=>$_POST['gid']])->select());
//    	echo Db::name('sn_goods')->getLastSql();
//    	exit();
	    if(sizeof(Db::table('sn_goods')->where(['id'=>$_POST['gid']])->select())<1){
	    	$r = [
	    		'code'=>-1,
			    'msg'=>'商品信息错误！'
		    ];
	    	return json_encode($r);
	    }
//      未登录
	    if(!$_SESSION['think']['uid']){
	    	$r = [
	    		'code'=>-2,
			    'msg'=>'未登录！请先登录！'
		    ];
	    	return json_encode($r);
	    }
	    $gid = $_POST['gid'];
//	    商品信息
	    $googd_info = Db::table('sn_goods_detail')->alias('detail')->join('goods','detail.gid = goods.id')->where(['gid'=>$gid])->where(['status'=>3])->find();
//	    print_r($googd_info);
//	    exit();
//		print_r($googd_info['shop_id']);
//		print_r($_SESSION['think']['uid']);
//		exit();

//	    用户收货地址
	    $user_add = Db::name('user_addr')->where(['uid'=>$_SESSION['think']['uid']])->select();
	    $user_addr_id = $user_add[0]['id'];
	    if(!$user_add) {
			$r = [
				'code'=>-1,
				'msg'=>'用户收货地址信息出错'
			];
			return json_encode($r);
			exit;
	    }
	    for($i = 0;$i<sizeof($user_add);$i++){
			if($user_add[$i]['default'] == 2){
				$user_addr_id = $user_add[$i]['id'];
			}
	    }
	    if($googd_info['gid'] == $_SESSION['think']['uid']){
	    	$r = [
	    		'code'=>-1,
			    'msg'=>'不能购买自己的商品！'
		    ];
	    	return json_encode($r);
	    }
	    $uid = $_SESSION['think']['uid'];
	    $number = $_POST['number'];
//	    print_r($gid);
//		print_r($uid);
//	    print_r($number);
	    $goods = new GoodsOrder();
//	    商品id
	    $order['gid'] = $gid;
//	    商品类型id
	    $order['cid'] = $googd_info['area_type']==1?1:2;
//	    买家id
	    $order['buy_uid'] = $uid;
//	    创建时间
	    $order['create_time'] = time();
//	    店铺id
	    $order['sell_sid'] = Db::table('sn_goods')->where(['id'=>$gid])->field('shop_id')->select();
	    $order['sell_sid'] = $order['sell_sid'][0]['shop_id'];
//	    商品单价
	    $order['g_price'] = $googd_info['price'];
//	    购买数量
	    $order['g_number'] = $number;
//	    总价
	    $order['money'] = $order['g_price'] * $order['g_number'];
//	    支付状态
	    $order['order_status'] = 1;
//	    订单号
		$order['order_number'] = generateOrderNumber();
		$order['addr_id'] = $user_addr_id;
	    if($goods->insert($order)){
//		    print_r($order);
		    $r = [
		        'code'=>1,
			    'data'=>$order['order_number'],
		    ];

	    }else{
	    	$r = [
	    		'code'=>-1,
			    'msg'=>'生成订单信息失败！'
		    ];
	    }
	    return json_encode($r);





    }


	/**
	 *
	 * 订单结算页面
	 * @return mixed
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
    public function clear()
    {
    	if(!($_POST||$_GET)){
//    		未接收到数据，自动后退
			echo "<script>histroy.go(-1);</script>";
	    }
//	    从直接购买传递过来的
    	if($_GET['type'] == 'buy'){
		    $user_order = Db::table('sn_goods_order')->alias('a')->join('sn_goods_detail b','a.gid = b.gid')->where(['order_number'=>$_GET['ord'],'buy_uid'=>$_SESSION['think']['uid'],'order_status'=>1])->select();
//		    echo Db::name('goods_order')->getLastSql();
//		    print_r($user_order[0]['order_number']);
//		    exit();
		    if(!$user_order[0]['order_number']){
			    echo "<script>history.go(-1);</script>";
		    }
		    $user_info = Db::table('sn_user_addr')->where(['uid'=>$_SESSION['think']['uid']])->select();
	        $this->assign('user_info',$user_info);
		    $this->assign('user_order',$user_order);

//			pre($user_order);
//			pre($user_info);
//		    从购物车传递过来的
	    }else if(isset($_POST['type']) && ($_POST['type'] == "car")){
			$list = $_POST['data'];
			foreach ($list as $k=>$v){
				$arr[] = $v[0];
			}
			$string = implode(',',$arr);
		    $user_info = Db::table('sn_user_addr')->where(['uid'=>$_SESSION['think']['uid']])->select();
		    $user_order = Db::table('sn_goods_order')->alias('a')->join('sn_goods_detail b','a.gid = b.gid')->where('order_number','in',$string)->where(['buy_uid'=>$_SESSION['think']['uid']])->select();
		    $this->assign('user_info',$user_info);
		    $this->assign('user_order',$user_order);
	    }else{
    		echo "<script>history.go(-1);</script>";
    		exit();
	    }
	    $addrs = Db::name('user_addr')->where(['uid'=>$_SESSION['think']['uid']])->select();
//    	print_r($addrs);
	    $this->assign("addrs",$addrs);
    	return $this->fetch();
    }


	/**
	 * 订单付款功能，只能使用消费券进行购买商品
	 * @return false|string
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
    public function do_clear()
    {
//    	print_r($_POST);
//    	exit();
    	$r = [
    		'code'=>1,
		    'msg'=>$_POST['rec_ids']
	    ];
//    	return json_encode($r);
//    	exit();

//	    获取用户收货地址
	    $user_add = Db::name('user_addr')->where(['id'=>$_POST['rec_ids']])->find();
//	    $r['msg'] = $user_add;
//	    return json_encode($r);
	    if(!$user_add){
		    $r = [
		    	'code'=>-1,
			    'msg'=>'收货地址异常',
		    ];
		    return json_encode($r);
	    }
//      获取用户账户信息
		$user_info = Db::name('user_bouns')->where(['id'=>$_SESSION['think']['uid']])->select();
		if(!$user_info){
			$r = [
				'code'=>-1,
				'msg'=>'用户信息不存在'
			];
			return json_encode($r);
//			exit();
		}
	    Db::startTrans();
	    try {
		    foreach ($_POST['data'] as $item)
		    {
//		    	订单状态
			    $goods_order = Db::name('goods_order')->where(['order_number' => $item[0]])->find();
				if(!$goods_order){
					throw new Exception("订单不存在");
				}
//				当前用户状态：
			    $user_info = Db::name('user')->where(['id'=>$_SESSION['think']['uid'],'status'=>1])->where(['payment_password'=>encrypt(trim($_POST['pwd']))])->find();
//				echo Db::name('user')->getLastSql();
//				exit();
				if(!$user_info){
					throw new Exception("用户密码错误");
				}
				if($user_info['status' == '2']){
					throw new Exception("帐户已被禁用");
				}
//				购买的商品为优惠专区
				if($goods_order['cid'] == 1){
					$vou_where = [
						'uid'=>$_SESSION['think']['uid'],
						'vid'=>1
					];
					$vou = Db::name('user_vou')->where($vou_where)->find();
//					用户优惠券不足
					if(!($vou && $vou['number']>0)){
						throw new Exception("用户券不足");
					}
					$result = Db::name('user_vou')->where($vou_where)->setDec('number',1);
					if(!$result){
						throw new Exception('更新用户优惠券失败');
					}
//                  用户购买的是特色专区商品
				}else{
					$item_money = $goods_order['g_price'] * $item[1];
					$item_const = $item_money;
	//				用户余额账户
					$user_money = Db::name('user_bouns')->where(['uid'=>$_SESSION['think']['uid']])->order('bouns_type asc')->select();
					if(!$user_money){
						throw new Exception("用户不存在");
					}
					$consumer_num = Db::name('user_vou')->where(['uid'=>$_SESSION['think']['uid'],'vid'=>6])->find();
//					print_r($consumer_num);
//					exit();
				    if($consumer_num < $item_money){
				        throw new Exception("用户消费券不足");
				    }else{
//				    	print_r($consumer_num);
//				    	exit();
				        $consumer_num['number'] -= $item_money;
					    if(!(Db::name('user_vou')->where(['uid'=>$_SESSION['think']['uid'],'vid'=>6])->update($consumer_num))){
							throw new Exception("商家状态写入失败");
					    }
				    }
				}

			    if(!(Db::name('goods_order')->where(['order_number' => $item[0]])->update(['order_status'=>2,'addr_id'=>$_POST['rec_ids']]))){
					throw new Exception('订单付款失败');
			    }
		    }
		    Db::commit();
		    $r = [
		    	'code'=>1,
			    'msg'=>'订单处理成功'
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
	 *
	 * 根据传递过来的id，渲染商品详情
	 * @return false|mixed|string
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function detail(){
		if(!$_GET['id']){
			return json_encode(['r'=>'未接收到特定数据']);
//			exit;
		}
//		print_r($_GET['id']);
		$goods_detail = Db::name('goods_detail')->where(['gid'=>$_GET['id']])->where(['status'=>3])->find();
//		echo Db::name('sn_goods_detail')->getLastSql();
//		var_dump($goods_detail);
//		exit();
		if(!$goods_detail){
			echo "<script>history.go(-1);</script>";
		}
		$pictures = explode(';',$goods_detail['picture']);
//		print_r($pictures);
//		exit;
		$this->assign('pics',$pictures);
		$this->assign('goods_detail',$goods_detail);

		return $this -> fetch('detail');
	}

    /**
	 * controller 激活券
	 */
	public function activate(){
		//		 传递轮播图
		$this->assign('banner',$this->banner);
		return $this -> fetch();
	}

	/**
	 * 购买激活券
	 * @return false|string
	 * @throws Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function buy_active()
	{
		$r = [
			'code'=>1,
			'msg'=>$_POST
		];
		//				用户余额账户
		$user_money = Db::name('user_bouns')->where(['uid'=>$_SESSION['think']['uid']])->order('bouns_type asc')->select();
		if(!$user_money){
			throw new Exception("用户帐户不存在");
		}
		Db::startTrans();
		try{
//				    遍历用户三个类型的奖金，依次扣款
			$times = 1;
			$item_money = 200;
			foreach ($user_money as $money_type){
	//					  依次扣除静态奖金、动态奖、福利奖
				if($money_type['bouns_number'] < $item_money){
					$money_type['bouns_number'] = 0;
					$item_money -= $money_type['bouns_number'];
					Db::name('user_bouns')->where(['id'=>$money_type['id']])->update($money_type);
				}else{
					$money_type['bouns_number'] -= $item_money;
					Db::name('user_bouns')->where(['id'=>$money_type['id']])->update($money_type);
					break;
				}
//				仅使用静态积分
				if(($times==1)&&($item_money>0)){
					throw new Exception("用户余额不足");
				}
				$times++;
			}
			$Active_order = new GoodsOrder();
			$active_order['cid'] = 1;
			$active_order['gid'] = 1;
			$active_order['g_number'] = 1;
			$active_order['buy_uid'] = $_SESSION['think']['uid'];
			$active_order['sell_sid'] = 1;
			$active_order['order_number'] = generateOrderNumber();
			$active_order['order_status'] = 4;
			$active_order['create_time'] = time();
			$active_order['g_price'] = $item_money;
			$active_order['money'] = $item_money;
			$active_order['addr_id'] = '0';
			$active_order['remarks'] = '购买激活券';
//			var_dump($active_order);
//			exit();
			if(!$Active_order->insert($active_order)){
				throw new Exception("添加订单失败");
			}
			if(!(Db::name('user_vou')->where(['uid'=>$_SESSION['think']['uid'],'vid'=>4])->setInc('number'))){
				throw new Exception("修改激活券状态失败");
			}
			Db::commit();
		}catch (\Exception $e){
			Db::rollback();
			$r = [
				'code'=>-1,
				'msg'=>$e->getMessage(),
			];
		}
		return json_encode($r);
	}


	/**
	 * controller 修改券
	 */
	public function change(){
		//		 传递轮播图
		$this->assign('banner',$this->banner);
		return $this -> fetch();
	}



	/**
	 * controller 手续费券
	 */
	public function tip(){
		//		 传递轮播图
		$this->assign('banner',$this->banner);
		return $this -> fetch();
	}

	/**
	 * 购买各种券
	 * @return false|string
	 */
	public function buy_tickets()
	{
		$post_data = array('buy_tip','buy_change','buy_active','buy_shop_tic');
		$r = null;
		if(!(isset($_POST) && in_array($_POST['data'],$post_data) )){
			return return_json(deal_json(-1,'数据错误'));
		}
//		购买手续费
		if($_POST['data'] == 'buy_tip'){
			$r = UserVou::buy_ticket($_SESSION['think']['uid'],1,20,2,1);
//		购买修改券
			}else if($_POST['data'] == 'buy_change'){
			$r = UserVou::buy_ticket($_SESSION['think']['uid'],1,20,3,1);
//		购买商城入驻券
		}else if($_POST['data'] == 'buy_shop_tic'){
			$r = UserVou::buy_ticket($_SESSION['think']['uid'],1,500,5,1);
//		类型错误
		}else{
			$r = deal_json(-1,'类型错误');
		}
		return return_json($r);

	}

	/**
	 * controller 入驻券
	 */
	public function enter(){
		//		 传递轮播图
		$this->assign('banner',$this->banner);
		return $this -> fetch();
	}


	/**
	 *
	 * 购物车内容显示
	 * @return mixed
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function car(){
		$page_size = 4;
		$user_info = Db::table('sn_user_addr')->where(['uid'=>$_SESSION['think']['uid']])->select();
		$user_order = Db::table('sn_goods_order')->alias('a')->join('sn_goods_detail b','a.gid = b.gid')->where(['buy_uid'=>$_SESSION['think']['uid'],'order_status'=>1])->paginate($page_size);

		$page = $user_order->render();
//	    echo Db::name('sn_goods_order')->getLastSql();
//	    pre($user_order);
//	    print_r($user_info);
//	    exit;
		$this->assign('page',$page);
		$this->assign('addrs',$user_info);
		$this->assign('user_order',$user_order);
		return $this -> fetch();
	}

	/**
	 * 删除订单，仅限于未支付
	 * @return false|string
	 */
	public function delete_ord()
	{
		if(!$_POST){
			$r = [
				'code'=>-1,
				'msg'=>'数据传递错误！'
			];
			return json_encode($r);
		}
		$r = [
			'code'=>1,
			'msg'=>$_POST
		];
//		开启事务
		Db::startTrans();
		try{
			Db::name('goods_order')->where(['order_number'=>$_POST['ord_id'],'order_status'=>1])->delete();
			Db::commit();
				$r = [
					'code'=>1,
					'msg'=>'删除成功'
				];
		}catch (\Exception $e){
			$r = [
				'code'=>-1,
				'msg'=>'删除失败'
			];
//			回滚
			Db::rollback();
		}
		return json_encode($r);
	}

	/**
	 * 查看全部订单，待支付，待发货，待签收，已完成
	 * @return mixed
	 * @throws \think\exception\DbException
	 */
	public function my_promotion()
	{
//		定义订单状态
		$where = null;
		$paginate_config = null;
		$where['buy_uid'] = $_SESSION['think']['uid'];
//		print_r($_GET['type']);
		if($_GET['type']){
//			echo "是否为int".is_int($_GET['type']);
			$_GET['type'] = (int)$_GET['type'];
			if(($_GET['type']>5)||($_GET['type']<0)){
				$_GET['type'] = null;
			}
			$where['order_status'] = $_GET['type'];
			$types = [
				'type'=>$_GET['type']
			];
			$querys = [
				'query'=>$types
			];
		}else{
			$querys = [
				'query'=>[]
			];
		}
//		print_r($where);
		$page_size = 5;
		$goods_order = Db::table('sn_goods_order')
			->alias('a')
			->join('sn_goods_detail b','a.gid = b.gid')
			->where($where)
			->field('a.money,b.detail_pic,b.name,a.g_number,a.order_number,a.order_status,a.create_time')
			->order(['b.create_time desc'])
			->paginate($page_size,false,$querys);
//		echo Db::name('goods_order')->getLastSql();
		$pages = $goods_order->render();
		$this->assign('type',$_GET['type']);
		$this->assign('order',$goods_order);
		$this->assign('page',$pages);
		$uid = is_login($uid);
		$this -> assign('uid',$uid);
		return $this->fetch('user/userCenter');
	}

	/**
	 * 前端发起请求
	 * 选择地址
	 * @return mixed
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function select_addr()
	{
		if($_POST['id']){
			$addrs = Db::name('user_addr')->where(['uid'=>$_SESSION['think']['uid'],'id'=>$_POST['id']])->find();
			$r = [
				'code'=>1,
				'msg'=>$addrs
			];
			return json_encode($r);
			exit();
		}else{
			$addrs = Db::name('user_addr')->where(['uid'=>$_SESSION['think']['uid']])->select();
		}
		$this->assign("addrs",$addrs);
		return $this->fetch();
	}

	/**
	 * 卖家确认订单，
	 * 根据商户的商品收益比
	 * 将消费券转换为积分存进商家静态积分中
	 * 根据收益比
	 * @return false|string
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function confirm_order()
	{
		$r = [
			'code'=>1,
			'msg'=>$_POST
		];
		if(!$_POST){
			$r = [
				'code'=>1,
				'msg'=>'未传递数据'
			];
		}
		$order_where = [
			'order_number'=>$_POST['order_id'],
			'buy_uid'=>$_SESSION['think']['uid'],
			'order_status'=>3
		];
		$order = Db::name('goods_order')->where($order_where)->find();
		$goods_detial = Db::name('goods_detail')->where(['gid'=>$order['gid']])->find();
		if(!$order){
			$r = [
				'code'=>-1,
				'msg'=>'未查询到该数据'
			];
		}
		Db::startTrans();
		try{
			$bouns_where = [
				'uid' => $order['sell_sid'],
				'bouns_type' =>1
			];
//			商品类型为2特色专区，将商品消费券转换为积分存进对应商家账户，类型为优惠专区，直接修改商品订单状态为已完成
			if($order['cid'] == 2){
				$user_bouns = Db::name('user_bouns')->where($bouns_where)->setInc('bouns_number',$order['money']*$goods_detial['profit_rate']);
				$user_income = Db::name('user_bouns')->where($bouns_where)->setInc('bouns_income',$order['money']*$goods_detial['profit_rate']);
				if(!$user_bouns){
					throw new Exception("商家信息修改失败");
				}
				if(!$user_income){
					throw new Exception("商家信息修改失败");
				}
			}
			$order['order_status'] = 4;
			$result = Db::name('goods_order')->where($order_where)->update(['order_status'=>4]);
			if(!$result){
				throw new Exception("订单状态修改失败");
			}
			Db::commit();
			$r = [
				'code'=>1,
				'msg'=>'收货成功'
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
}
