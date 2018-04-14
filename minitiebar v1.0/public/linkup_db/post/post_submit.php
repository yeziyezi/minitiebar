<?php
session_start();
$docroot=$_SERVER['DOCUMENT_ROOT'];
if(@!isset($_POST['post_title'])){
    echo '无权限访问该页面！';
    exit;
}
echo "贴子正在路上，请稍候。";
//依赖
require($docroot."/../lib/tools.php");
require($docroot."/../lib/PDOtool.php");
//获取数据
$post_title=htmlspecialchars(trim($_POST['post_title']));
$post_content=htmlspecialchars($_POST['post_content']);
date_default_timezone_set("PRC");
$publish_time=date("Y-n-j H:i:s");
$last_reply_time=$publish_time;
$post_id=create_uuid("posts-");
$bar_id=$_SESSION['bar_viewed_id'];
$user_id=$_SESSION['user_id'];
//实例化pdo工具类
$pdo = new PDOtool();
//查询吧对应的表
$query="select bar_post_table_id as table_name from bars where bar_id =:bar_id";
$table_name=$pdo->getOne($query,"table_name",array(":bar_id"=>$bar_id));
$pdo->destroy();
$pdotool=new PDOtool();
//将贴子添加到数据库
$param=array(
    ":post_title"=>$post_title,
    ":post_content"=>$post_content,
    ":publish_time"=>$publish_time,
    ":last_reply_time"=>$last_reply_time,
    ":post_id"=>$post_id,
    ":user_id"=>$user_id,
    ":bar_id"=>$bar_id
);
$query1="insert into ".$table_name." (post_id,post_title,publish_time,last_reply_time,post_content,user_id)values(:post_id,:post_title,:publish_time,:last_reply_time,:post_content,:user_id)";
echo $query1;
//该吧的贴子数量加一
$query2="update bars set post_num=post_num+1 where bar_id = :bar_id ";

//添加贴子和贴吧数量加一用事务处理
$query_array=array($query1,$query2);
$pdotool->transaction($query_array,$param);
$pdotool->destroy();
Header("Location:/bar.php?bar_id=".$bar_id);