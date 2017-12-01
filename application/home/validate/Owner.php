<?php
namespace app\home\validate;
use think\Validate;

class Owner extends Validate{
    protected $rule = [
        ['username', 'require', '姓名不能为空'],
        ['num', 'require', '房间号不能为空'],
        ['num', 'number', '房间号格式错误'],
        ['tel', 'require', '电话号码不能为空'],
        ['tel', 'number', '请输入正确的电话号码'],
        ['tel', 'length:11', '请输入正确的电话号码'],
        ['relation', 'require', '请输入你和业主之间的关系'],
        ['CD', 'require', '身份证不能为空'],
        ['CD', 'length:18', '请输入正确的身份证'],
    ];
}
