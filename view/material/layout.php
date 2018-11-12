<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no"/>
	<title><?php e($title.' - '.config('site_name'));?></title>
	<link rel="stylesheet" href="//cdn.bootcss.com/mdui/0.4.1/css/mdui.min.css">
	<script src="//cdn.bootcss.com/mdui/0.4.1/js/mdui.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js"></script>

	<style>
		.mdui-appbar .mdui-toolbar{
			height:56px;
			font-size: 16px;
		}
		.mdui-toolbar>*{
			padding: 0 6px;
			margin: 0 2px;
			opacity:0.5;
		}
		.mdui-toolbar>.mdui-typo-headline{
			padding: 0 16px 0 0;
		}
		.mdui-toolbar>i{
			padding: 0;
		}
		.mdui-toolbar>a:hover,a.mdui-typo-headline,a.active{
			opacity:1;
		}
		.mdui-container{
			max-width:1200px;
		}
		.mdui-list-item{
			-webkit-transition:none;
			transition:none;
		}
		.mdui-list>.th{
			background-color:initial;
		}
		.mdui-list-item>a{
			width:100%;
			line-height: 48px
		}
		.mdui-list-item{
			margin: 2px 0px;
			padding:0;
		}
		.mdui-toolbar>a:last-child{
			opacity:1;
		}
		@media screen and (max-width:980px){
			.mdui-list-item .mdui-text-right{
				display: none;
			}
			.mdui-container{
				width:100% !important;
				margin:0px;
			}
			.mdui-toolbar>*:not(.mdui-switch){
				display: none;
			}
			.mdui-toolbar>a:last-child,.mdui-toolbar>.mdui-typo-headline,.mdui-toolbar>i:first-child{
				display: block;
			}
		}
        a{
            text-decoration: none;
            color: rgba(0,0,0,.87);
        }

        .obj-list .mdui-col{
            padding: 10px;
        }
        .obj-list .col-title{
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }
        .obj-list .mdui-col:hover{
            background-color: #eaeaea;
        }
        .obj-list .col-icon{
            width: 100%;
            height: 100px;
            text-align: center
        }
        .obj-list .col-icon img{
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
        }
	</style>
</head>
<body class="mdui-theme-accent-blue mdui-theme-primary-indigo">
	<header class="mdui-appbar mdui-color-theme">
		<div class="mdui-toolbar mdui-color-theme mdui-container" style="position: relative">
			<a href="/" class="mdui-typo-headline"><?php e(config('site_name'));?></a>
			<?php foreach((array)$navs as $n=>$l):?>
			<i class="mdui-icon material-icons mdui-icon-dark" style="margin:0;">chevron_right</i>
			<a href="<?php e($l);?>"><?php e($n);?></a>
			<?php endforeach;?>
            <label class="mdui-switch" style="position: absolute;right: 0">
                <img src="http://pan.ilt.me/Images/static/table.png" style="width: 18px;position: relative;top: 5px;right: 5px;">
                <input class="display-type" type="checkbox" <?php echo $_COOKIE['display_type'] == 'table' ? 'checked' : ''; ?>/>
                <i class="mdui-switch-icon"></i>
            </label>
        </div>
	</header>
	
	<div class="mdui-container">
    	<?php view::section('content');?>
  	</div>
</body>
</html>