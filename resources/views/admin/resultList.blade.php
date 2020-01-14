<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>成绩列表</title>
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
        margin:10px 10px;
        text-align: left;
        width: 10%;
        
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
        padding-top:20px;
    }
    .boxul:nth-child(2n+0){
        background: #cccccc;
    }
    .modify{
        height: 30px;
        background:#00FF00 ;
        display: inline-block;
        text-align: center;
        line-height: 30px;
        color: white;
        border-radius: 4px;
        padding:2px 5px;
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
            <li>昵称</li>
            <li>头像</li>
            <li>最好成绩</li>
            <li>微信</li>
            <li>R网账号</li>
            <li>R网uid</li>
            <li>操作</li>
        </ul>
            @foreach ($userList as $user)
            <ul class="boxul">
                <li>{{$user->id}}</li>
                <li>{{$user->nickname}}</li>
                <li>@if(!empty($user->avatar)) <img src="/{{$user->avatar}}" style="width:100px"> @endif</li>
                <li>{{$user->best*10}}</li>
                <li>{{htmlspecialchars_decode($user->wechat)}}</li>
                <li>{{htmlspecialchars_decode($user->r_account)}}</li>
                <li>{{$user->r_uid}}</li>
                <li>
                    <span class="modify" onclick='chance(this)' data-id='{{$user->id}}'>再次机会</span>
                    <span class="delete" onclick='del(this)' data-id='{{$user->id}}'>删除</span>
                </li>
            </ul>
            @endforeach
            <div style='clear:both'></div>
    </div>
    {{$userList->links()}}
    @csrf
    <div style='text-align: center;margin:100px 0 20px'>
        <button id ='back' style='padding:10px 30px;font-size:30px;margin:0 50px'>
            返回首页
        </button>
    </div>
</body>
<script src="/js/jquery.js"></script>
<script src="/js/layer/layer.js"></script>
<script>
function chance(para){

    var id = $(para).attr('data-id');
    var token = $('input').val();
    $.ajax({
      type:"post",
      url:"/admin/user/chance",
      data:{'id':id,'_token':token},
      dataType:'json',
      success:function(rdata){

        if(rdata.code==1){
            layer.msg(rdata.info);
        }else{
            layer.msg(rdata.info);
        }
      }
    });
}

function del(para){

    var id = $(para).attr('data-id');
    var token = $('input').val();
    var obj = $(para).parents('ul.boxul');
    $.ajax({
      type:"post",
      url:"/admin/user/del",
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
$('#back').click(function(){
     window.location.href = '/admin/home';
});
</script>
</html>