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
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<meta http-equiv="Content-Language" content="zh-cn">
<title>红隼管理登录</title>
<meta name="keywords" content="phpradius">
<meta name="description" content="Åµ±öVPSÓÃ»§¹ÜÀíÖÐÐÄ">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/mysite.css" rel="stylesheet">
<script src="js/html5shiv.js"></script>
<script src="js/respond.js"></script>
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" type="text/css" href="css/shop.css">
<link rel="stylesheet" type="text/css" href="css/yun.css">
</head>
<body class="shop">
<link href="css/mysite2.css" rel="stylesheet">  
<div class="container" style="margin-top:20px;">
    <div class="row">
<!--ÓÒ²à¿ªÊ¼²¿·Ö-->
<div class="col-sm-10" id="right">
<h1>管理员登录</h1>
<form name="gof" method="post" action="login.php">
  <table cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFF99" width="268" height="159" align="center">
    <tbody><tr>
      <td width="234" height="43" align="center"><img src="img/login.gif" width="359" height="113"></td>
    </tr>
    <tr>
      <td bgcolor="#FAFAFA" background="img/loginbg.gif" height="180" align="center"><table border="0" width="272">
          <tbody>
            <tr>
              <td height="25" align="left">用户名&nbsp;
              <input tabindex="1" maxlength="20" size="15" name="username"></td>
            </tr>
            <tr>
              <td align="left">密码&nbsp;
              <input tabindex="2" maxlength="20" size="15" name="password" type="password"></td>
            </tr>
            <tr>
            
              <td height="25" align="left">&nbsp;
              <!--
                <input name="vcode" id="vcode" tabindex="2" size="4" maxlength="4" type="text">
                <img src="img/vcode.asp" width="40" height="10">
                -->
                <input src="img/loginbutton.gif" border="0" width="52" type="image" height="18" align="absMiddle"></td>
                
            </tr>
            <tr>
              <td align="center"><table border="0">
                  <tbody>
                   <!-- <TR>
                      <TD><A 
                              href="/agent/register.asp"><IMG 
                              src="/agent/img/reg.gif" width="81" height="26" 
                              border=0></A></TD>
                      <TD width=10></TD>
                      <TD><A 
                              href="/agent/forget.asp"><IMG 
                              src="/agent/img/pass.gif" width="81" height="26" 
                              border=0></A></TD>
                    </TR>-->
                  </tbody>
              </table></td>
            </tr>
          </tbody>
      </table>
        </td>
    </tr>
    <tr>
      <td background="img/loginend.gif" height="5" align="center"></td>
    </tr>
  </tbody></table>
</form>
</div>
<!--ÓÒ²à½áÊø²¿·Ö-->
</div></div></body></html>
<!--
<!DOCTYPE html>

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



-->






   
