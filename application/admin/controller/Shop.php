<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\index\model\Goods;
use think\Exception;
use think\Request;
use think\Db;
use app\admin\model\GoodsDetail;


class Shop extends Admin
{
	
	/**
	 * controller 商品分类列表
	 */
	public function index(){
		
		$this -> assign('class',model('Shop') -> classList());
		return $this -> fetch();
	}
	
	/**
	 * controller 添加分类
	 */
	public function add(){
		if(Request::instance() -> isPost()){
			return json(model('Shop') -> addClass(input('post.')));
		}
		
		$this -> assign('pagename','添加分类');
		return $this -> fetch();
	}
	
	/**
	 * controller 修改分类
	 */
	public function edit($id){
		if(Request::instance() -> isPost()){
			return json(model('Shop') -> addClass(input('post,')));
		}
		
		$this -> assign('class',Db::name('goods_classify') -> where('id',$id) -> find());
		$this -> assign('pagename','修改分类');
		return $this -> fetch('add');
	}
	
	/**
	 * controller 删除分类
	 */
	public function delete($id){
		return json(model('Shop') -> deleteClass($id));
	}
	
    /**
     * controller 优惠专区
     */
    public function preferential($p = 1){
    	$map['area_type'] = 1;
    	$this -> assign('goods',model('Shop') -> preferential($map,$p));
    	return $this -> fetch();
    }
    
    /**
	 * controller 优惠专区添加商品
	 */
	public function add_preferential_goods(){
		if(Request::instance() -> isPost()){
			return json(model('Shop') -> addGoods(input('post.')));
		}
		
		// 获取当前登陆管理员ID
		$aid = $_SESSION['think']['aid'];
		$this -> assign('area_id',1);	// 优惠专区
		$this -> assign('shop_id',model('Shop') -> get_shop($aid));	// 获取店铺ID
		$this -> assign('class',model('Shop') -> classList());
		$this -> assign('pagename','添加商品');
		return $this -> fetch();
	}


	/**
	 *
	 * 编辑优惠专区商品
	 * @param $id
	 * @return mixed|\think\response\Json
	 */
    public function edit_preferential_goods($id){
    	if(Request::instance() -> isPost()){
			return json(model('Shop') -> addGoods(input('post.')));
		}
		
		// 获取当前登陆管理员ID
		$aid = $_SESSION['think']['aid'];
		$this -> assign('area_id',1);	// 优惠专区
		$this -> assign('shop_id',model('Shop') -> get_shop($aid));	// 获取店铺ID
		$this -> assign('goods',model('Shop') -> get_goods_detail($id));
		$this -> assign('class',model('Shop') -> classList());
		$this -> assign('pagename','修改商品');
		return $this -> fetch('add_preferential_goods');
    }


	/**
	 *
	 * 显示特色专区
	 * @param int $p
	 * @return mixed
	 */
    public function feature($p = 1){
    	$map['area_type'] = 2;
    	$this -> assign('goods',model('Shop') -> feature($map,$p));
    	return $this -> fetch();
    }

	/**
	 * 改变商品审核状态
	 * @return array|bool|string|true
	 */
    public function validate()
    {

    	$r = [
    		'code'=>1,
		    'msg'=>'改变审核状态',
	    ];
    	if(!($_POST && ($_POST['gid']))){
		    $r = [
			    'code'=>-1,
			    'msg'=>'数值传递出错！',
		    ];
		    return json_encode($r);
	    }
    	$this_goods = Db::name('goods_detail')->where(['gid'=>$_POST['gid']])->find();
    	if(!$this_goods){
			$r = [
				'code'=>-1,
				'msg'=>'未查询到该数据！',
			];
			return json_encode($r);
	    }
		if(Db::name('goods_detail')->where(['gid'=>$_POST['gid']])->update(['status'=>$_POST['type']=='pass'?'3':'2'])){
			$r = [
				'code'=>1,
				'msg'=>'已修改审核状态',
			];
			return json_encode($r);
		}
    	return json_encode($r);
    }


	/**
	 * 特色专区添加商品
	 * @return mixed|\think\response\Json
	 */
	public function add_feature_goods(){
		if(Request::instance() -> isPost()){
			return json(model('Shop') -> addGoods(input('post.')));
		}
		
		// 获取当前登陆管理员ID
		$aid = $_SESSION['think']['aid'];
		$this -> assign('area_id',2);	// 特色专区
		$this -> assign('shop_id',model('Shop') -> get_shop($aid));	// 获取店铺ID
		$this -> assign('class',model('Shop') -> classList());
		$this -> assign('pagename','添加商品');
		return $this -> fetch();
	}


	/**
	 * 编辑特色专区商品信息
	 * @param $id
	 * @return mixed|\think\response\Json
	 */
    public function edit_feature_goods($id){
    	if(Request::instance() -> isPost()){
			return json(model('Shop') -> addGoods(input('post.')));
		}
		
		// 获取当前登陆管理员ID
		$aid = $_SESSION['think']['aid'];
		$this -> assign('area_id',2);	// 特色专区
		$this -> assign('shop_id',model('Shop') -> get_shop($aid));	// 获取店铺ID
		$this -> assign('goods',model('Shop') -> get_goods_detail($id));
		$this -> assign('class',model('Shop') -> classList());
		$this -> assign('pagename','修改商品');
		return $this -> fetch('add_feature_goods');
    }
	
	// 上传图片
    public function upload_pic(){
    	$type = trim(input('type'));
    	$shop_id = input('shop_id');	// 店铺ID
    	if(!$type || !$shop_id){
    		$ret = ['code' => 0,'msg' => '参数错误!'];
    	}else{
    		$file = request() -> file('file');
    		if($file){
    			$info = $file -> move(ROOT_PATH . 'public' . DS . 'upload/' . $type . '/' . $shop_id,true,true,2);
    			if($info){
    				$link = '/upload/' . $type . '/' . $shop_id . '/' . $info -> getSaveName();
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
    
    // 上传多张图片
    public function upload_pics(){
    	$type = trim(input('type'));
    	$shop_id = input('shop_id');	// 店铺ID
    	if(!$type || !$shop_id){
    		$ret = ['code' => 0,'msg' => '参数错误!'];
    	}else{
    		$file = request() -> file('file');
    		if($file){
    			$info = $file -> move(ROOT_PATH . 'public' . DS . 'upload/' . $type . '/' . $shop_id,true,true,2);
    			if($info){
    				$link = '/upload/' . $type . '/' . $shop_id . '/' . $info -> getSaveName();
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

	/**
	 * 删除商品，   权限为，普通商家和超管
	 * @return false|string
	 */
    public function feature_del()
    {
    	$r = [
    		'code'=>-1,
    		'msg'=>'初始化信息传递'
	    ];
//		pre($_POST);
    	if(!$_POST){
		    $r = [
			    'code'=>1,
			    'msg'=>'传输数据错误'
		    ];
		    return json_encode($r);
	    }
//开启事务
	    Db::startTrans();
	    try{

	    	$this_goods_detail = GoodsDetail::get(['gid'=>$_POST['id']]);
	    	$this_goods = Goods::get(['id'=>$_POST['id']]);
	    	if($this_goods_detail){
	    	    $this_goods_detail->delete();
		    }else{
	    		throw new Exception("cant find this id");
		    }
		    if($this_goods){
		    	$this_goods->delete();
		    }else{
		    	throw new Exception("cant find this id");
		    }
//			提交

			Db::commit();
			$r = [
				'code'=>1,
				'msg'=>'删除成功',
			];
	    }catch (\Exception $e){
//	    	回滚
			Db::rollback();
			$r = [
				'code'=>-1,
				'msg'=>"删除失败,事务已回滚"
			];
	    }
	    return json_encode($r);

//    	return json_encode($r);
////    	echo "删除商品";
//    	exit();
    }


	/**
	 * 显示商品订单
	 * @return mixed
	 * @throws \think\exception\DbException
	 */
    public function goods_order()
    {
    	$page_size = 10;
//    	$query =$_GET['record_type']!=null?"?record_type=".$_GET['record_type']."&":null;
//    	$query.=$_GET['keywords']!=null?"?keywords=".$_GET['keywords']:null;
//		print_r($page_config);
		$where = null;
		$querys = null;
		if($_GET['record_type'] && $_GET['record_type'] != 0){
			$querys = [
				'record_type'=>$_GET['record_type']
			];
			$where['order_status'] = $_GET['record_type'];
		}
		if($_GET['keywords']){
			$querys=[
				'keywords'=>$_GET['keywords']
			];
			$where = ['order_number'=> $_GET['keywords']];
		}
		$page_config = [
			'query'=>$querys
		];
//		print_r($_SESSION['think']['user_type']);
		if($_SESSION['think']['user_type'] == 2){
			$where = [
				'buy_uid'=>$_SESSION['think']['uid']
			];
//			$where['buy_uid'] =$_SESSION['think']['uid'];
		}
//    	$goods_order = Db::table('sn_goods_order')->alias('order')->join('sn_goods_detail detail','order.gid = detail.gid')->join('sn_user','sn_goods_order.buy_uid = sn_user.id')->field('sn_user.account as user,sn_goods_detail.name as goods_name,sn_goods_order.sell_sid as sid,sn_goods_order.g_number as number,order.sn_goods_order.order_status as status,sn_goods_order.create_time as time')->paginate($page_size);
		$goods_order = Db::name('goods_order')
			->alias('order')
			->join('goods_detail detail','order.gid = detail.gid','LEFT')
			->join('user u','u.id = order.buy_uid','LEFT')
			->join('user_addr addr','addr.id = order.addr_id')
			->where($where)
			->field('u.account,detail.name as detail_name,order.sell_sid,order.g_number,order.money,order_status,addr.address,addr.tel,addr.username as addr_name,order.create_time,order.order_number')
			->paginate($page_size,false,$page_config);
//		print_r(Db::name('goods_order')->getLastSql());
//		echo Db::name('goods_order')->getLastSql();
    	$page = $goods_order->render();
//    	print_r($goods_order);
    	$this->assign('record_type',$_GET['record_type']!=null?$_GET['record_type']:null);
    	$this->assign('goods_order',$goods_order);
    	$this->assign('user_type',$_SESSION['think']['user_type']);
    	$this->assign('page',$page);
    	return $this->fetch();
    }

	/**
	 * 商家修改发货状态，开始发货
	 * @return false|string
	 */
    public function delivery()
    {
    	$r = [
    		'code'=>1,
		    'msg'=>$_POST
	    ];
    	Db::startTrans();
    	try{
    		$result = 	Db::name('goods_order')->where(['order_number'=>$_POST['order_number'],'order_status'=>2])->update(['order_status'=>3]);
    		if(!$result){
    			throw new Exception("数据未更改！");
		    }
		    $goods_order = Db::name('goods_order')->where(['order_number'=>$_POST['order_number']])->find();
		    $goods = Db::name('goods_detail')->where(['gid'=>$goods_order['gid']])->find();
    		if(!$goods){
			    throw new Exception("商品信息错误");
		    }
//		    throw new Exception(Db::name('goods_detail')->getLastSql());
//		    print_r($goods);
//    		exit();
		    $result = Db::name('goods_detail')->where(['gid'=>$goods['gid']])->setDec('number',$goods_order['g_number']);
    		if(!$result){
			    throw new Exception("商品信息修改失败");
		    }
			Db::commit();
			$r = [
				'code'=>1,
				'msg'=>'数据已更新'
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
