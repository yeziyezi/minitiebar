<?php 
$docroot=$_SERVER['DOCUMENT_ROOT'];
require($docroot."/../etc/header.php");//header
//如果已经登录自动跳转到index.php
if(@$_SESSION['logined']==true){
    Header("Location:/index.php");
    exit;
}

//如果用户输入了错误的账号或密码，自动填充上一次输入的账号
@$username_temp=$_SESSION["username_input_by_user"];
if(@isset($username_temp)){
    echo "<script>alert('".$_SESSION['login_error_message']."');</script>";
    unset($_SESSION['username_input_by_user']);
    unset($_SESSION['login_error_message']);
}else{
    $username_temp="";
}

?>
<form method="post" action="/linkup_db/validation/login_validate.php">
    用户名 <br/><input name="username" value="<?php echo $username_temp?>"><br/>
    密码 <br/><input name="password" type="password"><br/>
    <input type="submit" value="登录"><br/>
</form>
找回密码功能正在开发。。。
<a href="/account/getAccountBack.php"></a>



<!-- footer -->
<?php require($docroot."/../etc/footer.php");?>