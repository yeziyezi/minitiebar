<?php
//对注册进行验证并输入数据库
session_start();
if(@!isset($_POST["username"])){
    echo "<h1>Error:无权限访问该页面！</h1>";
    exit;
}
//得到用户输入
$username=htmlspecialchars(trim($_POST['username']));
$password=htmlspecialchars(trim($_POST['password']));
$repeat_password=htmlspecialchars(trim($_POST['repeat_password']));
$email=htmlspecialchars(trim($_POST['email']));

if($password!==$repeat_password){
    $_SESSION['register_error_message']="两次输入的密码不一致！";
    echo "两次输入的密码不一致，请<a href='index.php'>点此返回注册页面</a>重新填写";
    exit;
}


//连接到数据库
//连接到miniTiebar数据库需要的信息
require($_SERVER['DOCUMENT_ROOT']."/../etc/mysqlinfo.php");

//新建一个不会重复的user_id
require_once($_SERVER['DOCUMENT_ROOT']."/../lib/tools.php");
$user_id=create_uuid("user-");
try{
    $pdo=new PDO($dsn,$db_username,$db_password);
    $query="insert into users (user_id,username,password,email) values (:user_id,:username,:password,:email)";
    
    

    //预处理
    $stmt=$pdo->prepare($query);
    $params=array(
        "user_id"=>$user_id,
        "username"=>$username,
        "password"=>$password,
        "email"=>$email
    );
    foreach($params as $k=>$v){
        //这里用bindParam所有的字段值都被绑定了email字段的值，bindValue就没问题。。。。why？
        //因为bindParam中绑定的是引用，所有字段都绑定了$v的引用，而$v这个值一直在变化，迭代结束时$v的值就是email字段的值。
        $stmt->bindValue($k,$v);
    }
    //执行
    $stmt->execute();
    //断开连接
    $pdo=null;
}catch(PDOException $e){
    echo "error : ".$e->getMessage();
}
$_SESSION['username']=$username;
$_SESSION['logined']=true;
$_SESSION['user_id']=$user_id;
Header("Location:/index.php");