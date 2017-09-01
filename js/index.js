$('#menu').accordion({   
    onSelect:function(title, index)
    {

        //alert(index);
        switch(index) {
            case 0:
                $('#datagrid').load('user.html',function(){
                    init_table('user');

                });           
                
                break;
            case 1:
                $('#datagrid').load('onlineuser.html',function(){
                    init_table('onlineuser');    
                });
                
                break;

            case 2:
                $('#datagrid').load('area.html',function(){
                init_table('area');    
                });
                
                break;
            case 3:
                $('#datagrid').load('member.html',function(){
                    init_table('member');    
                });
                
                break;
            case 4:
                $('#datagrid').load('nas.html',function(){
                    init_table('nas');    
                });
                
                break;

            case 5:
                $('#datagrid').load('ip.html',function(){
                    init_table('ip');    
                });
                
                break;

            case 6:
                $('#datagrid').load('analyze.html',function(){
                    init_table('analyze');    
                });
                
                break;

            case 7:
                $('#datagrid').load('log.html',function(){
                    init_table('log');    
                });                
                break;

            default:
                break;
        }

         
    }
});           


 







          
            
            function init_table(type) {
                $.parser.parse(('#datagrid')); 
                //alert(type);
                switch(type) {
                    case 'user':
                            $('#ss-user').searchbox({
                                    width:250,
                                    menu:'#mm-user',
                                    searcher:function(value,name){                    
                                        dosearch('user',name,value);
                                    }               
                                });
                            $('#tt-main').datagrid({
                                striped:true,
                                singleSelect:true,
                                url:'./cmd.php?cmd=get&type=user',
                                toolbar:'#tb-user',
                                pageSize:20,
                                pagenumber:1,
                                pagination:true,
                                pagePosition:'both',
                                rownumbers:true,
                                columns:[[
                                        {title:'帐号名',field:'username',width:100},
                                        {title:'密码',field:'Cleartext_Password',width:100},
                                        {title:'共享数',field:'Simultaneous_Use',width:50},
                                        {title:'地区',field:'Pool_Name',width:30},
                                        {title:'到期时间',field:'Expiration',width:150},
                                        {title:'帐号类型',field:'Nas_Port_Type',width:50},
                                        {title:'会员名',field:'sessionusername',width:100},
                                        {title:'开通时间',field:'starttime',width:150},
                                        {title:'产品类型',field:'pptp_type',width:100},
                                        {title:'剩余时间',field:'ddate',width:50},
                                        {title:'备注',field:'comment',width:100}
                                ]],
                                onDblClickRow:function(rowIndex,rowData){                                    
                                    edit('user');
                                }
                                
                            });
                            $('#cc1').combogrid({
                                    panelWidth:450,
                                    url:'./cmd.php?cmd=get&type=area2',
                                    idField:'areaid',
                                    textField:'areaname',
                                    multiple:true,
                                    columns: [[
                                            {field:'ck',checkbox:true},
                                            {field:'areaid',title:'ID',width:25},
                                            {field:'areaname',title:'地区',width:100},
                                            {field:'all_count',title:'线路',width:30},
                                            {field:'unused_count',title:'可用',width:30},
                                            {field:'using_count',title:'在用',width:30},
                                            {field:'used_count',title:'用过',width:30},
                                            {field:'belong_count',title:'保留',width:30}
                                    ]],
                            });
                            $('#cc2').combobox({
                                    url:'type.json',
                                    valueField:'id',
                                    textField:'name',
                            });

                            break;
                    case 'area':
                            $('#tt-main').datagrid({
                                striped:true,
                                singleSelect:true,
                                url:'./cmd.php?cmd=get&type=area',
                                pageSize:20,
                                pagenumber:1,                
                                pagination:true,
                                pagePosition:'both',
                                rownumbers:true,
                                fitcolumns:true,
                                toolbar:'#tb-area',
                                columns:[[
                                        {title:'ID',field:'areaid',width:30,sortable:'true'},
                                        {title:'地区名',field:'areaname',width:80,sortable:'true'},
                                        {title:'qq号',field:'qq',width:80,sortable:'true'},
                                        {title:'电话',field:'tel',width:100,sortable:'true'},
                                        {title:'单价',field:'permoney',width:30},
                                        {title:'总价',field:'money',width:40},
                                        {title:'状态',field:'status',width:50,sortable:'true'},
                                        {title:'开始时间',field:'starttime',width:100},
                                        {title:'结束时间',field:'endtime',width:100},
                                        {title:'远程',field:'yuancheng',width:300}                                               
                                ]],
                                onDblClickRow:function(index,row){                        
                                        edit('area');                   
                                },
                                onClickRow: function(index,row){
                                    $('#comment-area').load('./cmd.php?cmd=get&type=areacomment&id=' +row.areaid + '&areaname=' + row.areaname);
                                }

                            });
                            $('#ss-area').searchbox({
                                    width:300,
                                    menu:'#mm-area',
                                    searcher:function(value,name){
                                        dosearch('area',name,value);
                                    }               
                                });
                            break;
                    case 'member':
                        $('#tt-main').datagrid({
                            striped:true,
                            singleSelect:true,
                            url:'./cmd.php?cmd=get&type=member',
                            pageSize:20,
                            pagenumber:1,                
                            pagination:true,
                            pagePosition:'both',
                            rownumbers:true,
                            fitcolumns:true,
                            toolbar:'#tb-member',
                            columns:[[
                                    {title:'会员名',field:'username',width:100},
                                    {title:'密码',field:'password',width:100},
                                    {title:'开通时间',field:'createtime',width:200},
                                    {title:'状态',field:'state',width:100}
                                                           
                            ]],
                            onDblClickRow:function(rowIndex,rowData){
                                edit('member');
                            }
                        });



                            $('#ss-member').searchbox({
                                searcher:function(value,name){
                                    dosearch('member');
                                }               
                            }); 
                        break;
                    case 'nas':
                       $('#tt-main').datagrid({
                            striped:true,
                            singleSelect:true,
                            url:'./cmd.php?cmd=get&type=nas',
                            pageSize:20,
                            pagenumber:1,                
                            pagination:true,
                            pagePosition:'both',
                            rownumbers:true,
                            fitcolumns:true,
                            toolbar:'#tb-nas',
                            columns:[[
                                    {title:'ROS地址（IP地址)',field:'nasname',width:100},
                                    {title:'名字',field:'shortname',width:100},
                                    {title:'密钥',field:'secret',width:100},
                                    {title:'启动时长',field:'uptime',width:100},
                                    {title:'最后通信',field:'lastupdate',width:150},
                                    {title:'在线',field:'online',width:50},
                                    {title:'剩余可分配',field:'unused_count',width:50},
                                    {title:'故障地区',field:'downarea',width:800}
                                                           
                            ]],
                            onDblClickRow:function(rowIndex,rowData){
                                edit('nas');
                            }
                        });            
                        break;
                    case 'onlineuser':
                            $('#tt-main').datagrid({
                                striped:true,
                                singleSelect:true,
                                url:'./cmd.php?cmd=get&type=onlineuser',
                                pageSize:20,
                                pagenumber:1,                
                                pagination:true,
                                pagePosition:'both',
                                rownumbers:true,
                                fitcolumns:true,
                                toolbar:'#tb-search-onlineuser',
                                onClickRow:function(rowIndex,row){
                                    $('#disconnect').text('踢掉帐号 ' +row.username);
                                },
                                columns:[[
                                        {title:'帐号名',field:'username',width:100},
                                        {title:'客户IP',field:'framedipaddress',width:80},
                                //        {title:'地区',field:'pool_name',width:30},
                                        {title:'登录ROS',field:'nasipaddress',width:100},
                                        {title:'客户地址',field:'callingstationid',width:130},
                               //         {title:'公网IP',field:'publicipaddress',width:130},
                                        {title:'上线时间',field:'start_time',width:150},
                                        //{title:'存活确认时间',field:'active_time',width:150},
                                        {title:'过期时间',field:'expiry_time',width:150},
                               //         {title:'pub帐号',field:'pppoeuser',width:50},
                               //         {title:'pub密码',field:'pppoepass',width:50},
                               //         {title:'pub状态',field:'pppoestate',width:50}
                                        /*,
                                        {title:'操作',field:'opt',width:100,
                                            formatter:function(value,rec){
                                                var btn = '<input type="button" value="踢在线" onclick="disconnect(\'' + rec.nasipaddress + '\',\'' + rec.username +'\',\'' +rec.framedipaddress + '\');"';
                                                return btn;                                
                                            }
                                        }
                                        */
                                        
                                ]]               
                                
                            });

                           $('#ss-onlineuser').searchbox({
                                width:250,
                                menu:'#mm-onlineuser',
                                searcher:function(value,name){
                                    dosearch('onlineuser',name,value);
                                }               
                            });
                            break;
                    case 'ip':
                           $('#tt-main').datagrid({
                                striped:true,
                                singleSelect:true,
                                url:'./cmd.php?cmd=get&type=ip',
                                pageSize:20,
                                pagenumber:1,                
                                pagination:true,
                                pagePosition:'both',
                                rownumbers:true,
                                fitcolumns:true,
                                toolbar:'#tb-search-ip',
/*
                                columns:[[
                                        {title:'IP状态',field:'used',width:50},
                                        {title:'IP',field:'framedipaddress',width:80},
                                        {title:'地区',field:'pool_name',width:40},
                                        {title:'公网IP',field:'publicipaddress',width:120},
                                        {title:'最后使用时间',field:'lastuse',width:150},
                                        {title:'最后更新',field:'lastupdate',width:150,sortable:'true'},
                                        {title:'公网帐号',field:'pppoeuser',width:100},
                                        {title:'公网密码',field:'pppoepass',width:100},
                                        {title:'公网接口状态',field:'pppoestate',width:100}
                                ]]               
*/
				columns:[[
                                        {title:'IP状态',field:'used',width:50},
                                        {title:'IP',field:'framedipaddress',width:80},
                                        {title:'最后使用时间',field:'lastuse',width:150}
				]]
                                
                            });
                           $('#ss-ip').searchbox({
                                    menu:'#mm-ip',
                                    searcher:function(value,name){
                                        
                                        dosearch('ip',name,value);
                                    }               
                                });
                           break;
                    case 'log':
                            
                            $('#tt-main').datagrid({
                                striped:true,
                                singleSelect:true,
                                url:'./cmd.php?cmd=get&type=log',
                                pageSize:10,
                                pagenumber:1,                
                                pagination:true,
                                pagePosition:'both',
                                rownumbers:true,
                                fitcolumns:true,
                                toolbar:'#tb-search-log',
                                columns:[[
                                        {title:'帐号名',field:'username',width:100},
                                        {title:'客户地址',field:'callingstationid',width:130},
                                        {title:'客户IP',field:'framedipaddress',width:100},                        
                                        {title:'公网IP',field:'publicipaddress',width:120},
                                        {title:'上线时间',field:'acctstarttime',width:150},
                                        {title:'下线时间',field:'acctstoptime',width:150},
                                        {title:'登录ROS',field:'nasipaddress',width:120}
                                        
                                ]]               
                                
                            });
                            $('#ss-log').searchbox({
                                   searcher:function(value,name){
                                       var q=$('#ss-log').val();
                                       var r=$('#ss-log-date').val();
                                       dosearch('log',r,q);
                                   } 
                                });
                            break;
                    case 'analyze':
                             $('#tt-main').datagrid({
                                    striped:true,
                                    singleSelect:true,
                                    url:'./cmd.php?cmd=get&type=analyze',
                                    pageSize:20,
                                    pagenumber:1,                
                                    pagination:true,
                                    pagePosition:'both',
                                    rownumbers:true,
                                    fitcolumns:true,
                                    toolbar:'#tb-search-analyze',
                                    columns:[[
                                            {title:'地区ID',field:'pool_name',width:50,sortable:'true'},
                                            {title:'地区名',field:'areaname',width:120},
                                            {title:'线路数',field:'all_count',width:50,sortable:'true'},                        
                                            {title:'在线',field:'using_count',width:50,sortable:'true'},
                                            {title:'可用',field:'unused_count',width:50,sortable:'true'},
                                            {title:'已用',field:'used_count',width:50,sortable:'true'},
                                            {title:'保留线路',field:'reserved_count',width:50,sortable:'true'}                        
                                    ]]               
                                    
                                });
                                $('#ss-analyze').searchbox({
                                           searcher:function(value,name){
                                               var q=$('#ss-analyze').val();
                                               dosearch('analyze','areaid',q);
                                           } 
                                       });
                             break;
                    default:
                            init_table('user');
                             break;

                }
                $.parser.parse(('#datagrid')); 
                            


            }
            

           

            
            

            
            
            
            
            
            


            
            
            
           
            

            /*
             $('#tt-user').datagrid('enableFilter');
              $('#tt-area').datagrid('enableFilter');
               $('#tt-nas').datagrid('enableFilter');
                $('#tt-member').datagrid('enableFilter');
            */     
            

 

            function dosearch(module,name,value){        
                    $('#tt-'+module).datagrid('load',{
                        searchname:name,
                        searchvalue:value
                    });   
            }
            
            function add(p){
                if(p) {
                        $(".idstr").removeAttr('readonly');
                        $('#fm-' + p).form('clear');
                        $('#ok-' + p).unbind('click');
                        $('#ok-' + p).click(function() {save('add',p);});
                        $('#ok-' + p).text('确定');
                        $('#dlg-' + p).dialog({
                                title:'添加'                     
                        }).dialog('open');       
                    }                         
            }
            function edit(p){
                if(p) {
                    var row  = $('#tt-main').datagrid('getSelected');
                    if(row) {
                        $(".idstr").attr('readonly','true');
                        $('#dlg-' +p).dialog('open').dialog('setTitle','修改'); 
                        $('#ok-' + p).unbind('click');
                        $('#ok-' + p).click(function(){save('edit',p);});
                        $('#ok-' + p).text('保存');
                        $('#fm-' +p).form('load',row);  
                    }
                }
            }
            function save(cmd,type) {  
                var url='cmd.php?cmd=' + cmd + '&type=' + type;
                $('#fm-'+type).form('submit',{
                    url:url,
                    onSubmit:function(p){
                        p.Pool_Name=$('#cc1').combobox('getValues');
                        //var ms=$('#cc1').combobox('getValues');
                        //ms.join(',');
                        //alert(ms);
                        //$('#cc1').combobox('setValue','2');
                        //alert(ms);
                        //alert($('#cc1').combobox('getValue'));
                        return $(this).form('validate');
                    },
                    success:function(result){                                       
                        var result = eval('('+result+')');
			if (result.errorMsg){
				$.messager.show({
					title: '错误',
					msg: result.errorMsg
				});
			} else {
                            	$.messager.show({
					title: '成功',
					msg: result.successMsg
				});
				$('#dlg-'+type).dialog('close');		// close the dialog
				$('#tt-main').datagrid('reload');	// reload the user data
			}
                    }                    
                });                
            }
            
            
            function rem(type) {                
                 var row  = $('#tt-main').datagrid('getSelected');
                 if (!row) {
                     $.messager.show({
                        title:'错误',
                        msg:'未选择删除数据'                        
                     });                     
                 }
                switch(type){
                    case 'user':
                        var cfm='您确定删除这个帐号么？'+row.username;
                        var idstr=row.username;
                        break;
                    case 'area':
                        var cfm='您确定删除这个地区么？'+row.areaid;
                        var idstr=row.areaid;
                        break;
                    case 'nas':
                        var cfm='您确定删除这个NAS么？'+row.nasname;
                        var idstr=row.nasname;
                        break;
                    case 'member':
                        var cfm='您确定删除这个会员么？'+row.username;
                        var idstr=row.username;
                        break;
                    default:
                        break;
                        
                }
                if (row){
                        $.messager.confirm('Confirm',cfm,function(r){
                                if (r){
                                        $.post('cmd.php?cmd=remove&type='+type,{idstr:idstr},function(result){
                                                result=JSON.parse(result);
                                                if (result.success){
                                                        $('#tt-main').datagrid('reload');	// reload the user data
                                                        $.messager.show({	// show error message
                                                                title: '删除成功',
                                                                msg: result.success
                                                        });
                                                } else {
                                                        $.messager.show({	// show error message
                                                                title: '错误',
                                                                msg: result.errorMsg
                                                        });
                                                }
                                        });
                                }
                        });
                }
                
            }
            
        function fmsubmit() {
                  $("#fmarea").form("submit",{
                        url:"./cmd.php?cmd=add&type=areacomment",
                        success:function(data) {
                                $('#addresult').text(data);
                                var row=$('#tt-area').datagrid("getSelected");
                                $('#comment-area').load('./cmd.php?cmd=get&type=areacomment&id=' +row.areaid + '&areaname=' + row.areaname);
                        }
                    });
        }
        
        function disconnect() {
            var row  = $('#tt-onlineuser').datagrid('getSelected');
            if(row) {
                    $.post('cmd.php?cmd=disconnect&type=user',{nas:row.nasipaddress,username:row.username,ip:row.framedipaddress},function(result){
                                                        result=JSON.parse(result);
                                                        if (result.success){
                                                             $('#tt-onlineuser').datagrid('reload');
                                                                $.messager.show({	// show error message
                                                                        title: '踢下线成功',
                                                                        msg: result.success
                                                                });
                                                        } else {
                                                                $.messager.show({	// show error message
                                                                        title: '错误',
                                                                        msg: result.errorMsg
                                                                });
                                                        }
                                                });
            } else {
                                                                $.messager.show({	// show error message
                                                                        title: '错误',
                                                                        msg: '未选择在线用户'
                                                                });
            }
        }
        
        
  
            
