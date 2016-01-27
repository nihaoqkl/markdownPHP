<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>记事本 › 新建</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link href="" type="image/x-icon" rel="icon" />
	<script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

	<script type="text/javascript">
		var is_passwd_set_show = false;
		var is_id_set_show = false;
		var is_login_show = false;
		var is_mynote_show = false;
		var is_menu_show = false;
		var is_set_show = false;

		var is_need_save = false;
		var is_pic_loaded = false;
		var settings = '';

		$(document).ready(function(){
			$("#note-btns-save-ajax").css({"cursor":"default"});
			$("#note-btns-save-ajax").addClass("note-btns-save-ajax-saved");
			$("#note-btns-save-ajax").css({"cursor":"default"}).html("已保存");

			$('#note-btns-setpasswd-form-btn').click(function(){
				if(($('#note-btns-setpasswd-form-input').val()+'').length < 6){
					alert('请输入密码, 长度至少六位!');
					return false;
				}
			});

			var winh=window.innerHeight
				|| document.documentElement.clientHeight
				|| document.body.clientHeight;

			var winw=window.innerWidth
				|| document.documentElement.clientWidth
				|| document.body.clientWidth;

			$("#note-main-form-div").height(winh-48);
			$("textarea").height(winh-68);
			$("#note-mynote").height(winh-48);
			$("#note-menu").height(winh-48);
			$("#note-set").height(winh-48);

			$("#note-btns-setpasswd-form-input").width(winw-120);
			$("#note-btns-setid-form-input").width(winw-120);
			$("#note-btns-login-form-input").width(winw-150);



			var settings_raw = getCookie('myNoteSettings');

			if( !settings_raw ){
				setCookie('myNoteSettings','blue,14',1000000);
				settings = 'blue,14'.split(',');
			}else{
				settings = settings_raw.split(',');
			}

			change_theme(settings[0]);

		});


		//窗口大小改变时调整布局
		window.onresize = function () {
			var winh=window.innerHeight
				|| document.documentElement.clientHeight
				|| document.body.clientHeight;

			var winw=window.innerWidth
				|| document.documentElement.clientWidth
				|| document.body.clientWidth;

			if( is_passwd_set_show ){
				$("#note-main-form-div").height(winh-88);
				$("textarea").height(winh-108);
			}else{
				$("#note-main-form-div").height(winh-48);
				$("textarea").height(winh-68);
			}

			$("#note-btns-setpasswd-form-input").width($("#note-btns-passwdset-form").width()-120);
			$("#note-btns-setid-form-input").width($("#note-btns-setid-form").width()-120);
			$("#note-btns-login-form-input").width($("#note-btns-login-form").width()-150);

			$("#note-mynote").height(winh-48);
			$("#note-menu").height(winh-48);
			$("#note-set").height(winh-48);
			if(is_menu_show){
				$("#note-menu").css("left",winw-250+'px');
			}else{
				$("#note-menu").css("left",winw+'px');
			}
			if(is_set_show){
				$("#note-set").css("left",winw-250+'px');
			}else{
				$("#note-set").css("left",winw+'px');
			}


		}

		function set_from_display(the_id, is_display){
			if( !is_display ){
				$(the_id).slideDown(500);
				$('#note-main-form-div').animate({height:'-=40px'},500);
				$("#note-text-edit").animate({height:'-=40px'},500);
				$("#note-menu").animate({height:'-=40px', top:'+=40px'},500);
				$("#note-mynote").animate({height:'-=40px', top:'+=40px'},500);
			}else{
				$(the_id).slideUp(500);
				$('#note-main-form-div').animate({height:'+=40px'},500);
				$("#note-text-edit").animate({height:'+=40px'},500);
				$("#note-menu").animate({height:'+=40px', top:'-=40px'},500);
				$("#note-mynote").animate({height:'+=40px', top:'-=40px'},500);
			}
		}

		//显示/隐藏 更改密码框
		function psaawd_set_display(){
			set_from_display("#note-btns-passwdset-form", is_passwd_set_show);
			is_passwd_set_show=!is_passwd_set_show;
		}

		//显示/隐藏 更改ID框
		function id_set_display(){
			set_from_display("#note-btns-setid-form", is_id_set_show);
			is_id_set_show=!is_id_set_show;
		}

		//显示/隐藏 登录框
		function login_display(){
			set_from_display("#note-btns-login-form", is_login_show);
			is_login_show=!is_login_show;
		}

		function mynote_display(){
			if( !is_mynote_show ){
				$('#note-mynote').animate({left:'0'});
				is_mynote_show = true;
				$('#note-black').fadeIn();
			}else{
				$('#note-mynote').animate({left:'-260px'});
				is_mynote_show = false;
				$('#note-black').fadeOut();
			}
		}

		function menu_display(){
			var winw=window.innerWidth
				|| document.documentElement.clientWidth
				|| document.body.clientWidth;
			if( is_menu_show ){
				$('#note-menu').animate({left:winw+'px'});
				is_menu_show = false;
				$('#note-menu-black').fadeOut();
			}else{
				$('#note-menu').animate({left:winw-250+'px'});
				is_menu_show = true;
				$('#note-menu-black').fadeIn();
			}
		}

		function set_display(){
			var winw=window.innerWidth
				|| document.documentElement.clientWidth
				|| document.body.clientWidth;
			if( is_set_show ){
				$('#note-set').animate({left:winw+'px'});
				is_set_show = false;
				$('#note-set-black').fadeOut();
			}else{
				$('#note-set').animate({left:winw-250+'px'});
				is_set_show = true;
				$('#note-set-black').fadeIn();
			}
		}

		function setCookie(c_name,value,expiredays){
			var exdate=new Date()
			exdate.setDate(exdate.getDate()+expiredays)
			document.cookie=c_name+ "=" +escape(value)+
				((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
		}

		function getCookie(c_name){
			if (document.cookie.length>0){
				c_start=document.cookie.indexOf(c_name + "=")
				if (c_start!=-1){
					c_start=c_start + c_name.length+1
					c_end=document.cookie.indexOf(";",c_start)
					if (c_end==-1) c_end=document.cookie.length
					return unescape(document.cookie.substring(c_start,c_end))
				}
			}
			return ""
		}

		function change_theme(color){
			settings[0]=color;
			Colors=new Array();
			Colors['black']=['#000','#222'];
			Colors['blue']=['#0072C6','#0062B6'];
			Colors['default']=['#34495E','#1C3146'];
			Colors['green']=['#008A17','#007A07'];
			Colors['green2']=['#03B3B2','#03A3A2'];
			Colors['red']=['#AC193D','#9C092D'];

			$("#header").css("background-color", Colors[color][0]);
			$("#note-set").css("background-color", Colors[color][1]);
			$("#note-mynote").css("background-color", Colors[color][1]);
			$("#note-menu").css("background-color", Colors[color][1]);
			$(".menu-btn").css("background-color", Colors[color][1]);

			setCookie('myNoteSettings', settings, 1000000);
		}

		//使用ajax保存记事本
		function ajax_save(){
			if( is_need_save ){
				$("#note-btns-save-ajax").css({"background-color":"transparent", "cursor":"wait", "padding":"11px 20px 13px 20px"});
				$("#note-btns-save-ajax").css({"cursor":"wait"}).html("保存中");
				$.post("?n=",
					{
						ajax_save:"yes",
						the_note:$("textarea").val(),
						note_type:"home"
					},
					function(data,status){
						$("#note-btns-save-ajax").css({"cursor":"default", "padding":"11px 20px 13px 20px"});
						$("#note-btns-save-ajax").addClass("note-btns-save-ajax-saved");
						$("#note-btns-save-ajax").css({"cursor":"default"}).html("已保存");
						is_need_save = false;
					});
			}
		}

		//内容改变时，已保存按钮 变成 保存
		function note_change(){
			$("#note-btns-save-ajax").css({"background-color":"#3498DB", "cursor":"pointer", "padding":"11px 28px 13px 28px"});
			$("#note-btns-save-ajax").removeClass("note-btns-save-ajax-saved");
			$("#note-btns-save-ajax").css({"cursor":"pointer"}).html("保存");
			is_need_save = true;
		}

		//显示 在其它设备上范围 对话框
		function other_dev_show(){
			$('#note-otherdev').fadeIn();
			if(!is_pic_loaded){
				$('#note-otherdev-img-add').after("<img alt='Loading...' src='//qr.liantu.com/api.php?m=0&fg=222222&w=240&text=http://localhost:8080/markdown/index.php'>");
				is_pic_loaded = true;
			}
		}

		//记事本的下载
		function download_note(){
			$('#download-a').attr({
				"download" : "",
				"href" : "data:text/plain,"+$("textarea").val().replace(/\n/g,"%0a").replace(/\#/g,"%23")
			});
			document.getElementById("download-a").click();
		}

		function delete_note_in_list(noteid,this_btn){
			if(confirm('确定从列表中移除此记事本？\n注意:这不会真正删除此记事本，仅仅是从您的记事本列表中移除')){
				this_btn.style.cursor="wait";
				$.post("./?n="+noteid,
					{
						delete_note_in_list:"yes"
					},
					function(data,status){
						$('#note-list-'+noteid).remove();
					});
			}
			return false;
		}

		//未保存就关闭的警告
		window.onbeforeunload = onbeforeunload_handler;
		function onbeforeunload_handler(){
			if(is_need_save){
				var warning="您的记事本还没有保存，请确认您是否真的要离开。";
				return warning;
			}
		}

		//快捷键Ctrl+s,保存
		$(document).keydown(function(e){
			if( e.ctrlKey && e.which == 83 ){
				ajax_save();
				return false;
			}
		});

	</script>
	<style type="text/css">
		/***** 全局 *****/

		body{
			color: #555;
			font-size: 14px;
			font-family: Noto Sans CJK SC,Microsoft Yahei,Hiragino Sans GB,WenQuanYi Micro Hei,sans-serif !important;
			line-height: 27px;
			background: #fcfcfc;
			width: 1200px;
			margin: 0 auto 10px auto;
		}

		a,input,button{
			outline: none !important;
			-webkit-appearance: none;
			border-radius: 0;
			font-family: Noto Sans CJK SC,Microsoft Yahei,Hiragino Sans GB,WenQuanYi Micro Hei,sans-serif !important;
		}

		button::-moz-focus-inner,input::-moz-focus-inner{
			border-color:transparent !important;
		}

		:focus {
			border: none;
			outline: 0;
		}

		::selection {
			background:#3498DB;
			color:#fff;
		}

		::-moz-selection {
			background:#3498DB;
			color:#fff;
		}

		::-webkit-selection {
			background:#3498DB;
			color:#fff;
		}

		/* 设置滚动条的样式 */
		::-webkit-scrollbar {
			width: 10px;
		}
		/* 滚动槽 */
		::-webkit-scrollbar-track {
			background-color: #eee;
		}
		/* 滚动条滑块 */
		::-webkit-scrollbar-thumb {
			background: rgba(0,0,0,0.1);
		}

		::-webkit-scrollbar-thumb:hover {
			background: rgba(0,0,0,0.3);
		}

		a{
			color: #3498DB;
			text-decoration: none;
		}

		img{
			max-width: 100%;
		}

		h1{
			font-size: 30px;
		}

		h1,h2,h3,h4,h4,h5,h6{
			font-weight:400;
			margin: 0;
		}

		.btn{
			padding: 9px 20px;
			color: #555;
			background: #fff;
			border: 0;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
			cursor: pointer;
			font-size: 14px;
			transition: background-color 0.2s;
		}

		.btn:hover{
			background: #f8f8f8;
		}

		.input{
			font-size: 14px;
			color: #555;
			background: #fff;
			border: 0;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
			padding: 10px;
		}

		#header{
			width: 100%;
			background-color: #34495E;
			height: 48px;
		}

		.header-title{
			display: inline-block;
			height: 24px;
			padding: 13px 16px 11px 16px;
			float: left;
			cursor: pointer;

			transition: background-color 0.2s;
		}

		.header-btn{
			display: inline-block;
			height: 48px;
			padding: 11px 21px 13px 17px;
			float: right;
			font-family: Noto Sans CJK SC,Microsoft Yahei,Hiragino Sans GB,WenQuanYi Micro Hei,sans-serif !important;
			color: #fff;
			background-color: transparent;
			border: 0;
			font-size: 16px;
			margin: 0;

			transition: background-color 0.2s;
		}

		.header-btn:hover, .header-title:hover{
			background-color: #0C2136;
		}

		#note-btns-save-ajax:hover{
			background-color: #2387CA;
		}

		.header-btn div{
			margin-bottom: -7px;
		}

	</style>
</head>
<body>
<!-- 强制主页表单 -->
<form action="./" method="post" style="display:none;" id="force-home-form">
	<input type="hidden" name="force_home" value="yes">
</form>

<!-- 记事本编辑页共用 -->


<!-- 纯文本记事本编辑页 -->


<!-- MarkDown记事本编辑页 -->

<!-- 主页HTML -->

<style type="text/css">
	body{
		margin: 0 auto 20px auto;
		/*max-width: 980px;*/
		width: 100%;
		background-color: #eee;
	}

	.homediv{
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
		background: #fff;
		display: inline-block;
		width: 440px;
		height: 577px;
		padding: 20px;
	}

	.icon{
		line-height: 100%;
		width: 1em;
		height: 1em;
		position: relative;
		display: block;
		float: left;
		clear: both;

	}

	.icon-plus,
	.icon-plus:after {
		position: absolute;
		width: .375em;
		height: .375em;
		border-style: solid;
		border-color: rgb(102, 102, 102); /* #666 */
		font-size: 300px;
	}

	.icon-plus {
		top: 80px;
		left: 94px;
		border-width: 0 .10em .10em 0;
	}

	.icon-plus:after {
		content: "";
		top: .375em;
		left: .375em;
		border-width: .10em 0 0 .10em;
	}


	.icon-file {
		position: absolute;
		top: 60px;
		left: 115px;
		width: .5em;
		height: .75em;
		border-width: .1em;
		border-style: solid;
		border-color: rgb(102, 102, 102); /* #666 */
		background-color: rgb(249, 249, 249); /* #f9f9f9 */
		font-size: 300px;
	}

	.icon-file:before {
		content: "";
		position: absolute;
		top: -.1em;
		left: -.1em;
		width: 0;
		height: 0;
		border-width: .1em;
		border-style: solid;
		border-color: rgb(255, 255, 255) rgb(102, 102, 102) rgb(102, 102, 102) rgb(255, 255, 255); /* #fff and #666 - #fff has to mach body bg*/
	}

	#home-btn-new{
		margin: 442px 0 0 0;
		background: #3498DB;
		color: #fff;
		font-size: 24px;
		padding: 9px 0;
		width: 100%;
	}

	#home-input{
		margin: 442px 0 0 0;
		font-size: 23px;
		width: 285px;
		background: #C6E8FF;
	}

	#home-btn-go{
		margin: 442px 0 0 0;
		background: #3498DB;
		color: #fff;
		font-size: 24px;
		padding: 9px 0;
		float: right;
		width: 119px;
	}

	#back-to-note{
		text-decoration: none;
		background: #3498DB;
		color: #fff;
	}

	#home-btn-new:hover,#home-btn-go:hover,#back-to-note:hover{
		background: #45A9EC;
	}

	@media screen and (max-width: 1030px){
		body{
			margin: 0 auto;
		}

		.icon{
			display: none;
		}

		#home-form-new,#home-form-go{
			width: 410px;
			margin: 40px auto 0 auto;
		}

		.homediv{
			height: 167px;
			clear: both;
			display: block;
			float: none !important;
			margin: 20px auto;
		}

		#home-btn-new,#home-input,#home-btn-go{
			margin: 0;
		}

		#home-input{
			width: 265px;
		}
	}


	@media screen and (max-width: 520px){
		.homediv{
			width: auto;
			height: auto;
			margin: 20px 7px;
		}

		#home-form-new,#home-form-go{
			width: auto;
			margin: 40px auto 0 auto;
		}

		#home-btn-new{
			width: 100%;
			/*margin: 40px 20px 0 20px;*/
		}

		#home-input{
			width: 66%;
		}

		#home-btn-go{
			width: 27%;
		}

	}
	@media screen and (max-width: 420px){
		#home-input{
			width: 60%;
		}

		#home-btn-go{
			width: 27%;
		}

	}
</style>

<div id="header">

	<!-- MarkNote标题 && 返回主页按钮 -->
	<div class="header-title">
		<h1 title="首页" style="display:inline-block;font-size:24px;color:#FCFCFC;border:0;padding:0;cursor:pointer;margin-top:-3px;" onclick="$('#force-home-form').submit();" >MarkNote</h1>
	</div>


</div>

<div style="width:95%;max-width:980px;margin:30px auto;" >

	<div style="clear:both;"></div>

	<div class="homediv">

		<h2>还没有记事本?</h2>
		<p style="margin:12px 0 0 0;">将使用随机的名称新建，可随时更改。也可直接在右侧指定名称新建。</p>

					<span class="icon icon-mid">
						<span class="icon-plus"></span>
					</span>

		<form action="?new=yes" method="post" id="home-form-new" style="clear: both;">
			<button title="使用一个随机的名称创建一个记事本，名称可在稍后更改" id="home-btn-new" class="btn">立刻创建</button>
		</form>

	</div>

	<div style="float:right;" class="homediv">

		<h2>已有记事本 或 指定名称新建记事本</h2>
		<p style="margin:12px 0 0 0;">根据输入的名称访问记事本，若该名称不存在会自动新建。</p>

					<span class="icon icon-mid">
						<span class="icon-file"></span>
					</span>

		<form action="" method="get" id="home-form-go" style="clear: both;">
			<input id="home-input" name="n" type="text" class="input" autofocus="autofocus" placeholder="记事本名称" />
			<button title="根据输入的记事本名称来访问记事本" id="home-btn-go" class="btn">提交</button>
		</form>

	</div>
</div>

</body>
</html>