<?php
$docroot = $_SERVER["DOCUMENT_ROOT"];
session_start();
//依赖
require($docroot . "/../lib/tools.php");
require($docroot . "/../lib/PDOtool.php");
//查询正在看的吧名并放进session里,在header中展示(代码在header中)
$bar_id = $_GET['bar_id'];
$pdo = new PDOtool();
$query = "select bar_name from bars where bar_id = :bar_id";
$bar_name = $pdo->getOne($query, "bar_name", array(":bar_id" => $bar_id));
$_SESSION['bar_viewed_name'] = $bar_name;
$_SESSION['bar_viewed_id'] = $bar_id;
//header
require($docroot . '/../etc/header.php');
//查询该吧对应的贴子表
$table_name = $pdo->getOne("select bar_post_table_id as table_name from bars where bar_id =:bar_id", "table_name", array(":bar_id" => $bar_id));
if ($table_name == null) {
    echo "<h1>该吧不存在！</h1>";
    exit;
}
//展示10个贴子
$pagenum = 1;
$pagesize = 10;
if (@isset($_GET['bar_page'])) {
    $pagenum = $_GET['bar_page'];
}
$query = "select * from " . $table_name." order by last_reply_time DESC ";
$posts = $pdo->queryByPage($query, $pagenum, $pagesize);//贴子数据的二维数组
$pdo->destroy();
if ($posts == null) {
    echo "<h1>吧中尚无贴子</h1>";
} else {
    //根据user_id查发贴人的username
    require($docroot."/../etc/mysqlinfo.php");
    $pdo = new PDO($dsn,$db_username,$db_password);
    $query="select username from users where user_id =:user_id";
    $stmt=$pdo->prepare($query);
    //如果只有一条数据，返回的是一个一维数组而不是二维数组
    if(count($posts) == count($posts,1)){
        $posts["bar_id"]=$bar_id;
        $stmt->bindValue(":user_id",$posts['user_id']);
        $stmt->execute();
        $posts["username"]=$stmt->fetch()["username"];
        post_digest($posts);
    }else{
        foreach ($posts as $post) {
            $post["bar_id"]=$bar_id;
            $stmt->bindValue(":user_id",$post['user_id']);
            $stmt->execute();
            $post["username"]=$stmt->fetch()["username"];
            post_digest($post);
        }
    }
    
}
//翻页
pagetool($pagenum,queryPostCount($bar_id),$pagesize,$bar_id);
?>

<hr><strong>写点什么吧</strong><br/>
<?php
//生成发帖编辑器
if (@$_SESSION['logined'] == true) {
    post_editor();
} else {
    echo "登陆后可以发帖";
}
?>
<?php 
//查询贴子数
function queryPostCount($bar_id){
    $query="select post_num as num from bars where bar_id='".$bar_id."'";
    $pdo=new PDOtool();
    $num=$pdo->getOne($query,"num"); 
    return $num;
}
function pagetool($curpage,$post_amout,$size,$bar_id){
    $pagemax=(int)($post_amout/$size);
    if($post_amout!=0&&$post_amout%$size>0){
        $pagemax=$pagemax+1;
    }
    if($post_amout==0){
        $pagemax=1;
    }
    $url_prev="/bar.php?bar_id=$bar_id&bar_page=".($curpage-1);
    $url_next="/bar.php?bar_id=$bar_id&bar_page=".($curpage+1);
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
require($docroot . "/../etc/footer.php");
?>  