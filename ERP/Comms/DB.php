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

}

?>