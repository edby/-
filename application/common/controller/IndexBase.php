<?php
/**
 * 全局基类
 */
namespace app\common\controller;
use app\common\controller\Base;
use org\util\Auth;
class IndexBase extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        // 获取当前用户ID
        define('UID', is_login());
        if (!UID) {
            // 还没登录 跳转到登录页面
            $this->redirect('Publics/login');
        }
    }

}