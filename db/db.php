<?php

$host='hostname';
$user='user';
$pass='password';

$tb_member='dbmembers';
$tb_user='dbusers';
$tb_user='webuser';
$tb_area='dbareas';
$tb_area='webarea';
$tb_check='radcheck';
$tb_ippool='radippool';
$tb_acct='radacct';
$tb_areacomment='log_webarea';
$db='shareradius';
$conn=mysqli_connect($host,$user,$pass,$db);
if (mysqli_errno($conn)) {
    die('db connect error:' . mysqli_error($conn));  
    
} else {
    mysqli_set_charset($conn,'utf8');
}
?>


