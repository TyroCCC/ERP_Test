<?php

// 模块管理





// 获取模块数据
function GetModule(){
	$sql = "select * from config_module";//原始sql
	$SelectSql = DB::Instance()->GetSelectSql($sql);
	$InsertSql = DB::Instance()->GetInsertSql("config_module");
	$DeleteSql = DB::Instance()->GetDeleteSql("config_module");
	$ModifySql = DB::Instance()->GetModifySql("config_module");

	print_r($SelectSql);
	print_r("\n\n");
	print_r($InsertSql);
	print_r("\n\n");
	print_r($DeleteSql);
	print_r("\n\n");
	print_r($ModifySql);
}

?>