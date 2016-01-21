<?php

// 用于页面配置数据初始化、所有模块都会使用到





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
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$sql = "select tb1.MenuId,tb1.MenuName,tb1.NodeLevel,tb1.ParentMenuId,tb1.PageId,tb2.ModuleId,tb2.Controller,tb2.Action,tb2.OuterLink
		from(
		     select * from config_menu where ModuleId='".$ModuleId."' and IsActive=1
		) as tb1
		left join(
		     select * from config_page where IsActive=1
		) as tb2
		on tb1.PageId=tb2.PageId";

		$result = DB::Instance()->Get2Arr($sql);
		if(!count($result)){//没有数据
			echo "{}";
		}
		else{
			$result = ToolMethod::Instance()->TranMy2Arr($result);
			$result = ToolMethod::Instance()->GetTreeArr($result);
			$result = json_encode($result);
			$result = str_replace(":null", ':""', $result);
			$result = ltrim($result, "[");
			$result = rtrim($result, "]");
			echo $result;
		}
}

//获取用户自定义树数据
function GetCustomTreeMenuByUserId(){
	$UserId = ToolMethod::Instance()->GetUrlParam("UserId");
	$sql = "select tb1.MenuId,tb1.MenuName,tb1.NodeLevel,tb1.ParentMenuId,tb1.PageId,tb1.UserId,tb2.Controller,tb2.Action,tb2.OuterLink
		from(
		     select * from config_custom_menu where UserId='".$UserId."' and IsActive=1
		) as tb1
		left join(
		     select * from config_page where IsActive=1
		) as tb2
		on tb1.PageId=tb2.PageId";

		$result = DB::Instance()->Get2Arr($sql);
		if(!count($result)){//没有数据
			echo "{}";
		}
		else{
			$result = ToolMethod::Instance()->TranMy2Arr($result);
			$result = ToolMethod::Instance()->GetTreeArr($result);
			$result = json_encode($result);
			$result = str_replace(":null", ':""', $result);
			$result = ltrim($result, "[");
			$result = rtrim($result, "]");
			echo $result;
		}
}

// 获取 Page 数据
function GetPageByPageId(){
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	$sql = "select PageId,PageName,ModuleId,Controller,Action,OuterLink
		from config_page
		where IsActive=1 and PageId='".$PageId."'";
	echo DB::Instance()->UnPageJson($sql);
}

//获取页面按钮数据
function GetPageBtnByPageId(){
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	$sql = "select tb2.BtnId,tb2.BtnClass,tb2.BtnName,tb2.BtnIcon
			from(
			     select * from config_page_btn
			     where IsActive=1 and PageId='".$PageId."'
			     order by Seq
			) as tb1
			inner join(
			     select * from config_btn
			     where IsActive=1
			) as tb2
			on tb1.BtnId=tb2.BtnId";
	echo DB::Instance()->UnPageJson($sql);
}

//获取页面查询参数、显示字段数据
function GetPageParamsAndByPageId(){
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	$sql = "select PageId,QueryParams,ShowFields
			from config_page_param
			where PageId='".$PageId."'";
	echo DB::Instance()->UnPageJson($sql);
}

?>