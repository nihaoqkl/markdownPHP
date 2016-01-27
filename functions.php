<?php

function show_error_exit($output,$show_return=true){
	//输出错误信息并终止
	echo '<!DOCTYPE html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<style>body{font-family: "文泉驛正黑","Microsoft yahei UI","Microsoft yahei","微软雅黑","Lato",Helvetica,Arial,sans-serif !important;}button{border: 0;background: #3498DB;color: #fff;font-size: 16px;padding:5px 10px;box-shadow: 0 1px 3px rgba(100, 100, 100, 0.3);}</style><title>MarkNote</title></head>';
	echo '<body style="background-color:#eee;margin:50px auto;width:800px;">';
	echo '<div style="padding:20px;margin:0;color:#555;background:#fff;border:0;box-shadow:0 2px 6px rgba(100, 100, 100, 0.3);">';
	echo '<p style="margin:0 0 5px 0;">'.$output.'</p>';
	if($show_return) echo '<br/><button onclick="history.go(-1)" style="cursor: pointer;" >< 返回</button>';
	echo '</div>';
	echo '</body></html>';
	exit();
}

function echo_note_url($id=0){
	global $rewrite_use_better_url, $noteId;
	if($id==0)$id=$noteId;
	echo ($rewrite_use_better_url ? '' : '?n=') . $id;
}

function reLocation($url){
	global $rewrite_use_better_url;

	header("Location: ". ($rewrite_use_better_url ? '' : '?n=') . $url);
	exit();
}

function encrypt_pass($noteId, $password){
	return md5(MD5_SALT . $noteId . 'MyNote' . $password . 'Let-It-More-Lang');
}