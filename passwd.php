<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>输入密码</title>
	<style type="text/css">
		body{
			background: #eee;
			margin: 0;
			font-family: Noto Sans CJK SC,Microsoft Yahei,Hiragino Sans GB,WenQuanYi Micro Hei,sans-serif !important;
			line-height: 27px;
		}
		h1,h2,h3{
			font-weight: 400;
			margin: 0;
		}
		#input-passwd{
			font-size: 16px;
			width: 480px;
			padding: 10px;
			margin: 0 15px 0 0;
			color: #333;
			background: #C6E8FF;
			border: 0;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.2);
		}
		#input-submit{
			font-size: 16px;
			padding: 9px 20px;
			color: #fff;
			background: #3498DB;
			border: 0;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.2);
			cursor: pointer;
			transition: background-color 0.2s;
		}
		#input-submit:hover{
			background: #45A9EC;
		}
		#header{
			width: 100%;
			background-color: #0072C6;
			height: 48px;
		}
		.header-title{
			display: inline-block;
			height: 24px;
			padding: 13px 16px 11px 16px;
			float: left;
			cursor: pointer;
		}
		#box{
			max-width: 600px;
			margin: 40px auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0px 2px 6px rgba(100, 100, 100, 0.3);
		}

		@media screen and (max-width: 700px){
			#box{
				width:auto;
				margin: 40px 30px;
			}
			#input-passwd{
				width: 70%;
			}
			#input-submit{
				width: 20%;
			}
		}
		@media screen and (max-width: 500px){
			#input-passwd{
				width: 55%;
				margin: 0 10px 0 0;
			}
			#input-submit{
				width: 30%;
			}
		}
		@media screen and (max-width: 500px){
			#input-passwd{
				width: 100%;
				margin: 0 0 10px 0;
				box-sizing: border-box;
			}
			#input-submit{
				width: 100%;
			}
		}

	</style>
</head>
<body>
<!-- 强制主页表单 -->
<form action="./" method="post" style="display:none;" id="force-home-form">
	<input type="hidden" name="force_home" value="yes">
</form>

<!-- 顶栏 -->
<div id="header">
	<!-- MarkNote标题 && 返回主页按钮 -->
	<div class="header-title"  onclick="$('#force-home-form').submit();" >
		<h1 title="首页" style="display:inline-block;font-size:24px;color:#FCFCFC;border:0;padding:0;cursor:pointer;margin-top:-3px;">MarkNote</h1>
	</div>
</div>

<div id="box">
	<h3 style="margin-bottom:20px;">此记事本设有密码, 请输入密码以继续访问</h3>
	<form action="<?php echo_note_url(); ?>" method="post">
		<input id="input-passwd" type="password" name="GiveYouPasswd" placeholder="密码" style=""/>
		<input id="input-submit" type="submit" value="提交" style="" />
	</form>
</div>
</body>
</html>