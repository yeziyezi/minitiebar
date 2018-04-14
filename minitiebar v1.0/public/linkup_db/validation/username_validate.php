<?php
if(@!isset($_POST["username"])){
    echo "<h1>Error:无权限访问该页面！</h1>";
    exit;
}
$username=htmlspecialchars(trim($_POST["username"]));
//连接到db需要的全局变量
require($_SERVER['DOCUMENT_ROOT']."/../etc/mysqlinfo.php");
$pdo=new PDO($dsn,$db_username,$db_password);
$query="select count(1) as num from users where username =:username";
$stmt=$pdo->prepare($query);
$stmt->bindValue(":username",$username);
$stmt->execute();
$array=$stmt->fetch();
if($array['num']==0){//如果无查询结果，username不存在，num==0，返回true，触发验证成功
    echo 'true';
}else{
    echo 'false';//否则验证失败
}
