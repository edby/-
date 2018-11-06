<?php
namespace app\index\controller;

use app\common\controller\Base;
use think\Db;
use think\Exception;
use think\Request;
use app\index\model\Goods as GoodsModel;
use app\index\model\GoodClassify;
class Goods extends Base
{
	
	/**
	 * controller 商城首页
	 */
	 public function index(){
		$page_size = 5;
		//获取优惠专区图片

		$preferential = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->limit($page_size)->where('area_type = 2')->select();
		//		传递优惠专区
		$this->assign('preferential',$preferential);

		//获取特色专区商品
		$feature = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->limit($page_size)->where('area_type = 1')->select();
		//        传递特色专区
		$this->assign('feature',$feature);
//		print_r($feature);
//		exit();


		return $this -> fetch();
	}
	
	/**
     * 接收前台ajax请求，将数据返回前台
	 * controller 商品分类
	 */
	public function classify(){

		$good_types = Db::name('goods_classify')->select();
		$this->assign("classify",$good_types);
		try{
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


	}



	public function get_goods_by_type($classify,$page)
    {
		$page_size = 6;
//
		$configs = ['query'=>['classify'=>$classify]];
//		print_r($configs);
		$goods = Db::name('goods_detail')->where(['cid'=>$classify])->paginate($page_size,false,$configs);
		$pages = $goods->render();
		$this->assign('pages',$pages);
		$this->assign('goods_detail',$goods);

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

		$preferential = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->where('area_type = 1')->paginate($page_size);
		$page = $preferential->render();
		$this->assign("preferential",$preferential);
		$this->assign("pre_page",$page);
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
        $feature = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->where('area_type = 2')->paginate($page_size);
        $page = $feature->render();
        $this->assign('feature',$feature);
        $this->assign('page',$page);
//            print_r($feature[0]);
//            exit;
        return $this -> fetch();

//            if($_POST['types'] == "feature"){
//                try{
//                    $feature = Db::table("sn_goods")->alias('a')->join('goods_detail b','a.id = b.gid')->field('a.id,b.name,b.price,b.original_price,b.brand,b.detail_pic')->where('area_type = 2')->select();
//                    $r = ['code'=>1,'msg'=>'成功','data'=>$feature];
//                }catch (\Exception $e){
//                    $r = [
//                        'code'=>-1,
//                        'msg'=>$e->getMessage(),
//                    ];
//               }
////               print_r($r);
////                exit();
//                return json_encode($r);
//            }else{
//                $r = [
//                    'code'=>-1,
//                    'msg'=>'获取数据错误！'
//                ];
//                return json_encode($r);
//            }
    }

    public function product_order()
    {
    	if(!$_POST){
			$r = [
				'code'=>-1,
				'msg'=>'生成订单失败！',
				'data'=>''
			];
			return json_encode($r);
	    }
	    print_r($_POST);
    	exit;

    }

    /**
	 * controller 商品详情
	 */
	public function detail(){
		if(!$_GET['id']){
			return json_encode(['r'=>'未接收到特定数据']);
			exit;
		}
//		print_r($_GET['id']);
		$goods_detail = Db::name('goods_detail')->where(['gid'=>$_GET['id']])->find();
//		echo Db::name('sn_goods_detail')->getLastSql();
//		var_dump($goods_detail);
//		exit();

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
		
		return $this -> fetch();
	}
	
	/**
	 * controller 修改券
	 */
	public function change(){
		
		return $this -> fetch();
	}
	
	/**
	 * controller 手续费券
	 */
	public function tip(){
		
		return $this -> fetch();
	}
	
	/**
	 * controller 入驻券
	 */
	public function enter(){
		
		return $this -> fetch();
	}
	
	/**
	 * controller 结算
	 */
	public function clear(){
		
		return $this -> fetch();
	}
	
	/**
	 * controller 购物车
	 */
	public function car(){
		
		return $this -> fetch();
	}
}
