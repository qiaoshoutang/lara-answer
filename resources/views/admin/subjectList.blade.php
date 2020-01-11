<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台题库</title>
</head>
<style>
    *{
        padding: 0;
        margin: 0;
    }
    ul{
        width: 100%;
    }
    ul li{
        list-style: none;
    }
    .boxul{
        width: 100%;
        float: left;
    }
    .boxul li{
        float: left;
        margin-left: 20px;
        text-align: left;
        width: 10%;
        margin-top: 30px;
        min-height: 20px;
        padding-bottom: 20px;
    }
    .boxul li:nth-child(1){
        width: 5%;
        text-align: center;
    }
    .boxul li:nth-child(2){
        width: 20%;
        
    }
    .boxul li:last-child{
        width: 10%;
         }
    .boxul:nth-child(1){
        background: #01AAED;
        color: white;
    }
    .boxul:nth-child(2n+0){
        background: #cccccc;
    }
    .modify{
        width: 50px;
        height: 30px;
        background:#00FF00 ;
        display: inline-block;
        text-align: center;
        line-height: 30px;
        color: white;
        border-radius: 4px;
    }
    .delete{
        width: 50px;
        height: 30px;
        background: red;
        display: inline-block;
        text-align: center;
        line-height: 30px;
        color: white;
        border-radius: 4px;
        margin-left: 10px;
    }
    .pagination{
        text-align: center;
    }
    .pagination li{
        display: inline-block;
        font-size: 24px;
    }
    .pagination li a{
        text-decoration: none;
    }
</style>
<body>
    <div class="box">
        <ul class="boxul">
            <li>编号</li>
            <li>题目</li>
            <li>选项A</li>
            <li>选项B</li>
            <li>选项C</li>
            <li>选项D</li>
            <li>答案</li>
            <li>操作</li>
        </ul>
            @foreach ($subjectList as $subject)
            <ul class="boxul">
                <li>{{$subject->id}}</li>
                <li>{{$subject->title}}</li>
                <li>{{$subject->option_a}}</li>
                <li>{{$subject->option_b}}</li>
                <li>{{$subject->option_c}}</li>
                <li>{{$subject->option_d}}</li>
                <li>{{$subject->right}}</li>
                <li>
                    <span class="modify" onclick='edit(this)' data-id='{{$subject->id}}'>修改</span>
                    <span class="delete" onclick='del(this)' data-id='{{$subject->id}}'>删除</span>
                </li>
            </ul>
            @endforeach
            <div style='clear:both'></div>

    </div>
    {{$subjectList->links()}}
    @csrf

    <div style='text-align: center;margin:10px 0 20px'>
        <button id ='btn_add' style='padding:10px 30px;font-size:30px;'>
            添加题目
        </button>
        <button id ='back' style='padding:10px 30px;font-size:30px;'>
            返回首页
        </button>
    </div>

</body>
<script src="/js/jquery.js"></script>
<script src="/js/layer/layer.js"></script>
<script>
function edit(para){

    var url = "/admin/edit/"+$(para).attr('data-id');

    window.location.href = url;
}

function del(para){

    var id = $(para).attr('data-id');
    var token = $('input').val();
    var obj = $(para).parents('ul.boxul');
    $.ajax({
      type:"post",
      url:"/admin/del",
      data:{'id':id,'_token':token},
      dataType:'json',
      success:function(rdata){

        if(rdata.code==1){
            layer.msg(rdata.info,{time:2000},function(){
                obj.remove();
            });
        }else{
            layer.msg(rdata.info);
        }
      }
    });
}
$('#btn_add').click(function(){
     window.location.href = '/admin/content';
});
$('#back').click(function(){
     window.location.href = '/admin/home';
});
</script>
</html>