<?php
namespace app\admin\validate;
use think\Validate;

class Room extends Validate{
    protected $rule = [
        ['content', 'require', '内容不能为空'],
    ];
}
