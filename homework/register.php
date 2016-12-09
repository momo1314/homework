<?php
session_start();
if (!empty($_POST)) {
    if (isset($_POST['username']) && $_POST['username'] != '' &&
        isset($_POST['password']) && $_POST['password'] != '') 
    {
        $username = addslashes($_POST['username']);
        $salt = "haha";
        //$password = md5(md5($_POST['password']).$salt);
        $password = md5(md5($_POST['password'])+$salt);
        try 
        {
            $config = require_once './config.php';
            $pdo = new PDO($config['dsn'], $config['user'], $config['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sel = "select * from user where username='{$username}'";
            $find = $pdo->query($sel);
            $data = $find->fetch(PDO::FETCH_ASSOC);
            if($data['username']){
                echo "<script>alert('用户已存在');location.href='register.php'</script>";
            }
            else{
                $name = $_POST['username'];
                $sql = "insert into user(username,password) values ('$name','$password')";
                $exec = $pdo->query($sql);
                if($exec){
                    echo  "<script>alert('成功');location.href='index.html'</script>";
                }else{
                    echo  "<script>alert('失败');location.href='register.php'</script>";
                }
            }
            
        } 
        catch (PDOException $e) 
        {
            echo "数据库连接失败";
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <link rel="stylesheet" type="text/css" href="/css/demo.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>
<div class="s_center container">

    <form class="form-signin" method="post" action="">
        <h2 class="form-signin-heading">请注册</h2>
        <label class="sr-only">用户名</label>
        <input type="text"  class="form-control" name="username" placeholder="请填写用户名" required autofocus>
        <br />
        <label  class="sr-only">密码</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="密码" required>
        <br />
        <input class="btn btn-lg btn-primary btn-block" id="login-button" type="submit" name="submit" value="注册">
    </form>

</div>
</body>
</html>