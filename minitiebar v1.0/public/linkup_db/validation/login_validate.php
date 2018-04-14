<?php
session_start();
if(@!isset($_POST["username"])){
    echo "<h1>Error:无权限访问该页面！</h1>";
    exit;
}
$docroot=$_SERVER['DOCUMENT_ROOT'];
$username=htmlspecialchars(trim($_POST['username']));
$password=htmlspecialchars(trim($_POST['password']));
//连接数据库
$query="select user_id  from users where username = :username and password=:password";
$param_array=array(
    ":username"=>$username,
    ":password"=>$password
);
require($docroot."/../lib/PDOtool.php");
$pdo = new PDOtool();
$user_id=@$pdo->getOne($query,"user_id",$param_array);
$pdo->destroy();
if($user_id==null){
    //用户不存在或密码错误
    $_SESSION['login_error_message']="账号不存在或密码错误！";
    $_SESSION['username_input_by_user']=$username;
    Header("Location:/account/login.php");
}else{
    //session中存登录状态
    $_SESSION['logined']=true;
    $_SESSION['username']=$username;
    $_SESSION['user_id']=$user_id;
    Header("Location:/index.php"); 
}