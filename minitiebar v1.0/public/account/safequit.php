<?php
echo "<h1>正在退出...</h1>";
session_start();
session_destroy();
unset($_SESSION);
Header("Location:/index.php");