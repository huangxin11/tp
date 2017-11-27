<?php

namespace app\admin\validate;
use think\Validate;

class Server extends Validate {

    protected $rule = [
        ['title', 'require', '标题不能为空'],
        ['address', 'require', '地址不能为空'],
        ['tel', 'require', '电话号码不能为空'],
        ['content', 'require', '内容不能为空'],
        ['name', 'require', '报修人不能为空'],
    ];
}