
<style type="text/css">
*{font-size:12px;border:0;margin:0;padding:0;}
body{font-family:'宋体'; margin:0 auto;min-width:980px;}
ul{display:block;margin:0;padding:0;list-style:none;}
li{display:block;margin:0;padding:0;list-style: none;}
img{border:0;}

/*left.html*/
.leftmenu{width:150px;padding-bottom: 9999px;margin-bottom: -9999px; overflow:hidden;}
.leftmenu dd{background-color:#FFFFFF;line-height:30px;font-size:14px;border-right:solid 1px #b7d5df;}
.leftmenu dd span{margin:10px 8px 0 12px;}
.leftmenu dd .menuson{display:none;}
.leftmenu dd:first-child .menuson{display:block;}
.menuson {line-height:30px; font-weight:normal; }
.menuson li{cursor:pointer;}
.menuson li.active{position:relative;background-color: #E9F1FF;backline-height:30px; color:#000000;}
.menuson li cite{display:block; float:left; margin-left:32px; background:url(./img/list.gif) no-repeat; width:16px; height:16px; margin-top:7px;}
.menuson li a{ display:block; *display:inline; *padding-top:5px;}
.menuson li.active a{color:#000000;font-weight:900;}

.title{margin: 1px;background-color: #E0ECFF;cursor:pointer;border: 1px solid #95B8E7;vertical-align: middle;line-height:22px;padding:2px;
	-moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius:3px;
	}

.title img{vertical-align: middle;}

</style>
<dl class="leftmenu">

<?php
/*
0 1  不可读  可读
0 2  不可写  可写
0 4  不可更改权限 可更改权限
*/
session_start();
$acl=array();
$username=$_SESSION['username'];
/*
$nas=array("active"=>7,"name"=>"NAS管理");
$area=array("active"=>7,"name"=>"地区管理");
$ip=array("active"=>7,"name"=>"IP管理");
$acl['全局配置']=array('active'=>7,'nas'=>$nas,'area'=>$area,'ip'=>$ip);
$member=array("active"=>7,"name"=>"会员管理");
$membergroup=array("active"=>7,"name"=>"组管理");
$acl['会员管理']=array('active'=>7,'member'=>$member,'membergroup'=>$membergroup);


$user=array("active"=>7,"name"=>"用户管理");
$onlineuser=array("active"=>7,"name"=>"在线用户");
$acl['用户管理']=array('active'=>7,'user'=>$user,'onlineuser'=>$onlineuser);

$analyze=array("active"=>7,"name"=>"线路统计");
$log=array("active"=>7,"name"=>"上网日志");
$acl['系统状态']=array('active'=>7,'analyze'=>$analyze,'log'=>$log);
*/
if ($username) {	
		require_once '../db/db.php';
		$sql="select groupvalue as groupvalue from {$tb_membergroup},{$tb_member} where {$tb_member}.username='{$username}' and {$tb_membergroup}.id={$tb_member}.groupid  limit 1";
		
		$rs=mysqli_query($conn,$sql);
		$acl=mysqli_fetch_row($rs);
		$acl=json_decode($acl[0]);
		//var_dump($acl);
		//echo '<hr />';
		
		foreach($acl as $menu=>$value) {
			//var_dump($value);
			echo '<hr />';
			$menu++;
			
			if ($value->checked) {
				
				echo "<dd> <div class=\"title\"><span><img src=\"./img/{$menu}.png\" /></span>{$value->text}  </div>";
			    echo "<ul class=\"menuson\">";

				foreach($value->children as $submenu=>$subvalue) {
					
					
					if ($subvalue->checked) {
						echo "<li onclick=\"changemenu('{$cmdname[$subvalue->text]}');\"><cite></cite><a>{$subvalue->text}</a><i></i></li>";
					}
					
				}
				
				
				echo "</ul></dd>";
			}
			
			
		}
		
}

/*
var_dump($acl);


$acl["全局设置"]
$menu=array();
$menu=$acl["全局设置"];
$menu["active"]=7;
$menu["nas"]["active"]=7;
$menu["nas"]["name"]="NAS管理";
$menu["active"]=7;
$menu["nas"]["active"]=7;
$menu["nas"]["name"]="NAS管理";



'{"全局设置":[{"active":"7",
					"nas":["active":"7","name":"NAS管理"],
					"area":["active":"7","name":"地区管理"],
					"ip":["active":"7","name":"IP管理"]""
				   ],
		"会员管理":["active":"7",
					"member":["active":"7","name":"会员管理"],
					"membergroup":["active":"7","name":"组管理"]					
				   ],
		"用户管理":["active":"7",
					"user":["active":"7","name":"用户管理"],
					"onlineuser":["active":"7","name":"在线用户"]
					],
		"系统状态":["active":"7",
					"analyze":["active":"7","name":"线路统计"],
					"log":["active":"7","name":"上网日志"]
					]
*/

?>
<!--
	<dd>
	    <div class="title"><span><img src="./img/1.png" /></span>全局设置  </div>
	    <ul class="menuson">
	    	<li onclick="changemenu('nas');"><cite></cite><a>NAS管理</a><i></i></li>
	    	<li onclick="changemenu('area')"><cite></cite><a>地区管理</a><i></i></li>
	    	<li onclick="changemenu('ip')"><cite></cite><a>IP管理</a><i></i></li>
	    </ul>

	</dd>
	<dd>
	    <div class="title"><span><img src="./img/3.png" /></span>会员管理</div>
	    <ul class="menuson">
	    	<li onclick="changemenu('member')"><cite></cite><a>会员管理</a><i></i></li>	    	    	
	    	<li onclick="changemenu('membergroup')"><cite></cite><a>组管理</a><i></i></li>	  
	    </ul>
	</dd>
	<dd>
	    <div class="title"><span><img src="./img/2.png" /></span>用户管理</div>
	    <ul class="menuson">
	    	<li onclick="changemenu('user')"><cite></cite><a>用户管理</a><i></i></li>
	    	<li onclick="changemenu('onlineuser')"><cite></cite><a>在线用户</a><i></i></li>	    	
	    </ul>
	</dd>
	<dd>
	    <div class="title"><span><img src="./img/3.png" /></span>系统状态</div>
	    <ul class="menuson">
	    	<li onclick="changemenu('analyze')"><cite></cite><a>线路统计</a><i></i></li>
	    	<li onclick="changemenu('ip')"><cite></cite><a>上网日志</a><i></i></li>	    	
	    </ul>
	</dd>

</dl>

-->
<script type="text/javascript">
$(function(){	
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active");
		$(this).addClass("active");
	});

	//菜单展开
		
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
	//默认项	
	if(!$('#usermanager').next('ul').is(':visible')) $('#usermanager').click();
	

})	
</script>


