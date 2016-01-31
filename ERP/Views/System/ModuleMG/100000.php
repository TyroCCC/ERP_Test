<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="ie-comp">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width">
		<title>测试</title>
		<style>
		</style>
	</head>
	<body>
		<input type="button" class="btnTest" value="测试" />
		<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
		<script>
			(function(){
				$(function(){
					// GetModule、GetTreeMenuByModuleId、GetCurPageParams
					$.get("../../../Data.php/Comm/Env/GetCurPageParams", function(data){//获取当前页面的配置参数
						//alert(data);
					});
				});

				$(".btnTest").on("click", function(){
					$.get("../../../Data.php/System/ModuleMG/GetModule?ModuleId=test&old_ModuleId=test1&ModuleName=123&old_ModuleName=456", function(data){
						alert(data);
					});
				});
			})();
		</script>
	</body>
</html>