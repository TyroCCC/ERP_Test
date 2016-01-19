<?php

// 用户类,主要用于获取用户登录信息

class User{

	//单例模式
	static private $_instance;
	private function __construct() { }
	static public function Instance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function SetUserId($val){
		ToolMethod::Instance()->SetCookies(Config::Instance()->LoginUser["UserId"], $val, Config::Instance()->LoginUser["KeepTime"]);
	}

	function SetUserName($val){
		ToolMethod::Instance()->SetCookies(Config::Instance()->LoginUser["UserName"], $val, Config::Instance()->LoginUser["KeepTime"]);
	}

	function SetUserToken($val){
		ToolMethod::Instance()->SetCookies(Config::Instance()->LoginUser["UserToken"], $val, Config::Instance()->LoginUser["KeepTime"]);
	}

	function GetUserId(){
		return ToolMethod::Instance()->GetCookies(Config::Instance()->LoginUser["UserId"]);
	}

	function GetUserName(){
		return ToolMethod::Instance()->GetCookies(Config::Instance()->LoginUser["UserName"]);
	}

	function GetUserToken(){
		return ToolMethod::Instance()->GetCookies(Config::Instance()->LoginUser["UserToken"]);
	}

}

?>