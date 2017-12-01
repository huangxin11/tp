<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\www\tp\public/../application/home/view/default/server\index.html";i:1511947458;}*/ ?>
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

        <div id="mydiv">
            <?php if(is_array($servers) || $servers instanceof \think\Collection || $servers instanceof \think\Paginator): $i = 0; $__LIST__ = $servers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$servers): $mod = ($i % 2 );++$i;?>
            <div class="row noticeList">
                <a href="/home/server/server_article?id=<?php echo $servers['id']; ?>">
                    <!--<div class="col-xs-2">-->
                        <!--<img class="noticeImg" src="<?php echo get_cover($servers['cover_id'])['path']; ?>" />-->
                    <!--</div>-->
                    <div class="col-xs-10">
                        <p class="title"><?php echo $servers['title']; ?></p>
                        <p class="intro"><?php echo $servers['content']; ?></p>
                        <p class="info"><?php echo $servers['address']; ?> <span class="pull-right"><?php echo time_format($servers['create_time']); ?></span> </p>
                    </div>
                </a>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <p id="page" hidden="hidden"><?php echo $page; ?></p>
        <button  id="add" class="btn btn-info" style="margin: 0 auto">想看更多吗？那就点我吧</button>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $("#add").click(function () {
        var int = $('#page').text();
        int = parseInt(int);
        page = int+1;
        $.getJSON('/home/server/index',{page:page},function (noice) {
            var data = $.parseJSON(noice);
            $('#page').text(data['page']);
            $.each(data,function (index) {
                if (index <= 2){
                    $.post('/home/server/path',{cover_id:data[index].cover_id,time:data[index].create_time},function (path) {
                        var  path1 = path['path'];
                        var time = path['time'];
                        $("<div class='row noticeList'>\
                <div class='col-xs-10'>\
                <p class='title'>"+data[index].title+"</p>\
            <p class='intro'>"+data[index].content+"</p>\
            <p class='info'>地址: "+data[index].address+"<span class='pull-right'> "+time+"</span> </p>\
                </div>\
                </div>").appendTo($("#mydiv"));
                    });
                }

            })
        });
    });
</script>
</body>
</html>