<?php

// 依赖 SqlHelper Class, 返回自定义格式的 json

class DB{

	//单例模式
	static private $_instance;
	private function __construct() { }
	static public function Instance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function GetFirstRow($sql){
		return SqlHelper::Instance()->GetFirstRow($sql);
	}

	public function SingleVal($sql, $key){
		return SqlHelper::Instance()->SingleVal($sql, $key);
	}

	public function Get2Arr($sql){
		return SqlHelper::Instance()->Get2Arr($sql);
	}

	public function GetJson($sql){
		$arr = SqlHelper::Instance()->GetJson($sql);
		return $arr[1];
	}

	public function UnPageJson($sql){
		$arr = SqlHelper::Instance()->GetJson($sql);
		$total = $arr[0];
		$rows = $arr[1];
		return '{"total":'.$total.',"rows":'.$rows.'}';
	}

	public function UnPageSummaryJson($sql, $SummarySql){
		$arr = SqlHelper::Instance()->GetJson($sql);
		$total = $arr[0];
		$rows = $arr[1];
		$arr = SqlHelper::Instance()->GetJson($SummarySql);
		$footer = $arr[1];
		return '{"total":'.$total.',"rows":'.$rows.',"footer":'.$footer.'}';
	}

	public function PageJson($PagingSql, $CountSql){
		$total = SqlHelper::Instance()->SingleVal($CountSql, "total");
		$arr = SqlHelper::Instance()->GetJson($PagingSql);
		$rows = $arr[1];
		return '{"total":'.$total.',"rows":'.$rows.'}';
	}

	public function PageSummaryJson($PagingSql, $SummarySql, $CountSql){
		$total = SqlHelper::Instance()->SingleVal($CountSql, "total");
		$arr = SqlHelper::Instance()->GetJson($PagingSql);
		$rows = $arr[1];
		$arr = SqlHelper::Instance()->GetJson($SummarySql);
		$footer = $arr[1];
		return '{"total":'.$total.',"rows":'.$rows.',"footer":'.$footer.'}';
	}

	public function Execute($sql){
		$result = "";
		// try{
			$result = SqlHelper::Instance()->Execute($sql);
			if($result[0] == "OK"){
				$result = '{"result": "'.$result[0].'","rows":'.$result[1].'}';
			}
			else{
				$result = '{"result": "'.$result[0].'","reason":"'.$result[1].'"}';
			}
		// }
		// catch(Exception $e){
			// $result = '{"result": "failed","reason":"'.$e->getMessage().'"}';
		// }  
		return $result;
	}










	// 获取查询参数、返回字段、查询类型,用于sql拼接
	public function GetPageParamForSql(){
		$PageId = ToolMethod::Instance()->GetPageId();
		$sql = "select ParamsId,FieldsId,QuerysType from config_page_param where PageId='".$PageId."'";
		$tmp = DB::Instance()->GetFirstRow($sql);

		$ParamsId = rtrim($tmp["ParamsId"], ",");//查询条件参数列表
		$FieldsId = rtrim($tmp["FieldsId"], ",");//返回字段参数列表
		$QuerysType = rtrim($tmp["QuerysType"], ",");// = 或者 like 的过滤条件

		$result = array(
			"ParamsId" => $ParamsId,
			"FieldsId" => $FieldsId,
			"QuerysType" => $QuerysType
		);
		return $result;
	}

	// 根据配置数据 生成 查询 sql
	public function GetSelectSql($sql){
		$Params = self::GetPageParamForSql();//获取数据库的页面配置数据
		$FieldsId = $Params["FieldsId"];
		$ParamsId = explode(",", $Params["ParamsId"]);
		$QuerysType = explode(",", $Params["QuerysType"]);

		$sql_where = "";
		for ($i=0; $i < count($ParamsId); $i++) {
			$tmp1 = $QuerysType[$i];
			$tmp2 = $ParamsId[$i];

			$tmp3 = ToolMethod::Instance()->GetUrlParam($tmp2);
			if($tmp3 == ""){
				$tmp3 = ToolMethod::Instance()->GetPostParam($tmp2);
			}

			if($tmp1 == "like" && $tmp3 != ""){
				$sql_where .= " and ".$tmp2." ".$tmp1." '%".$tmp3."%'";
			}
			elseif($tmp1 == "=" && $tmp3 != "") {
				$sql_where .= " and ".$tmp2." ".$tmp1." '".$tmp3."'";
			}
		}
		return "select ".$FieldsId." from(".$sql.") as ResultTb where ".ltrim($sql_where, " and");
	}

	// 根据配置数据 生成 插入 sql
	public function GetInsertSql($tb){
		$Params = self::GetPageParamForSql();//获取数据库的页面配置数据
		$ParamsId = explode(",", $Params["ParamsId"]);

		$str = "";
		for ($i=0; $i < count($ParamsId); $i++) {
			$tmp = ToolMethod::Instance()->GetUrlParam($ParamsId[$i]);
			if($tmp == ""){
				$tmp = ToolMethod::Instance()->GetPostParam($ParamsId[$i]);
			}
			$str .= "'".$tmp."',";
		}
		return "insert into ".$tb."(".$Params["ParamsId"].") values(".rtrim($str, ",").")";
	}

	// 根据配置数据 生成 删除 sql
	public function GetDeleteSql($tb){
		$Params = self::GetPageParamForSql();//获取数据库的页面配置数据
		$ParamsId = explode(",", $Params["ParamsId"]);
		$QuerysType = explode(",", $Params["QuerysType"]);

		$sql_where = "";
		for ($i=0; $i < count($ParamsId); $i++) {
			$tmp1 = $QuerysType[$i];
			$tmp2 = $ParamsId[$i];

			$tmp3 = ToolMethod::Instance()->GetUrlParam($tmp2);
			if($tmp3 == ""){
				$tmp3 = ToolMethod::Instance()->GetPostParam($tmp2);
			}

			if($tmp1 == "like" && $tmp3 != ""){
				$sql_where .= " and ".$tmp2." ".$tmp1." '%".$tmp3."%'";
			}
			elseif($tmp1 == "=" && $tmp3 != "") {
				$sql_where .= " and ".$tmp2." ".$tmp1." '".$tmp3."'";
			}
		}
		return "delete from ".$tb." where ".ltrim($sql_where, " and");
	}

	// 根据配置数据 生成 修改 sql
	public function GetModifySql($tb){
		$Params = self::GetPageParamForSql();//获取数据库的页面配置数据
		$ParamsId = explode(",", $Params["ParamsId"]);
		$QuerysType = explode(",", $Params["QuerysType"]);

		$str = "";
		$sql_where = "";
		for ($i=0; $i < count($ParamsId); $i++) {
			$tmp1 = $QuerysType[$i];
			$tmp2 = $ParamsId[$i];

			$tmp3 = ToolMethod::Instance()->GetUrlParam("old_".$tmp2);
			if($tmp3 == ""){
				$tmp3 = ToolMethod::Instance()->GetPostParam("old_".$tmp2);
			}
			if($tmp1 == "like" && $tmp3 != ""){
				$sql_where .= " and ".$tmp2." ".$tmp1." '%".$tmp3."%'";
			}
			elseif($tmp1 == "=" && $tmp3 != "") {
				$sql_where .= " and ".$tmp2." ".$tmp1." '".$tmp3."'";
			}

			$tmp3 = ToolMethod::Instance()->GetUrlParam($tmp2);
			if($tmp3 == ""){
				$tmp3 = ToolMethod::Instance()->GetPostParam($tmp2);
			}
			$str .= $tmp2."='".$tmp3."',";
		}
		return "update ".$tb." set ".rtrim($str, ",")." where ".ltrim($sql_where, " and");
	}

}

?>