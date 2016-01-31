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
	if($ModuleId == ""){
		$ModuleId = ToolMethod::Instance()->GetPostParam("ModuleId");
	}
	$sql = "select tb1.MenuId,tb1.MenuName,tb1.NodeLevel,tb1.ParentMenuId,tb1.PageId,tb1.IconCls,tb1.IconAlign,tb2.ModuleId,tb2.Controller,tb2.Action,tb2.OuterLink
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

// 获取当前页面参数
function GetCurPageParams(){
	$PageId = ToolMethod::Instance()->GetPageId();

	$sql = "select PageId,ParamsId,ParamsType,ParamsName,FieldsId,FieldsName
			from config_page_param
			where PageId='".$PageId."'";
	$tmp = DB::Instance()->GetFirstRow($sql);

	$ParamsId = explode(",", $tmp["ParamsId"]);// , 隔开
	$ParamsType = explode(",", $tmp["ParamsType"]);
	$ParamsName = explode(",", $tmp["ParamsName"]);
	$FieldsId = explode(",", $tmp["FieldsId"]);
	$FieldsName = explode(",", $tmp["FieldsName"]);

	if( 
		( count($ParamsId) == count($ParamsType) && count($ParamsId) == count($ParamsName) )
		&&
		( count($ParamsType) == count($ParamsName) )
		&&
		( count($FieldsId) == count($FieldsName) )
	){
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
		$tmp_Btn = DB::Instance()->GetJson($sql);

		$tmp_Params = "";
		for ($i=0; $i < count($ParamsId); $i++) {
			if($ParamsId[$i] != "" && $ParamsType[$i] != "" && $ParamsName[$i] != ""){
				$tmp_Params .= '{'
					.'"id":'.json_encode($ParamsId[$i]).','
					.'"type":'.json_encode($ParamsType[$i]).','
					.'"name":'.json_encode($ParamsName[$i]).''
					.'},';
			}
		}
		$tmp_Params = rtrim($tmp_Params, ",");

		$tmp_Fields = "";
		for ($i=0; $i < count($FieldsId); $i++) {
			if($FieldsId[$i] != "" && $FieldsName[$i] != ""){
				$tmp_Fields .= '{'
					.'"id":'.json_encode($FieldsId[$i]).','
					.'"name":'.json_encode($FieldsName[$i]).''
					.'},';
			}
		}
		$tmp_Fields = rtrim($tmp_Fields, ",");

		echo 
		'{'
			.'"PageId":'.json_encode($PageId).','
			.'"Params":['.$tmp_Params.'],'
			.'"Fields":['.$tmp_Fields.'],'
			.'"Btns":'.$tmp_Btn.''
		.'}';
	}
	else{
		throw new Exception("Params Error");//配置失败
	}
}

?>