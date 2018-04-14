<?php
    require($_SERVER['DOCUMENT_ROOT']."/../etc/header.php");
    $validate_js_path="/js/validate";
?>
    <h1>欢迎来到MiniTieBar！</h1><br/>
    <?php
        $register_error_message = @$_SESSION['register_error_message'];
        //如果尚未登录，显示注册页面
        if (@$_SESSION['logined'] !== true) {
            if (@isset($register_error_message)) {
                echo "<strong>$register_error_message</strong><br/>";
                unset($_SESSION['register_error_message']);//销毁注册错误信息
            }
    ?>

    请注册，如果已有账号请<a href="/account/login.php">点击此处登录</a>(^_^)<br/>
    <form method="post" action="/linkup_db/validation/register_validate.php" id="register_form">
    用户名<input type="text" name="username" id="username"><br/>
    密码<input type="password" name="password" id="password"><br/>
    确认密码<input type="password" name="repeat_password" id="repeat_password"><br/>
    电子邮箱<input type="text" name="email" id="email"><br/>
    <input type="submit" value="注册">
    </form><br/>
    
    <?php
        }
    ?>
    <script src="<?php echo $validate_js_path?>/jquery-1.7.1.min.js"></script>
    <script src="<?php echo $validate_js_path?>/jquery.validate.min.js"></script>
    <script src="<?php echo $validate_js_path?>/messages_cn.js"></script>
    <script src="<?php echo $validate_js_path?>/register_validate.js"></script>

<!-- footer --> 
<?php require($_SERVER['DOCUMENT_ROOT']."/../etc/footer.php");?>