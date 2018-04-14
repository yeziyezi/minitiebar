<?php
session_start();
//js
echo "<script src='/js/validate/jquery-1.7.1.min.js'></script>";
//path
$docroot=$_SERVER['DOCUMENT_ROOT'];
$libpath=$docroot.'/../lib';
$etcpath=$docroot.'/../etc';
//依赖
require($libpath.'/tools.php');
require($libpath.'/PDOtool.php');
require($etcpath.'/mysqlinfo.php');
//获取数据
$bar_id=$_GET['bar_id'];
$post_id=$_GET['post_id'];

//校验该吧是否存在
$pdo=new PDOtool();
$query="select bar_post_table_id as pt_id,bar_name,bar_reply_table_id as reply_table,bar_inner_reply_table_id as ir_table  from bars where bar_id = :bar_id";
$result_array=$pdo->getResultArray($query,array(":bar_id"=>$bar_id));
if($result_array==null){
    if(@isset($_SESSION['bar_viewd_id'])){
        unset($_SESSION['bar_viewd_id']);
    }
    if(@isset($_SESSION['bar_viewd_name'])){
        unset($_SESSION['bar_viewd_name']);
    }
    //header
    require($docroot."/../etc/header.php");
    echo "<h1>该吧不存在</h1>";
    exit;
}
$pdo->destroy();
//吧对应的贴子表名，吧名,回复表名,楼中楼表名
$bar_name= $result_array['bar_name'];
$post_table=$result_array['pt_id'];
$reply_table=$result_array['reply_table'];
$inner_reply_table=$result_array['ir_table'];
//header 放在这是因为要更新session中的数据改变header中吧名
$_SESSION['bar_viewed_name']=$bar_name;
$_SESSION['bar_viewed_id']=$bar_id;
require($docroot."/../etc/header.php");
//根据get来的参数查询贴子数据
$query="select * from ".$post_table." where post_id =:post_id";
$pdo=new PDOtool();
$result_array=$pdo->getResultArray($query,array(":post_id"=>$post_id));
if($result_array==null||$result_array==false){
    echo "<h3>贴子不存在</h3>";
    exit;
}
$pdo->destroy();
//保存当前浏览的页面id
$_SESSION['post_id']=$post_id;
//查询发帖人名称
$pdo=new PDOtool();
$query="select username as post_owner from users where user_id='".$result_array['user_id']."'";
$post_owner=$pdo->getOne($query,"post_owner");
$pdo->destroy();
$result_array['post_owner']=$post_owner;
//显示一楼
post_view($result_array);
//查询并显示10条回复:
$page=@$_GET['post_page'];
if(!isset($page)){
    $page=1;
}
$query="select r.reply_id,r.reply_content,r.reply_time,u.username 
from replys_default as r 
left join users as u
on u.user_id=r.user_id
where r.post_id ='".$post_id."' ";
$pdo=new PDOtool();
$replys=$pdo->queryByPage($query,$page,10);
foreach($replys as $reply){
    $reply_id=$reply['reply_id'];
    $inner_replys=queryirs($reply_id,$inner_reply_table);
    reply_view(@isset($_SESSION['logined']),$reply,$inner_replys);
}
function queryirs($reply_id,$inner_reply_table){//查询inner replys
    $pdo=new PDOtool();
    $query="select u1.username as to_username,u2.username as from_username,ir.ir_content,ir.inner_reply_id,ir.reply_id,ir.reply_to_id 
    from $inner_reply_table as ir
    left join users as u1 on u1.user_id=ir.to_user_id
    left join users as u2 on u2.user_id=ir.from_user_id
    where ir.reply_id='$reply_id'
    order by reply_time ASC";
    $stmt=$pdo->query($query);
    $result=$stmt->fetchAll();
    $pdo->destroy();
    return $result;

}
pagetool($page,queryReplyCount($post_table,$post_id),10,$bar_id,$post_id);
echo "<hr>写点什么吧";
//回复编辑器
@$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    echo "<p><strong>登录后可回复</strong></p>";
}else{
    echo "<p>回复贴子</p>";
    reply_editor($user_id);
}
?>

<?php
function queryReplyCount($post_table,$post_id){
    $query="select reply_num as num from ".$post_table." where post_id='".$post_id."'";
    $pdo=new PDOtool();
    $num=$pdo->getOne($query,"num"); 
    return $num;
}
function pagetool($curpage,$post_amout,$size,$bar_id,$post_id){
    $pagemax=(int)($post_amout/$size);
    if($post_amout!=0&&$post_amout%$size>0){
        $pagemax=$pagemax+1;
    }
    if($post_amout==0){
        $pagemax=1;
    }
    $url_prev="/tie.php?bar_id=$bar_id&post_id=$post_id&post_page=".($curpage-1);
    $url_next="/tie.php?bar_id=$bar_id&post_id=$post_id&post_page=".($curpage+1);
    $button_prev="<a href='".$url_prev."'><button>上一页</button></a>";
    $button_next="<a href='".$url_next."'><button>下一页</button></a>";
    if($curpage==1){
        $button_prev=null;
    }
    if($curpage==$pagemax){
        $button_next=null;
    }
    $button_item="<p>".$button_prev."第".$curpage."页".$button_next." 共".$pagemax."页</p>"; 
    echo $button_item;
 
}
//footer
require($docroot."/../etc/footer.php");
?>