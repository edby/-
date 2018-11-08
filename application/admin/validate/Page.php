<?php
namespace app\admin\validate;

use think\Validate;

class Page extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'name'  =>  'require',
        'content'  =>  'require',
    ];
    
    /**
     * 提示消息
     */
    protected $message = [
        'name.require'  =>  '请输入单页名称!',
        'content.require'  =>  '请输入单页内容!',
    ];
    
}
