<?php
if(@!isset($_POST['reply_id'])){
    echo "<h1>无权限访问该页面</h1>";
}
session_start();
//path
$docroot=$_SERVER['DOCUMENT_ROOT'];
//依赖
require($docroot."/../lib/tools.php");
require($docroot."/../lib/PDOtool.php");
//整理数据
$inner_reply_id=create_uuid("ir-");
$ir_content=$_POST['content'];
$reply_to_id=$_POST['reply_to_id'];
date_default_timezone_set("PRC");
$reply_time=date("Y-n-j H:i:s");
$reply_id=$_POST['reply_id'];
$from_user_id=$_SESSION['user_id'];
$to_user_id=null;
$bar_id=$_SESSION['bar_viewed_id'];
$post_id=$_SESSION['post_id'];
//根据吧id查询reply和inner reply ,post表名
$pdo = new PDOtool();
$query="select bar_reply_table_id as rt_id,bar_inner_reply_table_id as irt_id,bar_post_table_id as pt_id from bars where bar_id = '".$bar_id."'";
$result=$pdo->getResultArray($query);
$pdo->destroy();
$rt_id=$result['rt_id'];//reply表名
$irt_id=$result['irt_id'];//inner reply表名
$pt_id=$result['pt_id'];
//查询被回复者id
$pdo=new PDOtool();
$query=null;
if(strpos($reply_to_id,"ir-")===false){//如果没有ir前缀，回复的是层主，去reply表里查
    $query="select user_id as to_user_id from ".$rt_id." where reply_id='".$reply_to_id."'";
}else{//有ir前缀，回复的时楼中楼，去inner_reply表中查
    $query="select from_user_id as to_user_id from ".$irt_id." where inner_reply_id = '".$reply_to_id."'";
}
$to_user_id=$pdo->getOne($query,"to_user_id");
$pdo->destroy();
//插入数据到ir表中
$params=array(
    ":inner_reply_id"=>$inner_reply_id,
    ":ir_content"=>$ir_content,
    ":reply_to_id"=>$reply_to_id,
    ":reply_time"=>$reply_time,
    ":reply_id"=>$reply_id,
    ":from_user_id"=>$from_user_id,
    ":to_user_id"=>$to_user_id
);
$query="insert into ".$irt_id." (inner_reply_id,ir_content,reply_to_id,reply_time,reply_id,from_user_id,to_user_id) values(:inner_reply_id,:ir_content,:reply_to_id,:reply_time,:reply_id,:from_user_id,:to_user_id)";
$pdo=new PDOtool();
$pdo->query($query,$params);
$pdo->destroy();
//更新贴子最后回复时间todo
$query="update ".$pt_id." set last_reply_time = :last_reply_time where post_id =:post_id";
$params=array(
    ":last_reply_time"=>$reply_time,
    ":post_id"=>$post_id
);
$pdo=new PDOtool();
$pdo->query($query,$params);
$pdo->destroy();
//跳转到之前的页面
$url="/tie.php?bar_id=".$bar_id."&post_id=".$post_id;
Header("Location:".$url);