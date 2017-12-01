<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"D:\www\tp\public/../application/home/view/default/community\community_article.html";i:1512013080;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="index.html" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid">
        <p id="id" hidden="hidden"><?php echo $shop['id']; ?></p>
        <div class="blank"></div>
        <h3 class="noticeDetailTitle"><strong>标题:<?php echo $shop['title']; ?></strong></h3>
        <div class="noticeDetailInfo">发布者:<?php echo $user['nickname']; ?></div>
        <div class="noticeDetailInfo">发布时间：<?php echo time_format($shop['create_time']); ?></div>
        <div class="noticeDetailInfo"><a id="add" href="javasctipt:;">我要参与活动</a></div>
        <div class="noticeDetailContent">
            <?php echo $shop_article['content']; ?>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $("#add").click(function () {
//        alert(1);
        var id = $("#id").text();
        $.getJSON('/home/community/play',{article_id:id},function (data) {
            if (data == 'nologin'){
                $(location).attr('href', '/user/login/index');
            }else if (data == 'false'){
                alert("你已经参加了该活动");
            }else if (data == 'success'){
                alert("参加活动成功");
            }else {
                alert("报名失败");
            }
        })
    })
</script>
</body>
</html>