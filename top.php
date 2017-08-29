
<!DOCTYPE html>
<html>
    <head>
        <title>用户管理系统</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       	<link rel="stylesheet" type="text/css" href="./easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="./easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="./easyui/demo/demo.css">
	<script type="text/javascript" src="./easyui/jquery.min.js"></script>
	<script type="text/javascript" src="./easyui/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="./easyui/locale/easyui-lang-zh_CN.js"></script>
        <script type="text/javascript" src="./easyui/datagrid-filter.js"></script>
        <style>
            .myframe {
                float:left;
                position: relative;
            }
        </style>
    
    </head>
    <body class="easyui-layout" > 
        <div  region="north" style="background-image: url(img/top.jpg);height: 50px;">
            <center>  帐号管理
            <right>
                <a href="logout.php">退出
                <?php
                echo $_SESSION['username'];
                ?>
            </a>
            </right>
            </center>
            
        </div>
         

        

