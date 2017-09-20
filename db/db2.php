
<?php
$host='www.b.com';
$user='jack';
$pass='jike1988';

$tb_member='dbmembers';
$tb_user='dbusers';
$tb_user='webuser';
$tb_area='dbareas';
$tb_area='webarea';
$tb_check='radcheck';
$tb_ippool='radippool';
$tb_acct='radacct';
$db='accounting';
$conn=mysqli_connect($host,$user,$pass,$db);
if (mysqli_errno($conn)) {
    die('db connect error:' . mysqli_error($conn));

} 
?>
