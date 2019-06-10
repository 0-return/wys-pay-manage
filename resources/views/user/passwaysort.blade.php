<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>收款顺序</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('/layuiadmin/layui/css/layui.css')}}" media="all">
    <link rel="stylesheet" href="{{asset('/layuiadmin/style/admin.css')}}" media="all">
    
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">收款顺序</div>
        <div class="layui-card-body" style="padding: 15px;" id="box">
              

        </div>
    </div>
</div>



<script src="{{asset('/layuiadmin/layui/layui.js')}}"></script> 
<script>
    var token = localStorage.getItem("Usertoken");
    var str=location.search;
    var store_id=str.split('?')[1];
    console.log(store_id)
    layui.config({
        base: '../../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index', //主入口模块
        formSelects: 'formSelects'
    }).use(['index','form','table','laydate'], function(){
        var $ = layui.$ 
            ,admin = layui.admin
            ,element = layui.element
            ,form = layui.form
            ,table = layui.table
            ,laydate = layui.laydate;
    // 未登录,跳转登录页面
    var str=''
    $(document).ready(function(){        
        if(token==null){
            window.location.href="{{url('/user/login')}}"; 
        }
        
    })


    $.post("{{url('/api/user/pay_ways_sort')}}",
    {
        token:token,
        store_id:store_id
    },function(res){
        console.log(res);
        var html=''
        if(res.data.ailpay){
            html+='<div class="layui-form" lay-filter="component-form-group">';
                html+='<div style="padding:10px 0;border-bottom:1px solid #efefef">支付宝</div>';
                for(var i=0;i<res.data.ailpay.length;i++){
                    html+='<div class="layui-form-item">';
                        html+='<div class="layui-input-block" style="line-height: 36px;width:300px;display: inline-block;">'+res.data.ailpay[i].ways_desc+'</div>';
                        html+='<a class="layui-btn layui-btn-normal layui-btn-xs down" data="'+res.data.ailpay[i].store_pay_ways_id+'" sort="'+res.data.ailpay[i].sort+'">向下</a>';
                        html+='<a class="layui-btn layui-btn-normal layui-btn-xs up" data="'+res.data.ailpay[i].store_pay_ways_id+'" sort="'+res.data.ailpay[i].sort+'">向上</a>';
                    html+='</div>';
                }                           
            html+'</div>';
             
            $('#box').html('')
            $('#box').append(html) 
        }
        if(res.data.jd){
            html+='<div class="layui-form" lay-filter="component-form-group">';
                html+='<div style="padding:10px 0;border-bottom:1px solid #efefef">京东支付</div>';
                for(var i=0;i<res.data.jd.length;i++){
                    html+='<div class="layui-form-item">';
                        html+='<div class="layui-input-block" style="line-height: 36px;width:300px;display: inline-block;">'+res.data.jd[i].ways_desc+'</div>';
                        html+='<a class="layui-btn layui-btn-normal layui-btn-xs down" data="'+res.data.jd[i].store_pay_ways_id+'" sort="'+res.data.jd[i].sort+'">向下</a>';
                        html+='<a class="layui-btn layui-btn-normal layui-btn-xs up" data="'+res.data.jd[i].store_pay_ways_id+'" sort="'+res.data.jd[i].sort+'">向上</a>';
                    html+='</div>';
                }                           
            html+'</div>';
             
            $('#box').html('')
            $('#box').append(html) 
        }
        if(res.data.unionpay){
            html+='<div class="layui-form" lay-filter="component-form-group">';
                html+='<div style="padding:10px 0;border-bottom:1px solid #efefef">银联</div>';
                for(var i=0;i<res.data.unionpay.length;i++){
                    html+='<div class="layui-form-item">';
                        html+='<div class="layui-input-block" style="line-height: 36px;width:300px;display: inline-block;">'+res.data.unionpay[i].ways_desc+'</div>';
                        html+='<a class="layui-btn layui-btn-normal layui-btn-xs down" data="'+res.data.unionpay[i].store_pay_ways_id+'" sort="'+res.data.unionpay[i].sort+'">向下</a>';
                        html+='<a class="layui-btn layui-btn-normal layui-btn-xs up" data="'+res.data.unionpay[i].store_pay_ways_id+'" sort="'+res.data.unionpay[i].sort+'">向上</a>';
                    html+='</div>';
                }                           
            html+'</div>';
             
            $('#box').html('')
            $('#box').append(html) 
        }
        if(res.data.weixin){
            html+='<div class="layui-form" lay-filter="component-form-group">';
                html+='<div style="padding:10px 0;border-bottom:1px solid #efefef">微信支付</div>';
                for(var i=0;i<res.data.weixin.length;i++){
                    html+='<div class="layui-form-item">';
                        html+='<div class="layui-input-block" style="line-height: 36px;width:300px;display: inline-block;">'+res.data.weixin[i].ways_desc+'</div>';
                        html+='<a class="layui-btn layui-btn-normal layui-btn-xs down" data="'+res.data.weixin[i].store_pay_ways_id+'" sort="'+res.data.weixin[i].sort+'">向下</a>';
                        html+='<a class="layui-btn layui-btn-normal layui-btn-xs up" data="'+res.data.weixin[i].store_pay_ways_id+'" sort="'+res.data.weixin[i].sort+'">向上</a>';
                    html+='</div>';
                }                           
            html+'</div>';
             
            $('#box').html('')
            $('#box').append(html) 
        }


        
        
    },"json");
  
        


    $('#box').on('click','.down', function(){
        var sort = parseInt($(this).attr('sort'))+1
        console.log(sort)
        $.post("{{url('/api/user/pay_ways_sort_edit')}}",
        {
            token:token,
            store_id: store_id,
            store_pay_ways_id: $(this).attr('data'),
            new_sort: sort,

        },function(res){
            console.log(res);
            if(res.status==1){
                layer.msg(res.message, {
                    offset: '15px'
                    ,icon: 1
                    ,time: 2000
                },function(){
                    window.location.reload();
                });
            }else{
                layer.alert(res.message, {icon: 2});
            }

        },"json");

    });
    $('#box').on('click','.up', function(){
        var sort = parseInt($(this).attr('sort'))-1
        console.log(sort)
        if(sort > 0){
            $.post("{{url('/api/user/pay_ways_sort_edit')}}",
            {
                token:token,
                store_id: store_id,
                store_pay_ways_id: $(this).attr('data'),
                new_sort: sort,

            },function(res){
                console.log(res);
                if(res.status==1){
                    layer.msg(res.message, {
                        offset: '15px'
                        ,icon: 1
                        ,time: 2000
                    },function(){
                    window.location.reload();
                  });
                }else{
                    layer.alert(res.message, {icon: 2});
                }

            },"json");
        }
        

    });

});
</script>

</body>
</html>
