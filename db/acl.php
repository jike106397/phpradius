<?php
function aclfilter($type) {
    $acl=array();
    $username=$_SESSION['username'];
    if ($username) {    
            require_once './db/db.php';
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