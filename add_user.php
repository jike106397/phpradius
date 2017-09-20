<?php
$arr=array(
    "errorMsg"=>"提交数据错误！！",
    "successMsg"=>"开通成功！！"
    );
$username=filter_input(INPUT_POST,'username');
$password=filter_input(INPUT_POST,'Cleartext_Password');
$pool=filter_input(INPUT_POST,'Pool_Name');
$type=filter_input(INPUT_POST,'Nas_Port_Type');
$expiration=filter_input(INPUT_POST,'Expiration');
if ($username && $password && ($pool!==NULL and $pool!==false) && $type && $expiration) {
        require_once 'db/db.php';
	mysql_query("begin",$conn);
	$sql="insert into radcheck values ('','$username','Cleartext-Password',':=','$password'),('','$username','Pool-Name',':=','$pool'),('','$username','Expiration',':=','$expiration'),('','$username','Simultaneous-Use',':=',1),('','$username','Nas-Port-Type','==','$type')";
	$res1=mysql_query($sql,$conn);
	//$sql="insert into radreply values ('','$username','Mikrotik-Rate-Limit','=','$rate'),('','$username','Acct-Interim-Interval','=',$acct)";
	//$res2=mysql_query($sql,$conn);	
        $sql="insert into dbusers (`username`,`Cleartext_Password`,`Pool_Name`,`Nas_Port_Type`,`Expiration`) values ('$username','$password','$pool','$type','$expiration')";
        $res3=mysql_query($sql,$conn);
	if (1==$res1 &&1==$res3) {
		mysql_query("commit",$conn);
                unset($arr['errorMsg']);
                echo json_encode($arr);
	 } else {
		mysql_query("rollback",$conn);
		$arr['errorMsg']='保存数据失败！！' . mysql_error();
                echo json_encode($arr);
	}
        mysql_close($conn);
} else {
	 echo json_encode($arr);
}    

?>

