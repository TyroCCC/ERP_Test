<?php

//页面统一入口 

$url = $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];

$arr = explode("/", $url);

if(count($arr) == 6){
	$module = $arr[3];
	$controller = $arr[4];
	$action =  $arr[5];
}
else{
	echo "404 Not Found";
	return;
}

if($action == ""){
	echo "404 Not Found";
	return;
}

require_once("./Views/".$module."/".$controller."/".$action.".php");//直接跳转到页面php文件

?>