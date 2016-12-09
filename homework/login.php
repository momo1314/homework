<?php
session_start();
if (!empty($_POST)) {
    if (isset($_POST['username']) && $_POST['username'] != '' &&
        isset($_POST['password']) && $_POST['password'] != '') 
    {
        $username = addslashes($_POST['username']);
        $salt = "haha";
        $password = md5(md5($_POST['password'])+$salt);
        try 
        {
            $config = require_once './config.php';
            $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $res = $pdo->query("select * from user where username='{$username}'");
            $data = $res->fetch(PDO::FETCH_ASSOC);
            if ($password == $data['password']) 
            {
                echo '登录成功';
            }
            else 
            {
                echo "<script>alert('登录失败,请检查是否注册');location.href='index.html'</script>";
            }
        } 
        catch (PDOException $e) 
        {
            echo "数据库连接失败";
        }
    }
    else
    {
        echo '表单未填完整';
    }
}
?>