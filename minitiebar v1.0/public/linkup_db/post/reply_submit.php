<?php
session_start();
//提示
echo "回复正在路上，请稍候。<br/>";
//path
$docroot=$_SERVER["DOCUMENT_ROOT"];
$libpath=$docroot."/../lib";
if(@!isset($_POST['replyer_id'])){
    echo "<h1>无权限访问该页面！</h1>";
    exit;
}
//依赖
require($libpath."/tools.php");
require($libpath."/PDOtool.php");
//整理数据
$reply_content=$_POST['content'];
$user_id=$_POST['replyer_id'];
$post_id=$_SESSION['post_id'];
date_default_timezone_set("PRC");
$reply_time=Date("Y-n-j H:i:s");
$reply_id=create_uuid("r-");
$bar_id=$_SESSION['bar_viewed_id'];
//查询回复表名和贴子表名
$pdo=new PDOtool();
$query="select bar_reply_table_id as rt_id,bar_post_table_id as pt_id from bars where bar_id = '".$bar_id."'";
$result_array=$pdo->getResultArray($query);
$reply_table=$result_array['rt_id'];
$post_table=$result_array['pt_id'];
$pdo->destroy();
//******事务******
$params=array(
    ":reply_id"=>$reply_id,
    ":user_id"=>$user_id,
    ":reply_content"=>$reply_content,
    ":reply_time"=>$reply_time,
    ":post_id"=>$post_id,
    ":last_reply_time"=>$reply_time
);
//查询1.添加回复到回复表
$query1="insert into ".$reply_table." (reply_id,user_id,reply_content,reply_time,post_id)
values(:reply_id,:user_id,:reply_content,:reply_time,:post_id)";
//查询2.贴子表回复数加一，更新最后回复时间
$query2="update ".$post_table." set last_reply_time=:last_reply_time,reply_num=reply_num+1 where post_id=:post_id";
$query_array=array($query1,$query2);
//提交事务
$pdo=new PDOtool();
$pdo->transaction($query_array,$params);
$pdo->destroy();
Header("Location:/tie.php?bar_id=".$bar_id."&post_id=".$post_id);

