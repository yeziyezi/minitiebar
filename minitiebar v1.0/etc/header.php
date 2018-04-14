<?php 
@session_start();
//依赖
$docroot=$_SERVER['DOCUMENT_ROOT'];
$bar_name=@$_SESSION['bar_viewed_name'];
$bar_id=@$_SESSION['bar_viewed_id'];
?>
<html>
    <head>
    <title>MiniTieBar</title>
    
    <!--网页宽度默认等于屏幕宽度（width=device-width），原始缩放比例（initial-scale=1）为1.0，即网页初始大小占屏幕面积的100%-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <style>
        #logo, #bar_viewd, #right{
           display: inline-block;
           background-color:aliceblue;
        }
        #right{
            float: right;
        }
    </style>
    </head>
    <body>
    <div id="header">
        <div id="logo">
            <strong>MiniTieBar</strong>
        </div>
        
        <!--在中间显示正在浏览的贴吧-->
        <?php if(@isset($bar_name)){
        ?>
        <div id="bar_viewd">
            <?php echo "<a href='/bar.php?bar_id=".$bar_id."'>".$bar_name."吧</a>"?>
        </div>
        <?php
                }
        ?>

        <!--在右边显示一些操作-->
        <!-- 已登录时 -->
        <?php
        if (@isset($_SESSION['logined'])) {
            $username = $_SESSION['username'];
            ?>
        <div id="right">
            welcome,<?php echo $username ?>!
            <a href='/account/safequit.php'>[安全退出]</a>
        </div>
        
        <!-- 未登录时-->
        <?php 
    } else {
        ?>
        <div id="right">
            <a href='/account/login.php'>[登录]</a>&nbsp;&nbsp; 
            <a href='/account/register.php'>[注册]</a> &nbsp;&nbsp;
        </div>                  
        <?php 
    }
    ?>
    </div>
    <br/>