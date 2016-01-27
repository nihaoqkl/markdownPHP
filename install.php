<?php
	if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

		$use_sql=true;
		$sql_host=$_POST['sql_host'];
		$sql_user=$_POST['sql_user'];
		$sql_passwd=$_POST['sql_passwd'];
		$sql_name=$_POST['sql_name'];
		$sql_table='note_data';
		$sql_table_user='note_user';

		$notesql = mysqli_connect($sql_host, $sql_user, $sql_passwd, $sql_name);
		if(!$notesql) exit("服务器端错误：无法连接数据库,请修正数据库连接信息或使用文件存储方式");

		if( !mysqli_query($notesql,"SELECT * FROM ".$sql_table) ){

			$is_ok = mysqli_query($notesql,"CREATE TABLE ".$sql_table." (
					num int NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(num),
					ID tinytext,
					passwd tinytext,
					content longtext
				)");

			if(!$is_ok) exit("服务器端错误：无法创建数据库表,请修正数据库连接信息或使用文件存储方式");
		}

		if( !mysqli_query($notesql,"SELECT * FROM ".$sql_table_user) ){

			$is_ok = mysqli_query($notesql,"CREATE TABLE ".$sql_table_user." (
					num int NOT NULL AUTO_INCREMENT,
					PRIMARY KEY(num),
					username tinytext,
					notes longtext
				)");

			if(!$is_ok) exit("服务器端错误：无法创建数据库表,请修正数据库连接信息或使用文件存储方式");
		}

		//创建伪静态
		if( !file_exists(".htaccess") && $rewrite_create_htaccess_file ){
			$htaccess_file_content =
				"### MarkNote RewriteRule start
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteRule ^([a-zA-Z0-9]+)$ index.php?n=$1
	RewriteRule ^([a-zA-Z0-9]+).html$ index.php?n=$1&html=yes
</IfModule>
### MarkNote RewriteRule end
";
			file_put_contents('.htaccess', $htaccess_file_content);
		}

		$to_config_file=
			'<?php
	$use_sql=true;
	$sql_host="'.$sql_host.'";
	$sql_user="'.$sql_user.'";
	$sql_passwd="'.$sql_passwd.'";
	$sql_name="'.$sql_name.'";
	$sql_table="'.$sql_table.'";
	$sql_table_user="'.$sql_table_user.'";
?>
';
		file_put_contents("config.php", $to_config_file);
		exit('安装成功,<a href="/markdown/index.php"></a>');
} else { ?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<style>
		body{font-family: "文泉驛正黑","Microsoft yahei UI","Microsoft yahei","微软雅黑","Lato",Helvetica,Arial,sans-serif !important;}
		button{border: 0;background: #3498DB;color: #fff;font-size: 16px;padding:5px 10px;box-shadow: 0 1px 3px rgba(100, 100, 100, 0.3);}
	</style>
	<title>MarkNote</title>
</head>
<body style="background-color:#eee;margin:50px auto;width:800px;">
<div style="padding:20px;margin:0;color:#555;background:#fff;border:0;box-shadow:0 2px 6px rgba(100, 100, 100, 0.3);">
	<p style="margin:0 0 5px 0;">
		<h1 style="font-weight:100;margin:0;"">请选择记事本的存储方式</h1>
		<br/>
		<h2 style="font-weight:100;margin:0 0 5px 0;border-bottom:solid 2px #ddd;">使用文件方式</h2>
		<p style="margin: 5px 0;">点击确定以使用文件方式存储,并自动生成所需文件</p>
		<form action="" method="post">
			<input type="hidden" name="mode" value="file">
			<button>确定,使用文件方式</button>
		</form>
		<br/>
		<br/>
		<h3 style="font-weight:100;margin:0 0 5px 0;border-bottom:solid 2px #ddd;">使用MySQL方式</h3>
		<p style="margin: 5px 0;">填写数据库连接信息,并点击确定以使用MySQL方式存储</p>
		<form action="" method="post">
			<input type="hidden" name="mode" value="sql">
			<div style="margin-bottom:5px"><span style="width:400px;display:inline-block;">数据库主机</span>								<input type="text" name="sql_host" 	placeholder="Host" value="localhost" /></div>
			<div style="margin-bottom:5px"><span style="width:400px;display:inline-block;">数据库用户</span>								<input type="text" name="sql_user" 	placeholder="User" value="root" /></div>
			<div style="margin-bottom:5px"><span style="width:400px;display:inline-block;">密码</span>									<input type="text" name="sql_passwd" placeholder="Password" /></div>
			<div style="margin-bottom:5px"><span style="width:400px;display:inline-block;">数据库名</span>								<input type="text" name="sql_name" 	placeholder="Database Name" value="marknote" /></div>
			<button>确定,使用MySQL方式</button>
		</form>
	</p>
</div>
</body>
</html>
<?php } ?>