<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"D:\www\tp\public/../application/home/view/default/article\lists.html";i:1496373782;s:66:"D:\www\tp\public/../application/home/view/default/base\common.html";i:1511709903;s:63:"D:\www\tp\public/../application/home/view/default/base\var.html";i:1496373782;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo config('WEB_SITE_TITLE'); ?></title>
<link href="__STATIC__/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="__STATIC__/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="__STATIC__/bootstrap/css/docs.css" rel="stylesheet">
<link href="__STATIC__/bootstrap/css/twothink.css" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="__STATIC__/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="__STATIC__/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="__STATIC__/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader'); ?>
</head>
<body>
	<!-- 头部 -->
	<!-- 导航条
	================================================== -->


	<!-- /头部 -->

	<!-- 主体 -->
	
	<header class="jumbotron subhead" id="overview">
		<div class="container">
			<h2>源自相同起点，演绎不同精彩！</h2>
			<p class="lead"></p>
		</div>
	</header>

	<div id="main-container" class="container">
	    <div class="row">
	        
	        <!-- 左侧 nav
	        ================================================== -->
	            <div class="span3 bs-docs-sidebar">
	                
	                <ul class="nav nav-list bs-docs-sidenav">
	                   <?php echo widget('Category/lists', array($category['id'], request()->action() == 'index')); ?>
	                </ul>
	            </div>
	        
	        
      <div class="span9">
        <!-- Contents
        ================================================== -->
        <section id="contents">
					<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
						<div class="row">
									<div class="span2">
											<a href="<?php echo url('Article/detail?id='.$data['id']); ?>"><img class="img-thumbnail" src="__ROOT__<?php echo get_cover_path($data['cover_id']); ?>" /></a>
									</div>
									<div class="span7">
										<h3 class="ellipsis"><a href="<?php echo url('Article/detail?id='.$data['id']); ?>"><?php echo $data['title']; ?></a></h3>
										<p class="lead"><?php echo $data['description']; ?></p>
										<span><a href="<?php echo url('Article/detail?id='.$data['id']); ?>">查看全文</a></span>
										<span class="pull-right">
											<span class="author"><?php echo get_username($data['uid']); ?></span>&nbsp;&nbsp;
											<span>发表于 <?php echo $data['create_time']; ?></span>
											<span>阅读(<?php echo $data['view']; ?>)</span>&nbsp;&nbsp;
										</span>
									</div>
									<hr/>
						</div>
	        <?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="twothink pagination pagination-right pagination-large">
	            <?php $__PAGE__ = \think\Db::name('Document')->paginate($category['list_row'],get_list_count($category['id']));echo $__PAGE__->render(); ?>
            </div>
        </section>
      </div>

	    </div>
	</div>

	<script type="text/javascript">
	    $(function(){
	        $(window).resize(function(){
	            $("#main-container").css("min-height", $(window).height() - 343);
	        }).resize();
	    })
	</script>
	<!-- /主体 -->

	<!-- 底部 -->

    <!-- 底部
    ================================================== -->


	<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "__ROOT__", //当前网站地址
		"APP"    : "__APP__", //当前项目地址
		"PUBLIC" : "__PUBLIC__", //项目公共目录地址
		"DEEP"   : "<?php echo config('URL_PATHINFO_DEPR'); ?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo config('URL_MODEL'); ?>", "<?php echo config('URL_CASE_INSENSITIVE'); ?>", "<?php echo config('URL_HTML_SUFFIX'); ?>"],
		"VAR"    : ["<?php echo config('VAR_MODULE'); ?>", "<?php echo config('VAR_CONTROLLER'); ?>", "<?php echo config('VAR_ACTION'); ?>"]
	}
})();
</script>
	 <!-- 用于加载js代码 -->
	<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
	<?php echo hook('pageFooter', 'widget'); ?>
	<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
		
	</div>

	<!-- /底部 -->
</body>
</html>
