<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;
use think\Db;

class Config extends AdminBase
{

    public function index()
    {
        if (Request::instance()->isPost()) {
            $datas = input('post.');
            return json(model('Config')->saveConfig($datas));
        }
        $this->assign("list", model("Config")->configPage('index'));
        return $this->fetch();
    }

    public function info()
    {
        $this->assign("list", model("Config")->configPage('info'));
        return $this->fetch();
    }

    public function data()
    {
        $tabs = db()->query('show table status');
        $total = 0;
        foreach ($tabs as $k => $v) {
            $tabs[$k]['size'] = byteFormat($v['Data_length'] + $v['Index_length']);
            $total += $v['Data_length'] + $v['Index_length'];
        }
        $this->assign("list", $tabs);
        $this->assign("total", byteFormat($total));
        $this->assign("tables", count($tabs));
        return $this->fetch();
    }

    public function setting($p = 1)
    {
        $this->assign("info", model("Config")->infoList(array(), $p));
        return $this->fetch();
    }

    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Config')->saveInfo(input('post.')));
        }
        $this->assign("info", array('id' => null, 'key' => null, 'info' => null, 'url' => 'index', 'type' => '0'));
        $this->assign("url", model("Common/Dict")->showList('config_url'));
        $this->assign("type", model("Common/Dict")->showList('config_type'));
        return $this->fetch();
    }

    public function edit($id)
    {
        $this->assign("info", model("Config")->listInfo($id));
        $this->assign("url", model("Common/Dict")->showList('config_url'));
        $this->assign("type", model("Common/Dict")->showList('config_type'));
        return $this->fetch('add');
    }
	
	// 上传/修改币种图标
	public function upload(){
        $type = trim(input('type'));
        if(!$type){
            $r = ['status' => 0,'info' => '参数不正确'];
        }else{
            // 获取表单上传文件 例如上传了001.jpg
            $file = request() -> file('file');
            // 移动到框架应用根目录/public/upload/ 目录下
            if($file){
                $info = $file -> move(ROOT_PATH . 'public' . DS . 'upload/' . $type,true,true,2);
                if($info){
                    // 成功上传后 获取上传信息
                    $link = '/upload/' . $type . '/' . $info -> getSaveName();
                    $r = ['status' => 1,'info' => '上传成功','msg' => $link];
                }else{
                    // 上传失败获取错误信息
                    $r = ['status' => 0,$file -> getError()];
                }
            }else{
                $r = ['status' => 0,'info' => '未上传'];
            }
        }
        return json($r);
    }
}