
<?php
$host='localhost';
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
$db='radius';
$conn=mysqli_connect($host,$user,$pass,$db);
if (mysqli_errno($conn)) {
    die('db connect error:' . mysqli_error($conn));

} 
?>
