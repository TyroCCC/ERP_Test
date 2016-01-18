<?php

// 配置信息

class Config{

	//单例模式
	static private $_instance;
	private function __construct() { }
	static public function Instance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	//数据库配置
	public $DB = array(
		"host" => "localhost",
		"port" => "",
		"user" => "root",
		"password" => "luohang",
		"database" => "erp"
	);

}

?>