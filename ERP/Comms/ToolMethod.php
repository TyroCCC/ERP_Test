<?php

// 常用方法

class ToolMethod{

	//单例模式
	static private $_instance;
	private function __construct() { }
	static public function Instance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	//获取分页sql
	function GetPagingSql($sql, $rows, $page){
        return "select * from(".$sql.") as PagingSqlTb limit ".(($page-1) * $rows).",".$rows;
    }

    //获取总数sql
	function GetCountSql($sql){
        return "select count(*) as total from(".$sql.") as CountSqlTb";
    }

    //获取汇总sql
	function GetSummarySql(){
		$args = func_get_args();//不定项参数
		$sql = $args[0];
		$len = count($args);
		$sumStr = "";
		for($i=1; $i<$len; $i++){
			$sumStr .= "sum(".$args[$i].") as ".$args[$i];
			if($i <= $len-2){
				$sumStr .= ",";
			}
		}
        return "select ".$sumStr." from(".$sql.") as SummarySqlTb";
    }

	//获取url参数
	function GetUrlParam($param){
		if(is_array($_GET) && count($_GET) > 0){
			if(isset($_GET[$param])){
				return $_GET[$param];
			}
		}
		return "";
	}

	//获取post参数
	function GetPostParam($param){
		if(isset($_POST[$param])){
			return $_POST[$param];
		}
		return "";
	}

	//获取cookies
	function GetCookies($name){
		if(isset($_COOKIE[$name])){
			return $_COOKIE[$name];
		}
		return "";
	}

	//设置cookies 天
	function SetCookies($name, $val, $d){
		$expire = time() + 60 * 60 * 24 * $d;
		setcookie($name, json_encode($val), $expire);
	}


























	//获取 easyui 表格控件 页码 参数, 默认为 1 
	function GetEasyUiDataGridPage(){
		$page = GetPostParam("page");
	 	if ($page == ""){
            $page = "1";
        }
        return $page;
	}

	//获取 easyui 表格控件 行数 参数,默认为 10
	function GetEasyUiDataGridRows(){
		$rows = GetPostParam("rows");
		if ($rows == ""){
			$rows = "10";
		}
		return $rows;
	}

	//获取 easyui 表格控件 排序字段, 默认为 ""
	function GetEasyUiDataGridSort(){
		return GetPostParam("sort");
	}

	//获取 easyui 表格控件 排序规则,默认为 ""
	function GetEasyUiDataGridOrder(){
		return GetPostParam("order");
	}
	
}

?>