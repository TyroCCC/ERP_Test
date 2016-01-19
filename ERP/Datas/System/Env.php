<?php

// 用于页面配置数据初始化





// 获取模块数据
function GetModule(){
	$sql = "select ModuleId,ModuleName 
		from config_module
		where IsActive=1
		order by Seq";
	echo DB::Instance()->UnPageJson($sql);
}

// 获取树菜单数据
function GetTreeMenuByModuleId(){
	// mysql_real_escape_string
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$sql = "select tb1.MenuId,tb1.PageId,tb2.PageName,tb2.ModuleId,tb2.Controller,tb2.Action,tb2.OuterLink
		from(
		     select * from config_menu where ModuleId='".$ModuleId."' and IsActive=1
		) as tb1
		left join(
		     select * from config_page where IsActive=1
		) as tb2
		on tb1.PageId=tb2.PageId";
	echo DB::Instance()->UnPageJson($sql);
}

// 获取自定义树菜单数据
function GetCustomTreeMenuByModuleId(){
	$UserId = ToolMethod::Instance()->GetUrlParam("UserId");
	if($UserId != ""){
		$UserId = User::Instance()->GetUserId();//获取当前登录的UserId
	}
	$sql = "select tb1.MenuId,tb1.PageId,tb2.PageName,tb2.ModuleId,tb2.Controller,tb2.Action,tb2.OuterLink
		from(
		     select * from config_custom_menu where UserId='".$UserId."' and IsActive=1
		) as tb1
		left join(
		     select * from config_page where IsActive=1
		) as tb2
		on tb1.PageId=tb2.PageId";
	echo DB::Instance()->UnPageJson($sql);
}

// 获取 Page 数据
function GetPageByPageId(){
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	$sql = "select PageId,PageName,ModuleId,Controller,Action,OuterLink
		from config_page
		where IsActive=1 and PageId='".$PageId."'";
	echo DB::Instance()->UnPageJson($sql);
}

?>