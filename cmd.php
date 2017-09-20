<?php
require_once './db/session.php';

    

$cmd= isset($_GET['cmd'])?$_GET['cmd']:0;
$type= isset($_GET['type'])?$_GET['type']:0;
if (!aclfilter($type)) {
    die('no privileges');
}
if('get'===$cmd){
    switch($type){
        case 'user'://帐号显示
            getuser();  
            break;
        case 'nas':
            getnas();
            break;
        case 'area':
            getarea(0);
            break;
        case 'areacomment';            
            getareacomment();
            break;
        case 'area2':
            getarea(2);
            break;
        case 'member':
            getmember();
            break;
        case 'onlineuser':
            getonlineuser();
            break;
        case 'ip':
            getip();
            break;
        case 'log':
            getlog();
            break;
        case 'analyze':
            getanalyze();
            break;
        case 'membergroup':
            getmembergroup();
            break;
        default:
            break;        
    }   
}

if('add'===$cmd){
    switch($type){
        case 'user':
            adduser();
            break;
        case 'nas':
            addnas();
            break;
        case 'area':
            addarea();
            break;
        case 'areacomment':
            addareacomment();
            break;
        case 'member':
            addmember();
            break;
        case 'membergroup':
            addmembergroup();
            break;
        default:
            break;        
    }   
}


if('edit'===$cmd){
    switch($type){
        case 'user':
            edituser();
            break;
        case 'nas':
            editnas();
            break;
        case 'area':
            editarea();
            break;
        case 'member':
            editmember();
            break;
        case 'membergroup':
            editmembergroup();
            break;
        default:
            break;        
    }   
}
if('remove'===$cmd) {
    switch($type) {
        case 'user':
            removeuser();
            break;
        case 'nas':
            removenas();
            break;
        case 'area':
            removearea();
            break;
        case 'member':
            removemember();
            break;
        case 'membergroup':
            removemembergroup();
            break;
        default:
            break; 
    }
}

if ('disconnect'===$cmd) {
            disconnect();            
}



function editarea() {
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"保存地区成功！！"
        );
    $areaid=filter_input(INPUT_POST,'areaid');
    $areaname=filter_input(INPUT_POST,'areaname');
    $qq=filter_input(INPUT_POST,'qq');
    $tel=filter_input(INPUT_POST,'tel');
    $yuancheng=filter_input(INPUT_POST,'yuancheng');
    if($areaname && $qq && $tel && $yuancheng) {
        require './db/db.php';
        $sql="update {$tb_area} set areaname='$areaname',qq='$qq',tel='$tel',yuancheng='$yuancheng' where areaid='$areaid'";
        $res= mysqli_query($conn, $sql);
        if ($res) {
            unset($arr['errorMsg']);
            echo json_encode($arr);
        } else {
           $arr['errorMsg']='保存地区失败！！' . mysql_error() ;
           echo json_encode($arr);
        }
        mysqli_close($conn);
    }  else {
        $arr['errorMsg']="提交数据错误 areaid=$areaid ,reaname={$areaname},qq={$qq},tel={$tel},yuancheng={$yuancheng}";
        echo json_encode($arr);
    }  
    
}


function edituser(){
    
    $username=filter_input(INPUT_POST,'username');
    $password=filter_input(INPUT_POST,'Cleartext_Password');
    $pool=filter_input(INPUT_POST,'Pool_Name');
    $type=filter_input(INPUT_POST,'Nas_Port_Type');
    $expiration=filter_input(INPUT_POST,'Expiration');
    $sim=filter_input(INPUT_POST,'Simultaneous_Use');
    $comment=filter_input(INPUT_POST,'comment');
    $arr=array(
        "successMsg"=>"保存用户 {$username}  {$pool} 成功！！" 
    );
    if ($username && $password && ($pool!==NULL and $pool!==false) && $type && $expiration) {
            require './db/db.php';
            mysqli_begin_transaction($conn);
            $timstramp= strtotime($expiration);
            $exp=date("d M Y H:i:s",$timstramp);
            //$sql="insert into {$tb_check} values ('','$username','Cleartext-Password',':=','$password'),('','$username','Pool-Name',':=','$pool'),('','$username','Expiration',':=','$exp'),('','$username','Simultaneous-Use',':=',1),('','$username','Nas-Port-Type','==','$type')";
            $sql="update {$tb_check} set value='$password' where username='$username' and attribute='Cleartext-Password'";
            $res1= mysqli_query($conn,$sql);
            $sql="update {$tb_check} set value='$pool' where username='$username' and attribute='Pool-Name'";
            $res2=mysqli_query($conn,$sql);
            $sql="update {$tb_check} set value='$type' where username='$username' and attribute='Nas-Port-Type'";
            $res3=mysqli_query($conn,$sql);
            $sql="update {$tb_check} set value='$exp' where username='$username' and attribute='Expiration'";
            $res4=mysqli_query($conn,$sql);
            $sql="update {$tb_check} set value='$sim' where username='$username' and attribute='Simultaneous-Use'";
            $res5=mysqli_query($conn,$sql);
            //$sql="insert into {$tb_user} (`username`,`Cleartext_Password`,`Pool_Name`,`Nas_Port_Type`,`Expiration`) values ('$username','$password','$pool','$type','$expiration')";
            $sql="update {$tb_user} set comment='$comment',Cleartext_Password='$password',Pool_Name='$pool',Expiration='$expiration',Nas_Port_Type='$type',Simultaneous_Use='$sim' where username='$username'";
            $res6=mysqli_query($conn,$sql);
            if ($res1 && $res2 && $res3 && $res4 && $res5 && $res6) {
                mysqli_commit($conn);
                    echo json_encode($arr);
             } else {
                 mysqli_rollback($conn);
                    $arr['errorMsg']="保存用户失败！！ res1={$res1}  res2={$res2} res3={$res3} res4={$res4} res5={$res5},res6={$res6}" . mysqli_error($conn);
                    echo json_encode($arr);
            }
            mysqli_close($conn);
    } else {
             $arr['errorMsg']="提交用户错误！！";
             echo json_encode($arr);
    }     
}
function editnas() {
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"修改NAS成功！！"
        );
    $nasname=filter_input(INPUT_POST,'nasname');
    $secret=filter_input(INPUT_POST,'secret');
    $shortname=filter_input(INPUT_POST,'shortname');
    
    if($nasname && $secret && $shortname) {
        require './db/db.php';
        $sql="update nas set shortname='$shortname',secret='$secret' where nasname='$nasname'";
        $res=mysqli_query($conn,$sql);
        if ($res) {
            unset($arr['errorMsg']);
            echo json_encode($arr);
        } else {
           $arr['errorMsg']='修改NAS失败！！' . mysql_error();
           echo json_encode($arr);
        }
        mysqli_close($conn);
    }   
}

function editmember() {
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"修改会员成功！！"
        );
    $username=filter_input(INPUT_POST,'username');
    $password=filter_input(INPUT_POST,'password');   
    if($username && $password) {
        require './db/db.php';
        $sql="update {$tb_member} set password='$password' where username='$username'";
        $res=mysqli_query($conn,$sql);
        if ($res) {
            unset($arr['errorMsg']);
            echo json_encode($arr);
        } else {
           $arr['errorMsg']='修改会员失败！！' . mysqli_error($conn);
           echo json_encode($arr);
        }
        mysqli_close($conn);
    }   else {
        echo json_encode($arr);
    } 
}

function editmembergroup() {
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"修改组成功！！"
        );
    $groupname=filter_input(INPUT_POST,'groupname');
    $groupdes=filter_input(INPUT_POST,'groupdes'); 
    $groupvalue=filter_input(INPUT_POST,'groupvalue'); 
    if($groupname) {
        require './db/db.php';
        $sql="update {$tb_membergroup} set groupdes='$groupdes',groupvalue='$groupvalue' where groupname='$groupname'";
        $res=mysqli_query($conn,$sql);
        if ($res) {
            unset($arr['errorMsg']);
            echo json_encode($arr);
        } else {
           $arr['errorMsg']='修改组失败！！' . mysqli_error($conn);
           echo json_encode($arr);
        }
        mysqli_close($conn);
    }   else {
        echo json_encode($arr);
    } 
}


function addnas() {
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"添加NAS成功！！"
        );
    $nasname=filter_input(INPUT_POST,'nasname');
    $secret=filter_input(INPUT_POST,'secret');
    $shortname=filter_input(INPUT_POST,'shortname');
    
    if($nasname && $secret && $shortname) {
        require './db/db.php';
        $sql="insert into nas(nasname,shortname,secret) values('$nasname','$shortname','$secret')";
        $res=mysqli_query($conn,$sql);
        if ($res) {
            unset($arr['errorMsg']);
            echo json_encode($arr);
        } else {
           $arr['errorMsg']='添加NAS失败！！' . mysqli_error($conn);
           echo json_encode($arr);
        }
        mysqli_close($conn);
    }
    
    
}

function addmember() {
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"添加会员成功！！"
        );
    $username=filter_input(INPUT_POST,'username');
    $password=filter_input(INPUT_POST,'password');    
    if($username && $password) {
        require './db/db.php';
        $sql="insert into {$tb_member} (username,password,createtime,state) values('$username','$password',NOW(),1)";
        $res=mysqli_query($conn,$sql);
        if ($res) {
            unset($arr['errorMsg']);
            echo json_encode($arr);
        } else {
           $arr['errorMsg']='添加会员失败！！' . $sql . mysqli_error($conn);
           echo json_encode($arr);
        }
        mysqli_close($conn);
    } else {
        echo json_encode($arr);
    }
    
    
}
function addmembergroup() {
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"添加管理组成功！！"
        );
    $groupname=filter_input(INPUT_POST,'groupname');
    $groupdes=filter_input(INPUT_POST,'groupdes');    
    $groupvalue=filter_input(INPUT_POST,'groupvalue');    
    if($groupname) {
        require './db/db.php';
        $sql="insert into {$tb_membergroup} (`groupname`,`groupdes`,`groupvalue`) values('$groupname','$groupdes','$groupvalue')";
        $res=mysqli_query($conn,$sql);
        if ($res) {
            unset($arr['errorMsg']);
            echo json_encode($arr);
        } else {
           $arr['errorMsg']='添加组失败！！' . $sql . mysqli_error($conn);
           echo json_encode($arr);
        }
        mysqli_close($conn);
    } else {
        echo json_encode($arr);
    }
    
    
}


function addarea() {
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"添加地区成功！！"
        );
    $areaid=filter_input(INPUT_POST,'areaid');
    $areaname=filter_input(INPUT_POST,'areaname');
    $qq=filter_input(INPUT_POST,'qq');
    $tel=filter_input(INPUT_POST,'tel');
    $yuancheng=filter_input(INPUT_POST,'yuancheng');
    if($areaid && $areaname && $qq && $tel && $yuancheng) {
        require './db/db.php';
        $sql="insert into {$tb_area} (areaid,areaname,qq,tel,yuancheng) values ('$areaid','$areaname','$qq','$tel','$yuancheng')";
        $res=mysqli_query($conn,$sql);
        if ($res) {
            unset($arr['errorMsg']);
            echo json_encode($arr);
        } else {
           $arr['errorMsg']='添加地区失败！！' . mysqli_error($conn);
           echo json_encode($arr);
        }
        mysqli_close($conn);
    }   else {
        echo json_encode($arr);
    }     
}

function addareacomment(){
    $areaid=filter_input(INPUT_POST,'areaid');
   // $areaname=filter_input(INPUT_POST,'areaname');
    $memo=filter_input(INPUT_POST,'memo');

    if($areaid && $memo) {
        require './db/db.php';
        $sql="insert into {$tb_areacomment} (areaID,memo,updatetime) values ('$areaid','$memo',now())";
        $res=mysqli_query($conn,$sql);
        if ($res) {
            echo '添加成功';
        } else {
            echo '添加失败';
        }
        mysqli_close($conn);
    }   else {
        echo '提交数据错误';
    }     
    
}







function adduser(){
    $sessionusername=isset($_SESSION['username'])?$_SESSION['username']:0;
    
    $username=filter_input(INPUT_POST,'username');
    $password=filter_input(INPUT_POST,'Cleartext_Password');
    $pool=filter_input(INPUT_POST,'Pool_Name');
    $type=filter_input(INPUT_POST,'Nas_Port_Type');
    $expiration=filter_input(INPUT_POST,'Expiration');
    $sim=filter_input(INPUT_POST,'Simultaneous_Use');
    $comment=filter_input(INPUT_POST,'comment');
    $arr=array(
        "errorMsg"=>"提交数据错误！！",
        "successMsg"=>"开通成功！！"
    );
    if ($username && $password && ($pool!==NULL and $pool!==false) && $type && $expiration) {
            require './db/db.php';
            mysqli_begin_transaction($conn);
            $timstramp= strtotime($expiration);
            $exp=date("d M Y H:i:s",$timstramp);
            $sql="insert into {$tb_check} values ('','$username','Cleartext-Password',':=','$password'),('','$username','Pool-Name',':=','$pool'),('','$username','Expiration',':=','$exp'),('','$username','Simultaneous-Use',':=',$sim),('','$username','Nas-Port-Type','==','$type')";
            $res1=mysqli_query($conn,$sql);
            $sql="insert into {$tb_user} (`Simultaneous_Use`,`username`,`Cleartext_Password`,`Pool_Name`,`Nas_Port_Type`,`Expiration`,`sessionusername`,`starttime`,`comment`) values ($sim,'$username','$password','$pool','$type','$expiration','$sessionusername',now(),'$comment')";
            $res3=mysqli_query($conn,$sql);
            if (1==$res1 &&1==$res3) {
                    mysqli_commit($conn);
                    unset($arr['errorMsg']);
                    echo json_encode($arr);
             } else {
                 mysqli_rollback($conn);
                    $arr['errorMsg']='保存数据失败！！' . mysqli_error($conn);
                    echo json_encode($arr);
            }
            mysqli_close($conn);
    } else {
             echo json_encode($arr);
    }    

}

function getanalyze(){
    $page=filter_input(INPUT_POST,'page');
    $rows= filter_input(INPUT_POST,'rows');
    $searchname= filter_input(INPUT_POST,'searchname');
    $searchvalue= filter_input(INPUT_POST,'searchvalue');
    $page?0:$page=1;
    $rows?0:$rows=20;
    $offset=($page*$rows-$rows);
    $sort = isset($_POST['sort']) ? strval($_POST['sort']) : '(pool_name+0)';
    $sort==='pool_name'?$sort='(pool_name+0)':0;
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
    $result=array();
    require './db/db.php';
    
    if ($searchvalue) {          
        $sql="SELECT count(DISTINCT(pool_name)) from {$tb_ippool} where pool_name='$searchvalue'";
        $rs=mysqli_query($conn,$sql);
        $row= mysqli_fetch_row($rs);
        $result['total']=$row[0];
         $sql="select {$tb_ippool}.pool_name as pool_name,"
                . "webarea.areaname as areaname,"
                . "count(*) as all_count,"
                . "count(case when {$tb_ippool}.used=0 then 1 else null end) as unused_count,"
                . "count(case when {$tb_ippool}.used=1 then 1 else null end)  as using_count,"
                . "count(case when {$tb_ippool}.used=2 then 1 else null end) as used_count,"
                . "count(case when {$tb_ippool}.used=3 then 1 else null end) as redialing_count,"
                . "count(case when {$tb_ippool}.belong=1 then 1 else null end) as reserved_count  "
                . "from {$tb_ippool},webarea where {$tb_ippool}.pool_name='$searchvalue' and webarea.areaid={$tb_ippool}.pool_name group by  {$tb_ippool}.pool_name order by {$sort} {$order}";
 
    } else {
        $rs=mysqli_query($conn,"select count(distinct(pool_name)) from  {$tb_ippool} ");
        $row=mysqli_fetch_row($rs);
        $result['total']=$row[0];
         $sql="select {$tb_ippool}.pool_name as pool_name,"
                . "webarea.areaname as areaname,"
                . "count(*) as all_count,"
                . "count(case when {$tb_ippool}.used=0 then 1 else null end) as unused_count,"
                . "count(case when {$tb_ippool}.used=1 then 1 else null end)  as using_count,"
                . "count(case when {$tb_ippool}.used=2 then 1 else null end) as used_count,"
                . "count(case when {$tb_ippool}.used=3 then 1 else null end) as redialing_count,"
                . "count(case when {$tb_ippool}.belong=1 then 1 else null end) as reserved_count  "
                 . "  from {$tb_ippool},webarea   where webarea.areaid={$tb_ippool}.pool_name group by  {$tb_ippool}.pool_name order by {$sort} {$order} limit {$offset},{$rows}";         
        
    }
    $rs=mysqli_query($conn,$sql);
    $items=array();    
    while($row=mysqli_fetch_object($rs)) {        
        array_push($items,$row);
    }
    mysqli_close($conn);
    $result['rows']=$items;
    //echo $sql;
    echo json_encode($result);
    
}

function getuser(){    
    $page=filter_input(INPUT_POST,'page');
    $rows= filter_input(INPUT_POST,'rows');
    $searchname= filter_input(INPUT_POST,'searchname');
    $searchvalue=filter_input(INPUT_POST,'searchvalue');
    $page?0:$page=1;
    $rows?0:$rows=20;
    $offset=($page*$rows-$rows);
    $result=array();
    require './db/db.php';    
    if ($searchname){
        switch($searchname) {
            case 'username':
                $rs=mysqli_query($conn,"select count(*) from {$tb_user} where username like '%$searchvalue%' ");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select *,concat(timestampdiff(hour, now(),Expiration),'小时') as ddate from {$tb_user} where username like '%$searchvalue%' order by Nas_Port_Type desc,(pool_name+0) limit {$offset},{$rows}";       
                break;
            case 'areaid':
                $rs=mysqli_query($conn,"select count(*) from {$tb_user} where pool_name='$searchvalue'  ");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select *,concat(timestampdiff(hour, now(),Expiration),'小时') as ddate from {$tb_user} where pool_name='$searchvalue'  order by (pool_name + 0)  limit {$offset},{$rows}"; 
                break;
            case 'usertype':
                $rs=mysqli_query($conn,"select count(*) from {$tb_user} where Nas_Port_Type='$searchvalue'  ");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select *,concat(timestampdiff(hour, now(),Expiration),'小时') as ddate from {$tb_user} where Nas_Port_Type='$searchvalue' order by id desc  limit {$offset},{$rows}"; 
                break;
            default:break;                
        }        
    } else {
        $rs=mysqli_query($conn,"select count(*) from {$tb_user} order by id desc");
        $row=mysqli_fetch_row($rs);
        $result['total']=$row[0];
        $sql="select *,concat(timestampdiff(hour, now(),Expiration),'小时') as ddate from {$tb_user} order by id desc limit {$offset},{$rows}";  
    }

    $rs=mysqli_query($conn,$sql);
    $items=array();
    while($row=mysqli_fetch_object($rs)) {
       // echo $row->{'Expiration'};
        $row->{'Expiration'}=date('Y-m-d G:i:s',strtotime($row->{'Expiration'}));
        //$row['Expiration']=date('Y-m-d G:i:s',strtotime($row['Expiration']));
        array_push($items,$row);
    }
    $result['rows']=$items;
    echo json_encode($result);
}

function getareacomment(){
    $id=filter_input(INPUT_GET,'id');
    $areaname=filter_input(INPUT_GET,'areaname');
    require './db/db.php';
    $rs=mysqli_query($conn,"select updatetime,memo from {$tb_areacomment}  where areaID='$id' order by id  limit 3");
    echo '<span>' . $areaname . '</span><br/>';
    while($row=mysqli_fetch_row($rs)) {
        echo "{$row[0]} || {$row[1]} <hr/>";
    }
    
echo '<hr/>
    <form id="fmarea" method="post">
    <label>描述:</label>
    <p></p>  <input type="hidden" name="areaid" value="';
    echo $id;
echo '"/>
    <textarea style="width:100%;height:80px;" type="text" name="memo"></textarea>
    <input onclick="fmsubmit();" type="button" value="保存"/>
    <label id="addresult"><label>
    </form>
      ';



}

function getarea($tag){
    $page=filter_input(INPUT_POST,'page');
    $rows= filter_input(INPUT_POST,'rows');
    $searchname= filter_input(INPUT_POST,'searchname');
    $searchvalue= filter_input(INPUT_POST,'searchvalue');
    $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'status,(areaid+0)';
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
    $page?0:$page=1;
    $rows?0:$rows=20;
    $offset=($page*$rows-$rows);
    $result=array();
    require './db/db.php';
    $rs=mysqli_query($conn,"select count(*) from $tb_area");
    $row=mysqli_fetch_row($rs);
    $result['total']=$row[0];
    if ($searchvalue) {   
        $sql="select * from {$tb_area} where areaname like '%$searchvalue%' or areaid='$searchvalue' order by {$sort} {$order}  limit {$offset},{$rows}";       
    } else {
        $sql="select * from {$tb_area} order by {$sort}  {$order}  limit {$offset},{$rows}";      
    }
    if(2===$tag) {
        $sql="select {$tb_area}.areaid as areaid,{$tb_area}.areaname as areaname, "
            . "count(case when {$tb_ippool}.pool_name={$tb_area}.areaid then 1 else null end) as all_count, " 
            . "count(case when {$tb_ippool}.pool_name={$tb_area}.areaid and {$tb_ippool}.used=0 then 1 else null end) as unused_count, "
            . "count(case when {$tb_ippool}.pool_name={$tb_area}.areaid and {$tb_ippool}.used=1 then 1 else null end) as using_count, "
            . "count(case when {$tb_ippool}.pool_name={$tb_area}.areaid and {$tb_ippool}.used=2 then 1 else null end) as used_count,  "
            . "count(case when {$tb_ippool}.pool_name={$tb_area}.areaid and {$tb_ippool}.belong=1 then 1 else null end) as belong_count "
            .  " from {$tb_area},{$tb_ippool} group by {$tb_area}.areaid ";   
            
    }
    
    $rs=mysqli_query($conn,$sql);
    $items=array();
    while($row=mysqli_fetch_object($rs)) {
        array_push($items,$row);
    }
    $result['rows']=$items;
    if(2===$tag) {
        echo json_encode($items);
    } else {
        echo json_encode($result);
    }
}

function getnas() {
    
    $result=array();
    require './db/db.php';    
    $sql="select nas.nasname as nasname,
                 nas.secret as secret,
                 nas.shortname as shortname,
                 nas.downarea as downarea,
                 nas.uptime as uptime,
                 nas.lastupdate as lastupdate,
                 count(*) as online,
                 count(case when (
                                 nas.nasname={$tb_ippool}.nasipaddress
                                 AND NOT FIND_IN_SET({$tb_ippool}.pool_name,nas.downarea) 
                                 AND ({$tb_ippool}.used = 0 
                                       OR ( {$tb_ippool}.used = 2 
                                             AND DATE_ADD({$tb_ippool}.lastupdate,INTERVAL 10 MINUTE) > now()
                                          )
                                      )
                                  )  THEN 1 ELSE  NULL END 
                        ) as unused_count  
                 from nas,{$tb_ippool} where nas.nasname={$tb_ippool}.nasipaddress group by nas.nasname";
    $rs=mysqli_query($conn,$sql) ;
    $items=array();
    while($row=mysqli_fetch_object($rs)) {
        array_push($items,$row);
    }
    echo json_encode($items);
}

function getmembergroup() {
    $result=array();
    require './db/db.php';
    $sql="select * from {$tb_membergroup}";
    $rs=mysqli_query($conn,$sql) ;
    $items=array();
    while($row=mysqli_fetch_object($rs)) {
        array_push($items,$row);
    }
    echo json_encode($items);
}

function getmember() {
     $result=array();
    require './db/db.php';
    $rs=mysqli_query($conn,"select username,password,createtime,state from {$tb_member}") ;
    $items=array();
    while($row=mysqli_fetch_object($rs)) {
        array_push($items,$row);
    }
    echo json_encode($items);
    
}

function getonlineuser() {
    $page=filter_input(INPUT_POST,'page');
    $rows= filter_input(INPUT_POST,'rows');
    $searchname= filter_input(INPUT_POST,'searchname');
    $searchvalue= filter_input(INPUT_POST,'searchvalue');
    $page?0:$page=1;
    $rows?0:$rows=20;
    $offset=($page*$rows-$rows);
    $result=array();
    require './db/db.php';    
    if($searchname) {
        switch($searchname) {
            case 'username':
                $rs=mysqli_query($conn,"select count(*) from radippool where used=1 and username='$searchvalue'");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select * from {$tb_ippool} where used=1 and username='$searchvalue'  limit {$offset},{$rows} ";
                break;
            case 'nasporttype':
                if ($searchvalue==='pppoe') {
                    $rs=mysqli_query($conn,"select count(*) from radippool where used=1 and length(callingstationid)=17");
                    $row=mysqli_fetch_row($rs);
                    $result['total']=$row[0];
                    $sql="select * from {$tb_ippool} where used=1 and length(callingstationid)=17  limit {$offset},{$rows} ";
                } else {
                    $rs=mysqli_query($conn,"select count(*) from radippool where used=1 and length(callingstationid)<17");
                    $row=mysqli_fetch_row($rs);
                    $result['total']=$row[0];
                    $sql="select * from {$tb_ippool} where used=1 and length(callingstationid)<17  limit {$offset},{$rows} ";
                }
                break;
            case 'callingstationid';
                $rs=mysqli_query($conn,"select count(*) from radippool where used=1 and callingstationid='$searchvalue'");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select * from {$tb_ippool} where used=1 and callingstationid='$searchvalue'  limit {$offset},{$rows} ";
                break;
            case 'areaid';
                $rs=mysqli_query($conn,"select count(*) from radippool where used=1 and pool_name='$searchvalue'");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select * from {$tb_ippool} where used=1 and pool_name='$searchvalue'  limit {$offset},{$rows} ";
                break;
            case 'publicipaddress':
                $rs=mysqli_query($conn,"select count(*) from radippool where used=1 and publicipaddress='$searchvalue'");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select * from {$tb_ippool} where used=1 and publicipaddress='$searchvalue'  limit {$offset},{$rows} ";
                break;
            case 'nasipaddress':    
                $rs=mysqli_query($conn,"select count(*) from radippool where used=1 and nasipaddress='$searchvalue'");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select * from {$tb_ippool} where used=1 and nasipaddress='$searchvalue'  limit {$offset},{$rows} ";
                break;
             case 'framedipaddress': 
                $rs=mysqli_query($conn,"select count(*) from radippool where used=1 and framedipaddress='$searchvalue'");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select * from {$tb_ippool} where used=1 and framedipaddress='$searchvalue'  limit {$offset},{$rows} ";
                break;           
            default:
                die("search error!!");                
                break;
        }
    } else {
                $rs=mysqli_query($conn,"select count(*) from radippool where used=1");
                $row=mysqli_fetch_row($rs);
                $result['total']=$row[0];
                $sql="select * from {$tb_ippool} where used=1  limit {$offset},{$rows} ";
        
    }

    $rs=mysqli_query($conn,$sql);
    $items=array();
    while($row=mysqli_fetch_object($rs)) {
        $row->pppoestate==='false'?$row->pppoestate='正常':$row->pppoestate='禁用';
        array_push($items,$row);
    }
    $result['rows']=$items;
    echo json_encode($result);

}

function getlog(){
    $page=filter_input(INPUT_POST,'page');
    $rows= filter_input(INPUT_POST,'rows');
    $searchname= filter_input(INPUT_POST,'searchname');
    $searchvalue=filter_input(INPUT_POST,'searchvalue');
    
    if ($searchname) {
            //$searchname= 'LOG-' . str_replace('-', '', $searchname);
    } else {
        $searchname=date("Y-m-d");
        //$searchname= 'LOG-' . str_replace('-', '', $searchname);
    }
    
    $page?0:$page=1;
    $rows?0:$rows=10;
    $offset=($page*$rows-$rows);
    $result=array();
    require_once './db/db2.php';
    $searchname=trim($searchname);
    $searchvalue=trim($searchvalue);
    if ($searchvalue) {    
        $sql="select count(*) from `{$searchname}` where nasipaddress='$searchvalue' or username like '%$searchvalue%'  or framedipaddress='$searchvalue' or callingstationid='$searchvalue' or publicipaddress='$searchvalue'";
        $rs=mysqli_query($conn,$sql);
        $row=mysqli_fetch_row($rs);
        $result['total']=$row[0];
        $sql="select * from `{$searchname}` where nasipaddress='$searchvalue' or username like '%$searchvalue%'  or framedipaddress='$searchvalue' or callingstationid='$searchvalue' or publicipaddress='$searchvalue' limit {$offset},{$rows}";
 
    } else {
        $sql="select count(*) from `{$searchname}` ";
        $rs=mysqli_query($conn,$sql);
        $row=mysqli_fetch_row($rs);
        $result['total']=$row[0];
        $sql="select * from `{$searchname}` order by radacctid desc limit {$offset},{$rows}";
        
    }
    $rs=mysqli_query($conn,$sql);
    $items=array();
    while($row=mysqli_fetch_object($rs)) {        
        array_push($items,$row);
    }
    $result['rows']=$items;
    echo json_encode($result);
}

function getip(){
    $page=filter_input(INPUT_POST,'page');
    $rows= filter_input(INPUT_POST,'rows');
    $searchname= filter_input(INPUT_POST,'searchname');
    $searchvalue= filter_input(INPUT_POST,'searchvalue');
    $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'inet_aton(framedipaddress)';
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
    $page?0:$page=1;
    $rows?0:$rows=20;
    $offset=($page*$rows-$rows);
    $result=array();
    require './db/db.php';
    $searchname=trim($searchname);
    
    if ($searchname) {  
        switch ($searchname){
        case 'used0':
            $rs=mysqli_query($conn,"select count(*) from radippool where used=0 ");
            $row=mysqli_fetch_row($rs);
            $result['total']=$row[0];
            $sql="select * from {$tb_ippool} where used=0   order by $sort $order  limit {$offset},{$rows}";
            break;
            case 'used1':
            $rs=mysqli_query($conn,"select count(*) from radippool where used=1");
            $row=mysqli_fetch_row($rs);
            $result['total']=$row[0];
            $sql="select * from {$tb_ippool} where used=1   order by $sort $order  limit {$offset},{$rows}";
            break;
        case 'used2':
            $rs=mysqli_query($conn,"select count(*) from radippool where used=2");
            $row=mysqli_fetch_row($rs);
            $result['total']=$row[0];
            $sql="select * from {$tb_ippool} where used=2   order by $sort $order   limit {$offset},{$rows}";
            break;
        case 'belong0':
            $rs=mysqli_query($conn,"select count(*) from radippool where belong=0 ");
            $row=mysqli_fetch_row($rs);
            $result['total']=$row[0];
            $sql="select * from {$tb_ippool} where belong=0   order by $sort $order  limit {$offset},{$rows}";
            break;
        case 'belong1':
            $rs=mysqli_query($conn,"select count(*) from radippool where belong=1 ");
            $row=mysqli_fetch_row($rs);
            $result['total']=$row[0];
            $sql="select * from {$tb_ippool} where belong=1   order by $sort $order  limit {$offset},{$rows}";
            break;
        case 'areaid':
            $rs=mysqli_query($conn,"select count(*) from radippool where pool_name='$searchvalue' ");
            $row=mysqli_fetch_row($rs);
            $result['total']=$row[0];
            $sql="select * from {$tb_ippool} where pool_name='$searchvalue'   order by $sort $order  limit {$offset},{$rows}";
            break;
            
        default:
            break;
          
        }
    } else {        
            $rs=mysqli_query($conn,"select count(*) from radippool ");
            $row=mysqli_fetch_row($rs);
            $result['total']=$row[0];        
            $sql="select * from {$tb_ippool} order by $sort $order limit {$offset},{$rows}";
        
    }
    $rs=mysqli_query($conn,$sql);  
    $items=array();
    while($row=mysqli_fetch_object($rs)) {
        $row->pppoestate==='false'?$row->pppoestate='正常':$row->pppoestate='禁用';
        array_push($items,$row);
    }
    $result['rows']=$items;
    echo json_encode($result);
}

function removeuser(){
    $username= filter_input(INPUT_POST,'idstr');
    $arr=array();
    if  (!$username) {
        $arr['errorMsg']="接收数据错误！！"; 
        echo json_encode($arr);
        exit(0);
    }
    require './db/db.php';
    $res= mysqli_begin_transaction($conn);
    $res1=mysqli_query($conn,"delete from {$tb_check} where username='$username'");
    $res2=mysqli_query($conn,"delete from radreply where username='$username'");
    $res3=mysqli_query($conn,"delete from {$tb_user} where username='$username'");
    if ($res1 && $res2 && $res3) {
        mysqli_commit($conn);
        $arr['success']="删除用户 {$username} 成功";
        echo json_encode($arr);
        exit(0);
    } else {
        mysqli_rollback($conn);
        $arr['errorMsg']='删除失败，数据不完整！！';
        echo json_encode($arr);
        exit(0);
    }
    echo json_encode($arr);
}

function removearea(){
    $idstr= filter_input(INPUT_POST,'idstr');    
    $arr=array();
    if  (!$idstr) {
        $arr['errorMsg']="接收数据错误！！"; 
        echo json_encode($arr);
        exit(0);
    }   
   
    require './db/db.php';
    $sql="delete from {$tb_area} where areaid='$idstr'";
    $res1=mysqli_query($conn,$sql);
    if ($res1) {
        $arr['success']=" 删除地区  $idstr   成功 " ;
        echo json_encode($arr);
        exit(0);
    } else {
        $arr['errorMsg']='删除失败，数据不完整！！';
        echo json_encode($arr);
        exit(0);
    }
    echo json_encode($arr);
}


function removenas(){
    $idstr= filter_input(INPUT_POST,'idstr');    
    $arr=array();
    if  (!$idstr) {
        $arr['errorMsg']="接收NAS数据错误！！"; 
        echo json_encode($arr);
        exit(0);
    }   
   
    require './db/db.php';
    $sql="delete from nas where nasname='$idstr'";
    $res1=mysqli_query($conn,$sql);
    if ($res1) {
        $arr['success']=" 删除NAS  $idstr   成功 " ;
        echo json_encode($arr);
        exit(0);
    } else {
       $arr['errorMsg']='删除失败，数据不完整！！';
        echo json_encode($arr);
        exit(0);
    }
    echo json_encode($arr);
}

function removemember(){
    $idstr= filter_input(INPUT_POST,'idstr');    
    $arr=array();
    if  (!$idstr) {
        $arr['errorMsg']="接收会员数据错误！！"; 
        echo json_encode($arr);
        exit(0);
    }   
   
    require './db/db.php';
    $sql="delete from dbmembers where username='$idstr'";
    $res1=mysqli_query($conn,$sql);
    if ($res1) {
        $arr['success']=" 删除会员  $idstr   成功 " ;
        echo json_encode($arr);
        exit(0);
    } else {
        $arr['errorMsg']='删除失败，数据不完整！！';
        echo json_encode($arr);
        exit(0);
    }
    echo json_encode($arr);
}
function removemembergroup(){
    $idstr= filter_input(INPUT_POST,'idstr');    
    $arr=array();
    if  (!$idstr) {
        $arr['errorMsg']="接收组数据错误！！"; 
        echo json_encode($arr);
        exit(0);
    }   
   
    require './db/db.php';
    $sql="delete from {$tb_membergroup} where groupname='$idstr'";
    $res1=mysqli_query($conn,$sql);
    if ($res1) {
        $arr['success']=" 删除组  $idstr   成功 " ;
        echo json_encode($arr);
        exit(0);
    } else {
        $arr['errorMsg']='删除失败，数据不完整！！';
        echo json_encode($arr);
        exit(0);
    }
    echo json_encode($arr);
}
function disconnect() {
    $nas=filter_input(INPUT_POST,'nas');    
    $username=filter_input(INPUT_POST,'username');
    $ip=filter_input(INPUT_POST,'ip');
    $arr=array();
    if($ip && $nas && $username) {
        $packet="User-Name=$username \r\n  Framed-IP-Address=$ip";
        //echo $packet;
        $cmddisc="echo '$packet'|radclient $nas:3799 disconnect 123456";
        require_once './db/ssh.php';
        if ($ssh_disc) {            
                    $connection = ssh2_connect($ssh_host,$ssh_port);
                    if ( ssh2_auth_password($connection,$ssh_user,$ssh_pass) ){
                    }else{
                        $arr['errorMsg']="连接远程服务器失败";
                        die(json_encode($arr));
                    }                   
                    $stream = ssh2_exec($connection,$cmddisc);
                    stream_set_blocking($stream,true);
                    $res=stream_get_contents($stream);
            
        } else {
            $res=exec($cmddisc);
        }
        //echo $res;
        if (strpos($res,'ACK')) {
            $arr['success']="踢用户 {$username} 成功";
            echo json_encode($arr);
        } else {
            $arr['errorMsg']="踢用户 {$username} 失败";
            echo json_encode($arr);
        }
    }
 
}


function aclfilter($type) {
    $acl=array();
    $username=$_SESSION['username'];
    if ($username) {    
            require './db/db.php';
            $sql="select groupvalue as groupvalue from {$tb_membergroup},{$tb_member} where {$tb_member}.username='{$username}' and {$tb_membergroup}.id={$tb_member}.groupid  limit 1";
            
            $rs=mysqli_query($conn,$sql);
            $acl=mysqli_fetch_row($rs);
            $acl=json_decode($acl[0]);
            mysqli_close($conn);
            foreach($acl as $menu=>$value) {                
                if ($value->checked) {
                    foreach($value->children as $submenu=>$subvalue) {         
                        
                        if ($subvalue->checked) {
                            if ($cmdname[$subvalue->text]===$type) {
                                return true;
                            }
                        }                        
                    }                  
                }  
                
            }
            return false;
            
    } else {
        return false;
    }
    return false;
}


?>
