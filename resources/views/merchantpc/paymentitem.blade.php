<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加缴费项目</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('/layuiadmin/layui/css/layui.css')}}" media="all">
    <link rel="stylesheet" href="{{asset('/layuiadmin/style/admin.css')}}" media="all">
    <link rel="stylesheet" href="{{asset('/layuiadmin/layui/css/formSelects-v4.css')}}" media="all">
    <style>
        .icon-close{display: none;}
    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">缴费项目</div>
        <div class="layui-card-body" style="padding: 15px;">
            <div class="layui-form" lay-filter="component-form-group">                
                <div class="layui-form-item school">
                    <label class="layui-form-label">选择学校</label>
                    <div class="layui-input-block">
                        <select name="schooltype" id="schooltype" lay-filter="schooltype">
                            
                        </select>
                    </div>
                </div>
                <div class="layui-form-item grade">
                    <label class="layui-form-label">选择年级</label>
                    <div class="layui-input-block">
                        <select name="grade" id="grade" lay-filter="grade">
                            
                        </select>
                    </div>
                </div>
                <div class="layui-form-item class">
                    <label class="layui-form-label">选择班级</label>
                    <div class="layui-input-block">
                        <select name="class" id="class" xm-select="class">
                            
                        </select>
                    </div>
                </div>
                <div class="layui-form-item class">
                    <label class="layui-form-label">排除缴费</label>
                    <div class="layui-input-block" style="min-height: 40px;" id="BOX">
                        
                    </div>
                </div>                
            </div>


        </div>
    </div>
    <div class="layui-card">
      
      <div class="layui-card-body layui-row layui-col-space10">
        <div class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">截止时间</label>                          
                <div class="layui-inline">
                  <div class="layui-input-inline">
                    <input type="text" class="layui-input start-item test-item" placeholder="截止时间" lay-key="23">
                  </div>
                </div>               
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">项目名称</label>                          
                <div class="layui-inline">
                  <div class="layui-input-inline">
                    <input type="text" class="layui-input batch_name" placeholder="请输入项目名称" lay-key="23">
                  </div>
                  <div class="layui-form-mid layui-word-aux">例如:2018学杂费</div>
                </div>               
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">缴费模板</label>
                <div class="layui-input-block">
                    <select name="template" id="template" lay-filter="template">
                        
                    </select>
                </div>
            </div>
            <table class="layui-table">
              <colgroup>
                <col width="150">
                <col width="150">
                <col width="200">
                <col width="200">
              </colgroup>
              <thead>
                <tr>
                  <th>缴费名称</th>
                  <th>缴费金额</th>
                  <th>数量</th>
                  <th>是否必交(Y或N)</th>
                </tr> 
              </thead>
              <tbody>            
                
              </tbody>
            </table>


            <div class="layui-form-item">
              <div class="layui-inline">
                <label class="layui-form-label" style="font-size: 20px;">总金额:</label>
                <div class="layui-form-mid layui-word-aux" style="font-size: 20px;"><span class="amount">0.00</span>&nbsp;&nbsp;&nbsp;必缴<span class="mustpay">0.00</span>&nbsp;&nbsp;&nbsp;非必缴<span class="nomustpay">0.00</span></div>
              </div>
            </div>

            <div class="layui-form-item layui-layout-admin">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn submit">确定提交</button>
                        <!--<button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
                    </div>
                </div>
            </div>  
        </div>        
      </div>
    </div>
    
    
</div>

<input type="hidden" class="store_id" value="">
<input type="hidden" class="gradeid" value="">
<input type="hidden" class="gradename" value="">
<input type="hidden" class="classid" value="">
<input type="hidden" class="classname" value="">
<input type="hidden" class="templateid" value="">
<input type="hidden" class="student_code" value="">

<script src="{{asset('/layuiadmin/layui/layui.js')}}"></script> 
<!-- <script src="{{asset('/layuiadmin/modules/formSelects.js')}}"></script> -->
<script>
    var token = localStorage.getItem("token");
    

    layui.config({
        base: '../../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index', //主入口模块
        formSelects: 'formSelects'
    }).use(['index', 'form','upload','formSelects','laydate'], function(){
        var $ = layui.$
            ,admin = layui.admin
            ,element = layui.element
            ,layer = layui.layer
            ,laydate = layui.laydate
            ,form = layui.form
            ,formSelects = layui.formSelects;
        formSelects.render('class');
        formSelects.btns('class', []);
        var arr=[];
        form.on('select(grade)', function(data){            
            category = data.value;  
            categoryName = data.elem[data.elem.selectedIndex].text; 
            $('.gradeid').val(category);
            $('.gradename').val(categoryName);
            arr=[];
            $('#BOX').html('');
            formSelects.config('class', {
                beforeSuccess: function(id, url, searchVal, result){
                    //我要把数据外层的code, msg, data去掉
                    result = result.data;
                    console.log(result);
                    for(var i=0;i<result.length;i++){

                        var data ={"value":result[i].stu_class_no,"name":result[i].stu_class_name}
                        arr.push(data);
                        // console.log(arr);
                    }
                    console.log(arr);
                    //然后返回数据
                    return arr;
                }
            }).data('class', 'server', {
                // url:"{{url('/api/school/teacher/class/lst?token=')}}"+token
                url:"{{url('/api/school/teacher/class/lst?token=')}}"+token+"&store_id="+$('.store_id').val()+"&stu_grades_no="+$('.gradeid').val()
            });

            formSelects.on('class', function(id, vals, val, isAdd, isDisabled){
                //id:           点击select的id
                //vals:         当前select已选中的值
                //val:          当前select点击的值
                //isAdd:        当前操作选中or取消
                //isDisabled:   当前选项是否是disabled
                 console.log(isAdd);
                //如果return false, 那么将取消本次操作
                // return false;   
                // console.log(val.value);
                $('.classid').val(val.value);
                $('.classname').val(val.name);
                if(isAdd==true){

                    $.ajax({
                        url : "{{url('/api/school/teacher/stu/lst')}}",
                        data : {token:token,store_id:$('.store_id').val(),stu_grades_no:$('.gradeid').val(),stu_class_no:$('.classid').val(),l:1000},
                        type : 'post',
                        success : function(data) {
                            console.log(data);
                            var optionStr = "";
                            var arr=[];
                            if(data.data==''){

                            }else{
                                    optionStr += '<div class="s_box" grade_id="'+$('.gradeid').val()+'" class_id="'+$('.classid').val()+'">';
                                    optionStr += '<header><span class="grade_name">'+$('.gradename').val()+'</span class="class_name">('+$('.classname').val()+')</header>';
                                    optionStr += '<div id="student_list">';
                                for(var i=0;i<data.data.length;i++){
                                    
                                    optionStr += '<input class="per" type="checkbox" name="student" student_no="'+data.data[i].student_no+'"  title="'+data.data[i].student_name+'" lay-filter="student" value="'+data.data[i].student_no+'">';

                                    arr.push(data.data[i].student_no);  //学生编号放进数组                          
                                    // $('.student_code').val(arr.join()); //编号用逗号隔开
                                }    
                                optionStr += '</div>';
                                optionStr += '</div>';
                                // $("#student_list").html('');
                                $("#BOX").append(optionStr);
                                form.render('checkbox');
                            }
                        },
                        error : function(data) {
                            layer.msg(data.message, {
                                offset: '15px'
                                ,icon: 2
                                ,time: 3000
                            });
                        }
                    });

                    
                }else{

                    $('#BOX .s_box').each(function(index,item){  

                        if(val.value==$(item).attr('class_id')){
                            
                            $(this).remove();
                        }
                    })
                    
                }
            });
                 
        });


        getBoards();
       
        function getBoards(){ 
            // 选择学校
            $.ajax({
                url : "{{url('/api/school/teacher/lst')}}",
                data : {token:token},
                type : 'post',
                success : function(data) {
                    // console.log(data);
                    var optionStr = "";
                        for(var i=0;i<data.data.length;i++){
                            optionStr += "<option value='" + data.data[i].store_id + "'>"
                                + data.data[i].school_name + "</option>";
                        }    
                        $("#schooltype").append('<option value="">选择学校</option>'+optionStr);
                        layui.form.render('select');
                },
                error : function(data) {
                    layer.msg(data.message, {
                        offset: '15px'
                        ,icon: 2
                        ,time: 3000
                    });
                }
            });
            
            
            // 选择缴费模板
            $.ajax({
                url : "{{url('/api/school/teacher/template/lst')}}",
                data : {token:token},
                type : 'post',
                success : function(data) {
                    // console.log(data);
                    var optionStr = "";
                        for(var i=0;i<data.data.length;i++){
                            optionStr += "<option value='" + data.data[i].stu_order_type_no + "'>"
                                + data.data[i].charge_name + "</option>";
                        }    
                        $("#template").append('<option value="">选择缴费模板</option>'+optionStr);
                        layui.form.render('select');
                },
                error : function(data) {
                    layer.msg(data.message, {
                        offset: '15px'
                        ,icon: 2
                        ,time: 3000
                    });
                }
            });
            
            // 选择班级
            // $.ajax({
            //     url : "{{url('/api/school/teacher/class/lst')}}",
            //     data : {token:token,store_id: $('.store_id').val(),stu_grades_no:$('.gradeid').val()},
            //     type : 'post',
            //     success : function(data) {
            //         // console.log(data);
            //         var optionStr = "";
            //             for(var i=0;i<data.data.length;i++){
            //                 optionStr += "<option value='" + data.data[i].stu_class_no + "'>"
            //                     + data.data[i].stu_class_name + "</option>";
            //             }    
            //             $("#class").html('');
            //             $("#class").formSelects.data('<option value="">选择班级</option>'+optionStr);
            //             layui.form.render('select');
            //     },
            //     error : function(data) {
            //         layer.msg(data.message, {
            //             offset: '15px'
            //             ,icon: 2
            //             ,time: 3000
            //         });
            //     }
            // });
            
        }

        form.on('select(schooltype)', function(data){            
            category = data.value;  
            categoryName = data.elem[data.elem.selectedIndex].text; 
            $('.store_id').val(category);    
            // 选择年级
            $.ajax({
                url : "{{url('/api/school/teacher/grade/lst')}}",
                data : {token:token,store_id:category},
                type : 'post',
                success : function(data) {
                    // console.log(data);
                    var optionStr = "";
                        for(var i=0;i<data.data.length;i++){
                            optionStr += "<option value='" + data.data[i].stu_grades_no + "'>"
                                + data.data[i].stu_grades_name + "</option>";
                        }    
                        $("#grade").html('');
                        $("#grade").append('<option value="">选择年级</option>'+optionStr);
                        layui.form.render('select');
                },
                error : function(data) {
                    layer.msg(data.message, {
                        offset: '15px'
                        ,icon: 2
                        ,time: 3000
                    });
                }
            });      
        });
        

        form.on('select(class)', function(data){            
            category = data.value;  
            categoryName = data.elem[data.elem.selectedIndex].text; 
            $('.classid').val(category); 

                  
        });
        form.on('select(template)', function(data){            
            category = data.value;  
            categoryName = data.elem[data.elem.selectedIndex].text; 
            $('.templateid').val(category); 

            $.ajax({
                url : "{{url('/api/school/teacher/template/lst')}}",
                data : {token:token},
                type : 'post',
                success : function(data) {
                    console.log(data);
                    var optionStr = "";
                    for(var i=0;i<data.data.length;i++){

                        if(category==data.data[i].stu_order_type_no){
                            var res=data.data[i].charge_item;
                            // var res=JSON.parse(str);
                            console.log(res);
                            var sum=0;
                            var sum2=0;
                            var str="";
                            for(var j=0;j<res.length;j++){
                                
                                str+='<tr>';
                                  str+='<td>'+res[j].item_name+'</td>';
                                  str+='<td>'+res[j].item_price+'</td>';
                                  str+='<td>'+res[j].item_number+'</td>';
                                  str+='<td>'+res[j].item_mandatory+'</td>';
                                str+='</tr>';

                                
                                if(res[j].item_mandatory=='Y'){
                                    sum=sum+parseFloat(res[j].item_price);
                                }else{
                                    sum2=sum2+parseFloat(res[j].item_price);
                                }
                                // console.log(sum+sum2);
                                $('.amount').html((sum+sum2).toFixed(2));
                                $('.mustpay').html(sum.toFixed(2));
                                $('.nomustpay').html(sum2.toFixed(2));

                            }
                            
                        }
                    } 
                    $('tbody').html('');
                    $('tbody').append(str);   
                        
                },
                error : function(data) {
                    layer.msg(data.message, {
                        offset: '15px'
                        ,icon: 2
                        ,time: 3000
                    });
                }
            });      
        });
        


        
        form.on('checkbox(student)', function(data){
            var arrs=[];//定义空数组
            $("input:checkbox[name='student']:checked").each(function() { // 遍历name=standard选中的多选框的值
                var standards ='';
                standards = $(this).val();          
                arrs.push(standards);
                // console.log(arrs);
                
            });
            $('.student_code').val(arrs.join());

        });
        // $('#student_list').on("click",".s_box #student_list input",function(){
        //     console.log('000');
        //     $("input:checkbox[name='student']:checked").each(function() { // 遍历name=standard选中的多选框的值
        //         var standards ='';
        //         standards = $(this).val();          
        //         arrs.push(standards);
        //         console.log(arrs);
                
        //     });
        // })
        
        



        
        
        $('.submit').on('click', function(){

            // var stu_class_no=$('.classid').val();
            // var remove_student_no=$('.student_code').val();

            // var data ={"stu_class_no":stu_class_no,"remove_student_no":remove_student_no}
            // arrsum.push(data);
            // var tableJson=JSON.stringify(arrsum);//转化成json格式
            // console.log(tableJson);

            var sum=[];
            // 遍历班级
            $('#BOX .s_box').each(function(index,item){                 
              
                var stu_class_no = $(item).attr('class_id'); //获取班级
                var data={"stu_class_no":stu_class_no,"remove_student_no":""} //构造需要的json              
                var peoArr=[];
                // 遍历班级下的人
                $(item).find(".per").each(function(ind,ite){
                    //判断是否选中
                    if($(ite).is(":checked")){
                        var remove_student_no = $(ite).val();
                        peoArr.push(remove_student_no);//存放学生学号 

                    } 

                    var arrstr=peoArr.join(',');//以,号分割,转换字符串
                    
                    data.remove_student_no=arrstr;//给JSON 赋值
                    
                });
                sum.push(data);//存放选中的数据

            })
            
            // console.log(sum);
            var tableJson=JSON.stringify(sum);//转化成json格式
            console.log(tableJson);


            $.post("{{url('/api/school/teacher/payitem/add')}}",
            {
                token:token,
                store_id:$('.store_id').val(),
                stu_grades_no:$('.gradeid').val(), 
                // stu_class_no:$('.classid').val(),
                // remove_student_no:$('.student_code').val(),
                class_and_rmstu:tableJson,
                stu_order_type_no:$('.templateid').val(),
                gmt_end:$('.start-item').val(),
                batch_name:$('.batch_name').val()


            },function(res){
                console.log(res);
                if(res.status==1){
                    layer.msg(res.message, {
                        offset: '15px'
                        ,icon: 1
                        ,time: 3000
                    });
                }else{
                    layer.msg(res.message, {
                        offset: '15px'
                        ,icon: 2
                        ,time: 3000
                    });
                }
            },"json");

        });


        // 获取时间
        var nowdate = new Date();
        // 本月
        var year=nowdate.getFullYear();
        var mounth=nowdate.getMonth()+1;
        var day=nowdate.getDate();
        var hour = nowdate.getHours();       
        var min = nowdate.getMinutes();     
        var sec = nowdate.getSeconds();
        if(mounth.toString().length<2 && day.toString().length<2){
            var nwedata = year+'-0'+mounth+'-0'+day+' '+hour+':'+min+':'+sec;
        }
        else if(mounth.toString().length<2){
            var nwedata = year+'-0'+mounth+'-'+day+' '+hour+':'+min+':'+sec;
        }
        else if(day.toString().length<2){
            var nwedata = year+'-'+mounth+'-0'+day+' '+hour+':'+min+':'+sec;
        }
        else{
            var nwedata = year+'-'+mounth+'-'+day+' '+hour+':'+min+':'+sec;
        }
        // $('.start-item').val(nwedata);
        nowdate.setMonth(nowdate.getMonth()-1);


        

        laydate.render({
            elem: '.start-item'
            ,type: 'datetime'
            ,done: function(value){
              // console.log(nwedata);
                var oDate1=new Date(nwedata);    
                var oDate2 = new Date(value);
                if(oDate1.getTime() > oDate2.getTime()){

                    layer.msg("截止时间不能低于当前时间", {
                        offset: '15px'
                        ,icon: 2
                        ,time: 3000
                    });

                }
            }
        });

    });
</script>
</body>
</html>
