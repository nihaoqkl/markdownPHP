<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>记事本 › 9075c02df475a7b9a1</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAABWVBMVEVhVTVSSjVORzROSDRQSTVfVDVcUTVLRTRHQTRHQjRIQzRZUDVgVDVPSDRMRjRdUjXIojrGoTvFoDvHojv8yD37yT37yD37yD32xT72xT71xT71xT7QsVPOsVTOsFTPsVPwwULvwkLvwULvwkLRsVLPsVPPsVPQsVPqvkXpv0XpvkXpvkXWtFDVtFDUs1DVtFDguUrgukrfuUrfuUrfuUrVtFDUtFDUtFDrv0TrwETqv0Tqv0T6xzz6yDz5vDv3rDr6yDz6xzz6xzz6xzxLRDRLRTTFmTrFjznFoTvFoDr6vjz4rjv7yT37yD30uz3yqzz2xT71xT7NqFPLm1LOsFTuuEHsqD/vwkLvwULOqFLMm1HPsVPotUTmpkPpv0XpvkXTq0/Snk7UtFDUs1DesEndokjfukrfuUresErcokjfuUvTq1DRnU7UtFHptUPop0LrwETqv0T////ZQ5XYAAAAAWJLR0QAiAUdSAAAAAlwSFlzAAAN1wAADdcBQiibeAAAAAd0SU1FB98FCA0SEE9zUCEAAAA2SURBVBjTY+BEAwwYAqKi7qLIAFNAUNBdEBlg1yIGBXi0iCEABbbg14JkB0QLlOPo6OgkKgoAn/UWJhIEn78AAAAASUVORK5CYII=" type="image/x-icon" rel="icon" />
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
				$.post("?n=9075c02df475a7b9a1",
					{
						ajax_save:"yes",
						the_note:$("textarea").val(),
						note_type:"text_note"
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
				$('#note-otherdev-img-add').after("<img alt='Loading...' src='//qr.liantu.com/api.php?m=0&fg=222222&w=240&text=http://localhost:8080/markdown/index.php?n=9075c02df475a7b9a1'>");
				is_pic_loaded = true;
			}
		}

		//记事本的下载
		function download_note(){
			$('#download-a').attr({
				"download" : "记事本-9075c02df475a7b9a1.txt",
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
<link href="//cdn.bootcss.com/evil-icons/1.7.6/evil-icons.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/evil-icons/1.7.6/evil-icons.min.js"></script>
<style type="text/css">

	html{
		overflow: hidden;
	}

	body{
		width: 100%;
	}

	#note-btns-save-ajax{
		height: 24px;
		padding: 11px 20px 13px 20px;
	}

	.note-btns-save-ajax-saved:hover{
		background-color: transparent !important;
	}

	textarea{
		line-height: 17px;
		tab-size: 4;-moz-tab-size: 4;-o-tab-size: 4;
		padding: 0;
		margin: 0;
		color: #555;
		background:#FCFCFC;
		border: 0;
		resize: none;
		font-size: 16px;
		font-family: "Source Code Pro","Menlo","Liberation Mono","Consolas","DejaVu Sans Mono","Ubuntu Mono","Courier New","andale mono","lucida console",'文泉驛正黑','Microsoft yahei UI','Microsoft yahei','微软雅黑',"Lato",Helvetica,Arial,sans-serif !important;
	}


	#note-btns-showall{
		display: none;
	}

	@media screen and (max-width: 1064px){
		#note-btns-download-btn{
			display: none;
		}
	}

	@media screen and (max-width: 965px){
		#note-btns-passwd-btn, #note-btns-changeid-btn, #note-btns-tohtml-btn, #note-btns-otherdev-btn, #note-btns-setting-btn{
			display: none;
		}
		#note-btns-showall{
			display: block;
		}
	}


	@media screen and (max-width: 480px){
		.header-title{
			display: none;
		}
	}

	/***** 在其他设备上访问对话框 *****/
	#note-otherdev{
		position: fixed;
		z-index: 110;
	}
	#note-otherdev-black{
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		background-color: rgba(0,0,0,0.2);
		z-index: 111;
	}

	#note-otherdev-div{
		position: fixed;
		width: 300px;
		height: auto;
		top: 50%;
		left: 50%;
		background-color: #fff;
		z-index: 112;
		margin: -200px 0 0 -150px;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
	}

	.note-otherdev-div-divhr{
		width: 100%;
		height: 1px;
		background-color: #aaa;
	}


	.note-mynote-list{
		padding: 2px 20px;
		display: block;
		color: #fff;
		cursor: default;
		transition: background-color 0.2s;
	}

	.note-mynote-list:hover{
		background-color: #0C2136;
	}

	.note-mynote-list div{
		margin-bottom: -8px;
	}

	.menu-btn{
		padding: 10px 20px;
		display: block;
		cursor: default;
		color: #fff;
		border: 0;
		width: 100%;
		background-color: #1C3146;
		text-align: left;
		font-size: 16px;
		transition: background-color 0.2s;
	}

	.menu-btn:hover{
		background-color: #0C2136 !important;
	}

	.menu-btn div{
		margin-bottom: -7px;
		margin-right: 5px;
	}

	.note-btns-set-from{
		display: none;
		height: 40px;
	}

	.note-btns-set-from-input{
		width:870px;box-shadow:0 0 0;height:20px;background-color:#0C2136;font-size:16px;color:#fff;
	}

	.note-btns-set-from-btn{
		float:right;font-size:16px;width:100px;height:40px;box-shadow:0 0 0;background-color:#2387CA;color:#fff;
	}
	.note-btns-set-from-btn:hover{
		background-color:#1377BA;
	}

	.remove-note-x{
		margin-top:-1px;float:right;font-size:16px;cursor:pointer;
		transition: color 0.2s;
	}

	.remove-note-x:hover{
		color: #ccc;
	}

</style>

<form action="?n=9075c02df475a7b9a1" method="post" id="note-btns-passwdset-form" class="note-btns-set-from">
	<input id="note-btns-setpasswd-form-input" class="input note-btns-set-from-input" type="password" name="the_set_passwd" placeholder="请输入要设置的密码"/>
	<input id="note-btns-setpasswd-form-btn" type="submit" value="设置" class="btn note-btns-set-from-btn"/>
</form>

<form action="?n=9075c02df475a7b9a1" method="post" id="note-btns-setid-form" class="note-btns-set-from">
	<input id="note-btns-setid-form-input" class="input note-btns-set-from-input" type="text" name="the_set_id" placeholder="请输入一个新名称，仅字母和数字"/>
	<input id="note-btns-setid-form-btn" type="submit" value="设置" class="btn note-btns-set-from-btn"/>
</form>

<form action="?n=9075c02df475a7b9a1" method="post" id="note-btns-login-form" class="note-btns-set-from">
	<input id="note-btns-login-form-input" class="input note-btns-set-from-input" type="text" name="the_username" placeholder="请输入用户名"/>
	<input id="note-btns-login-form-btn" type="submit" value="登录 / 注册" class="btn note-btns-set-from-btn"  style="width:130px;"/>
</form>

<form action="?n=9075c02df475a7b9a1" method="post" id="note-btns-passwddelete-form" style="display:none;margin:0;">
	<input type="hidden" name="delete_passwd" value="yes" />
</form>

<!-- [在其他设备上访问此记事本]对话框 -->
<div id="note-otherdev" style="display:none;">
	<div id="note-otherdev-black" onclick="$('#note-otherdev').fadeOut();"></div>
	<div id="note-otherdev-div">
		<div style="background:#333;padding:6px 10px 4px 10px;font-size:16px"><h4 style="color:#fff">在其他设备上访问此记事本<span style="float:right;font-size:24px;cursor:pointer;" onclick="$('#note-otherdev').fadeOut();">×</span></h4></div>

		<div class="note-otherdev-div-divhr" style="margin-bottom:8px;"></div>

		<span style="margin-left:10px;">记事本名称: <strong>9075c02df475a7b9a1</strong></span>

		<div style="width:240px; height:240px; margin:10px 30px 30px 30px;">
			<span id='note-otherdev-img-add'></span>
		</div>

		<div class="note-otherdev-div-divhr"></div>

		<div style="background-color:#ddd; height:59px;">
			<button class="btn" style="float:right;margin:10px 10px 10px 0;background-color:#bbb;box-shadow:0 0 0;" onclick="$('#note-otherdev').fadeOut();">关闭</button>
		</div>
	</div>
</div>


<!-- 记事本列表 -->

<!-- 侧边栏菜单,用于小分辨率中 -->
<div id='note-menu-black' onclick="menu_display();" style="position:fixed;top:48px;left:0;background:rgba(0, 0, 0, 0.4);width:100%;height:100%;z-index:99;display:none;"></div>
<div id="note-menu" style="background-color:#1C3146;height:600px;width:250px;left:1440px;position:fixed;top:48px;z-index:100;overflow-x:hidden;overflow-y:auto;color:#fff;">

	<button class="menu-btn" title="显示记事本名称并生成二维码" onclick="other_dev_show();" id="note-menu-btns-otherdev-btn"><div data-icon="ei-link"></div><span>二维码</span></button>

	<!-- 密码 设置 && 删除 表单+按钮 -->
	<button class="menu-btn" id="note-menu-btns-passwd-btn" title="给这个记事本设置一个密码" onclick="psaawd_set_display();"><div data-icon="ei-lock"></div><span>设置密码</span></button>


	<a id="download-a" style="display:none"></a>

	<button class="menu-btn" title="将记事本的内容以文件的方式下载" onclick="download_note();" id="note-menu-btns-download-btn"><div data-icon="ei-arrow-down"></div><span>下载</span></button>

	<button class="menu-btn" id="note-menu-btns-changeid-btn" title="给这个记事本更换一个新的名称"  onclick="id_set_display();"><div data-icon="ei-retweet"></div><span>更换名称</span></button>

	<button class="menu-btn" id="note-menu-btns-setting-btn" title="设置" onclick="set_display();" ><div data-icon="ei-gear"></div><span>设置</span></button>
</div>


<!-- 设置侧边栏 -->
<div id='note-set-black' onclick="set_display();" style="position:fixed;top:48px;left:0;background:rgba(0, 0, 0, 0.4);width:100%;height:100%;z-index:99;display:none;"></div>
<div id="note-set" style="background-color:#1C3146;height:600px;width:250px;left:1440px;position:fixed;top:48px;z-index:100;overflow-x:hidden;overflow-y:auto;color:#fff;">
	<div style="padding:5px 10px;">
		<b style="margin-bottom:5px;">颜色</b><br/>
		<span style="cursor:pointer;display:inline-block;margin-left:6px;width:20px;height:20px;background-color:#0072C6" onclick="change_theme('blue')"></span>
		<span style="cursor:pointer;display:inline-block;margin-left:6px;width:20px;height:20px;background-color:#34495E" onclick="change_theme('default')"></span>
		<span style="cursor:pointer;display:inline-block;margin-left:6px;width:20px;height:20px;background-color:#000" onclick="change_theme('black')"></span>
		<span style="cursor:pointer;display:inline-block;margin-left:6px;width:20px;height:20px;background-color:#008A17" onclick="change_theme('green')"></span>
		<span style="cursor:pointer;display:inline-block;margin-left:6px;width:20px;height:20px;background-color:#03B3B2" onclick="change_theme('green2')"></span>
		<span style="cursor:pointer;display:inline-block;margin-left:6px;width:20px;height:20px;background-color:#AC193D" onclick="change_theme('red')"></span>
	</div>

</div>

<!-- 顶栏 -->
<div id="header">

	<!-- MarkNote标题 && 返回主页按钮 -->
	<div class="header-title"  onclick="$('#force-home-form').submit();" >
		<h1 title="首页" style="display:inline-block;font-size:24px;color:#FCFCFC;border:0;padding:0;cursor:pointer;margin-top:-3px;">MarkNote</h1>
	</div>

	<!-- 登陆按钮 或 我的记事本按钮 -->
	<button title="输入用户名以登陆，登陆后可以记录所有用过的记事本，若用户名不存在则会新建一个" class="header-btn" title="" style="float:left;" onclick="login_display();" ><div data-icon="ei-location"></div>登录 / 注册</button>

	<!-- 保存 -->
	<span class="header-btn" title="也可按Ctrl+S保存" id="note-btns-save-ajax" onclick="ajax_save();">保存</span>

	<button class="header-btn" title="显示记事本名称并生成二维码" onclick="other_dev_show();" id="note-btns-otherdev-btn"><div data-icon="ei-link"></div><span>二维码</span></button>

	<!-- 密码 设置 && 删除 表单+按钮 -->
	<button class="header-btn" id="note-btns-passwd-btn" title="给这个记事本设置一个密码" onclick="psaawd_set_display();"><div data-icon="ei-lock"></div><span>设置密码</span></button>

	<!-- HTML页面 -->

	<!-- 用于下载的data-url的链接标签-->
	<a id="download-a" style="display:none"></a>
	<!-- 下载按钮 -->
	<button class="header-btn" title="将记事本的内容以文件的方式下载" onclick="download_note();" id="note-btns-download-btn"><div data-icon="ei-arrow-down"></div><span>下载</span></button>

	<!-- 更换名称按钮 -->
	<button class="header-btn" id="note-btns-changeid-btn" title="给这个记事本更换一个新的名称"  onclick="id_set_display();"><div data-icon="ei-retweet"></div><span>更换名称</span></button>

	<!-- 设置侧边栏按钮 -->
	<button class="header-btn" id="note-btns-setting-btn" title="设置" onclick="set_display();" ><div data-icon="ei-gear"></div><span>设置</span></button>

	<!-- 在小分辨率下,显示这个菜单按钮 -->
	<button class="header-btn" id="note-btns-showall" title="显示其他功能" onclick="menu_display();"><div data-icon="ei-navicon"></div><span>功能</span></button>

</div>



<!-- 纯文本记事本编辑页 -->

<!-- 大框子 -->
<form action="?n=9075c02df475a7b9a1" method="post" id="note-main-form" style="margin:0 auto;">
	<div id="note-main-form-div" style="padding: 10px;background-color:#eee;">
		<div style="width:100%; height:100%">
			<textarea id="note-text-edit" placeholder="在这里书写" autofocus="autofocus" spellcheck="false" name="the_note" oninput="note_change();" style="width:100%; height:100%;background-color:#eee;"></textarea>
		</div>
	</div>
	<input type="hidden" name="save" value="yes" />
</form>


<!-- MarkDown记事本编辑页 -->

<!-- 主页HTML -->
</body>
</html>