<?php

$cmdname=array('NAS管理'=>'nas',
						'地区管理'=>'area',
						"IP管理"=>'ip',
						"用户管理"=>'user',
						"在线用户"=>'onlineuser',
						"会员管理"=>'member',
						"组管理"=>'membergroup',
						"线路统计"=>'analyze',
						"上网日志"=>'log');

$host='radius.dshoub.cn';
$user='root';
$pass='jike@1988';

$tb_member='hsmembers';
$tb_membergroup='hsmembergroup';
$tb_user='hsusers';
//$tb_user='webuser';
$tb_area='hsareas';
//$tb_area='webarea';
$tb_check='radcheck';
$tb_ippool='radippool';
$tb_acct='radacct';
$tb_areacomment='log_webarea';
$db='radius';
$conn=mysqli_connect($host,$user,$pass,$db);
if (mysqli_errno($conn)) {
    die('db connect error:' . mysqli_error($conn));  
    
} else {
    mysqli_set_charset($conn,'utf8');
}
?>


