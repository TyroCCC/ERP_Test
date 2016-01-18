<?php

// 数据库操作

class SqlHelper{

	//单例模式
	static private $_instance;
	private function __construct() { }
	static public function Instance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	//连接资源
	static private $_connectSource;

	//创建数据库连接
	private function Connect() {
		if(!self::$_connectSource) {
			if(Config::Instance()->DB["port"] != ""){//存在端口号
				self::$_connectSource = mysql_connect(
					Config::Instance()->DB["host"].":".Config::Instance()->DB["port"], 
					Config::Instance()->DB["user"], 
					Config::Instance()->DB["password"]
				);
			}
			else{
				self::$_connectSource = mysql_connect(
					Config::Instance()->DB["host"], 
					Config::Instance()->DB["user"], 
					Config::Instance()->DB["password"]
				);
			}

			if(!self::$_connectSource) {
				throw new Exception("mysql connect error".mysql_error());
			}
			
			mysql_select_db(Config::Instance()->DB["database"], self::$_connectSource);
			mysql_query("set names UTF8", self::$_connectSource);
		}
		return self::$_connectSource;
	}

	//获取Mysql结果集中的表字段
	private function GetFieldsFromTb($result){
		$fieldArr = array();
		$i  =  0;
		while($i < mysql_num_fields($result)){
			$fieldArr[] = mysql_field_name($result, $i);//获取字段
			$i++;
		}
		return $fieldArr;
	}

	//获取Mysql结果集中的数据
	private function GetJsonStrFormTb($fieldArr, $result){
		$str = '';
		$j = 0;
		while($row = mysql_fetch_row($result)){//拼接json
			$k = 0;
			$rowStr = '{';
			foreach ($row as $key => $value) {
				$rowStr .= '"'.$fieldArr[$k].'":'.json_encode($value);//unicode编码
				if($k <= count($row) -2){
					$rowStr .= ',';
				}
				$k++;
			}
			$rowStr .= '}';

			$str .= $rowStr;
			if($j <= mysql_num_rows($result) -2){
				$str .= ',';
			}
			$j++;
		}

		$json = '['.$str.']';

		$result = array();
		$result[] = $j;
		$result[] = $json;
		return $result;
	}










	//返回数据集的第一行记录
	public function GetFirstRow($sql){
		$connect = self::Connect();
		$result = mysql_query($sql, $connect);
		if(!$result){
			throw new Exception(mysql_error());//抛出错误
		}
		
		$arr = mysql_fetch_assoc($result);
		return $arr;
	}

	//返回单一值
	public function SingleVal($sql, $key){
		$arr = self::GetFirstRow($sql);
		return $arr[$key];
	}

	//返回二维数组
	public function Get2Arr($sql){
		$connect = self::Connect();
		$result = mysql_query($sql, $connect);
		if(!$result){
			throw new Exception(mysql_error());//抛出错误
		}

		$fieldArr = self::GetFieldsFromTb($result);
		$resultArr = array();
		$i = 0;
		while($row = mysql_fetch_row($result)){
			$j = 0;
			foreach ($row as $key => $value) {
				$resultArr[$i][$j] = array(
					"name" => $fieldArr[$j],
					"value" => $value
				);
				$j++;
			}
			$i++;
		}
		return $resultArr;
	}

	//返回json [ 数量, "[{json字符串}]" ]
	public function GetJson($sql){
		$connect = self::Connect();
		$result = mysql_query($sql, $connect);
		if(!$result){
			throw new Exception(mysql_error());//抛出错误
		}

		$fieldArr = self::GetFieldsFromTb($result);
		return self::GetJsonStrFormTb($fieldArr, $result);
	}

	//执行增删改 [ , ]
	public function Execute($sql){//支持事务操作,一般MYSQL数据库默认的引擎是MyISAM,这种引擎不支持事务,需要修改
		$sqlError = "";
		$sqlSuccess = "";

		$connect = self::Connect();

		mysql_query("BEGIN", $connect);

		$arr = explode(";", $sql);//以 ; 分割 sql
		for($i=0; $i<count($arr); $i++){

			$tmp_sql = trim($arr[$i]);

			if($tmp_sql != ""){

				$tmp_result = mysql_query($tmp_sql, $connect);
				if(!$tmp_result){
					$sqlError .= mysql_error()."; ";//保存sql错误信息
					break;
				}
				else{
					try{
						$fieldArr = @self::GetFieldsFromTb($tmp_result);
						$sqlSuccess = @self::GetJsonStrFormTb($fieldArr, $tmp_result);//当存在查询语句时, 返回最后一条查询结果
						$sqlSuccess = $sqlSuccess[1];
					}
					catch(Exception $e){
						$sqlSuccess = "[]";
					}
				}
			}
		}

		$result = array();
		if($sqlError == ""){//所有语句 OK
			mysql_query("COMMIT", $connect);//提交
			$result[] = "OK";
			$result[] = $sqlSuccess;
		}
		else{
			mysql_query("ROLLBACK", $connect);//回滚
			$result[] = "failed";
			$result[] = $sqlError;
		}

		mysql_query("END", $connect);

		return $result;
	}

}

?>