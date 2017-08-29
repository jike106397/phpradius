<?php
session_start();
if (isset($_SESSION['username'])) {
    //echo $_SESSION['username'];
    header("Location:index.php");
} 
require_once 'db/db.php';
$user= filter_input(INPUT_POST,'username');
$pass= filter_input(INPUT_POST, 'password');
if (isset($user)) {
    $sql="select count(*),username from {$tb_member} where username='$user' and password='$pass' limit 1";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_row($res);
    $isexists=(int)$row[0];
    if ($isexists>0) {
        $_SESSION['username']=$row[1];        
        header("Location:index.php");
    }     
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>登录</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .login {
                z-index: 1;
                width:500px;
                height:200px;
                margin:auto;
                padding: 50px;
                /*background-color: #00ffff;*/
            }
            body {
                text-align: center;
                background-repeat: no-repeat;
                background-image: url("img/bg.jpg");
                background-size: 100% 100%;
                -moz-background-size: 100% 100%;
                -webkit-background-size: 100% 100%;              
                
            }
            

        </style>
    </head>
    <body >
                  
            <div class="login">
                <form method="post" action="login.php" >
                    <label>用户名：</label><input name="username" type="text"/>
                    <br />
                    <label> 密码   ：</label><input name="password" type="password"/>
                    <br />
                    <input type="submit" value="登录"/>

                </form>
            </div>


    </body>
</html>








<!--





-->






   