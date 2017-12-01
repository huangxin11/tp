<?php
namespace app\home\validate;
use think\Validate;

class UserArticle extends Validate{
    protected $rule = [
        ['user_id', 'require', '用户不能为空'],
        ['article_id', 'require', '活动不能为空'],
    ];
}