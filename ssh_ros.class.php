<?php
class fendian {
        var $host;        
        var $user;//用户名       
        var $passwd;//密码  
        var $port;  
        // 链接远程服务器  
        function getall(){            
            $info=array();            
            $connection = ssh2_connect($this->host, $this->port);        
            if (!$connection) {                
                 $info['errorinfo']='connection to '.$this->host.':'.$this->port.' failed'; 
                 return json_encode($info);
             }    
            // 获取验证方式并打印        
             $auth_methods = ssh2_auth_none($connection, $this->user);    
             //print_r( $auth_methods.'<br/>');    
             if (in_array('password', $auth_methods ))   {    
                 // 通过password方式登录远程服务器        
                 if (ssh2_auth_password($connection, $this->user, $this->passwd))    {
                     //echo $this->user.' login OK<br/>';  
                     $info['errorinfo']='login OK';
                     //获取主机名
                     $cmd=":put [/system identity get name]";
                     $stream = ssh2_exec($connection, $cmd); // 执行php                       
                     stream_set_blocking($stream, true); // 获取执行pwd后的内容    
                     if ($stream === FALSE) {
                         $info['errorinfo']=("stream failed"); 
                         return json_encode($info);
                     }    
                     $info['hostname']= str_replace(array("\r\n", "\r", "\n"),'',stream_get_contents($stream)); 
                     
                     
                     //获取CPU数量
                     $cmd=":put [/system resource get cpu-count]";
                     $stream = ssh2_exec($connection, $cmd); // 执行php                       
                     stream_set_blocking($stream, true); // 获取执行pwd后的内容    
                     if ($stream === FALSE) {
                         $info['errorinfo']=("stream failed"); 
                         return json_encode($info);
                     }    
                     $info['cpu_count']=str_replace(array("\r\n", "\r", "\n"),'',stream_get_contents($stream)); 
                     
                     //获取CPU使用率
                     $cmd=":put [/system resource get cpu-load]";
                     $stream = ssh2_exec($connection, $cmd); // 执行php                       
                     stream_set_blocking($stream, true); // 获取执行pwd后的内容    
                     if ($stream === FALSE) {
                         $info['errorinfo']=("stream failed"); 
                         return json_encode($info);
                     }    
                     $info['cpu_load']=str_replace(array("\r\n", "\r", "\n"),'',stream_get_contents($stream)); 
                     
                     
                     //获取内存数
                     $cmd=":put [/system resource get total-memory]";
                     $stream = ssh2_exec($connection, $cmd); // 执行php                       
                     stream_set_blocking($stream, true); // 获取执行pwd后的内容    
                     if ($stream === FALSE) {
                         $info['errorinfo']=("stream failed"); 
                         return json_encode($info);
                     }    
                     $info['total_memory']=str_replace(array("\r\n", "\r", "\n"),'',stream_get_contents($stream)); 
                     
                      //获取版本号
                     $cmd=":put [/system resource get version]";
                     $stream = ssh2_exec($connection, $cmd); // 执行php                       
                     stream_set_blocking($stream, true); // 获取执行pwd后的内容    
                     if ($stream === FALSE) {
                         $info['errorinfo']=("stream failed"); 
                         return json_encode($info);
                     }    
                     $info['version']=str_replace(array("\r\n", "\r", "\n"),'',stream_get_contents($stream)); 
                     
                     
                     //获取PPPOE数量
                     $cmd=":put [:len [/interface pppoe-client find]]";
                     $stream = ssh2_exec($connection, $cmd); // 执行php                       
                     stream_set_blocking($stream, true); // 获取执行pwd后的内容    
                     if ($stream === FALSE) {
                         $info['errorinfo']=("stream failed"); 
                         return json_encode($info);
                     }    
                     $info['pppoe_count']=str_replace(array("\r\n", "\r", "\n"),'',stream_get_contents($stream)); 
                     
                      //获取在线PPPOE数量
                     $cmd=":put [:len [/interface pppoe-client find running=yes]]";
                     $stream = ssh2_exec($connection, $cmd); // 执行php                       
                     stream_set_blocking($stream, true); // 获取执行pwd后的内容    
                     if ($stream === FALSE) {
                         $info['errorinfo']=("stream failed"); 
                         return json_encode($info);
                     }    
                     $info['pppoe_running_count']=str_replace(array("\r\n", "\r", "\n"),'',stream_get_contents($stream)); 
                     
                     //获取启动时间
                     $cmd=":put [/system resource get uptime]";
                     $stream = ssh2_exec($connection, $cmd); // 执行php                       
                     stream_set_blocking($stream, true); // 获取执行pwd后的内容    
                     if ($stream === FALSE) {
                         $info['errorinfo']=("stream failed"); 
                         return json_encode($info);
                     }    
                     $info['uptime']=str_replace(array("\r\n", "\r", "\n"),'',stream_get_contents($stream)); 
                 }   else   {    
                     $info['errorinfo']=( $this->user.' login Failed<br/>');  
                     return json_encode($info);
                 }     
            }  
            $info['errorinfo']=("success"); 
            return $info;
        }
        
}

function savesql($arr,$areaid) {
    $host='43.241.48.196';
    $user='jack';
    $pass='jike1988';
    $db='radius';
    $conn=mysql_connect($host,$user,$pass);
    if (!$conn) {
        die('db connect error:' . mysql_error());
    } else {
        $res=mysql_set_charset('utf8',$conn);
        $res=mysql_select_db($db,$conn);
    }
    $colmns='';
    $values='';
    $ss='';
    foreach( $arr as $key=>$value) {  
       $ss="$ss$key='$value',";
    }
    $ss= $ss.'updatetime=now()';

    $sql="update webarea_status set $ss where areaid='$areaid'";
    $res=mysql_query($sql,$conn);
    echo $sql;
    echo"\r\n";
    var_dump($res);
    mysql_close($conn);
    
}

$ros=new fendian();
$ros->host='222.187.222.126';
$ros->port=2233;
$ros->user='admin';
$ros->passwd='sudu9999!@#';

$arr=$ros->getall();
savesql($arr,'3');

 
?>
