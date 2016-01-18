<?php

function GetFirstRow(){
	$sql = "select * from config_btn";
	print_r(DB::Instance()->GetFirstRow($sql));
}

function SingleVal(){
	$sql = "select count(*) as total from config_btn";
	echo DB::Instance()->SingleVal($sql, "total");
}

function Get2Arr(){
	$sql = "select * from config_btn";
	print_r(DB::Instance()->Get2Arr($sql));
}

function GetJson(){
	$sql = "select * from config_btn";
	echo DB::Instance()->GetJson($sql);
}

function UnPageJson(){
	$sql = "select * from config_btn";//原始sql
	echo DB::Instance()->UnPageJson($sql);//获取json
}

function UnPageSummaryJson(){
	$sql = "select * from config_btn";//原始sql
	$SummarySql = ToolMethod::Instance()->GetSummarySql($sql, "id", "id", "id");//汇总sql
	echo DB::Instance()->UnPageSummaryJson($sql, $SummarySql);//获取json
}


function PageJson(){
	$sql = "select * from config_btn";//原始sql
	$PagingSql = ToolMethod::Instance()->GetPagingSql($sql,3,1);//分页sql
	$CountSql = ToolMethod::Instance()->GetCountSql($sql);//总数sql
	echo DB::Instance()->PageJson($PagingSql, $CountSql);//获取分页json
}

function PageSummaryJson(){
	$sql = "select * from config_btn";//原始sql
	$PagingSql = ToolMethod::Instance()->GetPagingSql($sql,3,1);//分页sql
	$CountSql = ToolMethod::Instance()->GetCountSql($sql);//总数sql
	$SummarySql = ToolMethod::Instance()->GetSummarySql($sql, "id", "id", "id");//汇总sql
	echo DB::Instance()->PageSummaryJson($PagingSql, $SummarySql, $CountSql);//获取汇总json
}










function Execute(){
	$sql = "
		select * from config_btn;
		update config_btn set name='test' where name='11';
		select * from config_btn222;
	";
	echo DB::Instance()->Execute($sql);
}

?>