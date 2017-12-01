<?php
namespace app\admin\validate;
use think\Validate;

class Room extends Validate{
    protected $rule = [
        ['name', 'require', '姓名不能为空'],
        ['price', 'require', '价格不能为空'],
        ['price', 'number', '请输入正确的价格'],
        ['tel', 'require', '电话号码不能为空'],
        ['tel', 'length:11', '请输入正确的电话'],
        ['descript', 'require', '描述不能为空'],
        ['start_time', 'require', '开始时间不能为空'],
        ['end_time', 'require', '结束时间不能为空'],
        ['content', 'require', '内容不能为空'],
    ];
}