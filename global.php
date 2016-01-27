<?php

define('MD5_SALT', 'flU3i2w!LCH6COCbM.Nccb');			//加密记事本密码时, 所使用的盐, 请一定要修改为自己设置的
define('MARK_DOWN_TYPE', '<<<-- MarkDown Type Note -->>>');		//Markdown 格式的标记
define('NOTE_CONFIG_FILE', 'config.php');					//MarkNote的配置文件(在使用文件方式时,自动生成)

$rewrite_create_htaccess_file = false;	//是否创建.htaccess文件以尝试实现伪静态
$rewrite_use_better_url = false;			//是否使用伪静态后的URL(如 http://note.domain/记事本名),若环境不支持伪静态则不要开启
//======================================

//加载公共函数
require 'functions.php';
//加载配置
require NOTE_CONFIG_FILE;


