<?php
namespace app\admin\validate;
use think\Validate;

class Shop extends Validate{
    protected $rule = [
        ['title', 'require', '标题不能为空'],
        ['content', 'require', '内容不能为空'],
        ['end_time', 'require', '结束时间不能为空'],
        ['start_time', 'require', '开始时间不能为空'],
//        ['name', 'require', '报修人不能为空'],
    ];
}