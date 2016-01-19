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

	//登录信息 Cookies 指定名字
	public $LoginUser = array(
		"UserId" => "_ERP_UserId",
		"UserName" => "_ERP_UserName",
		"UserToken" => "_ERP_Token",
		"KeepTime" => 1//保持时间,单位天
	);

}

?>