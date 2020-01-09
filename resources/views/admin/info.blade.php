<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>运营后台</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    *{
        padding: 0;
        margin: 0;
    }
    .box{
        width: 100%;
        font-size: 25px;
        text-align: center;
    }
    .formBox{
        width: 100%;
        margin-top: 30px;

    }
    .FormName{

    }
    #apply_table{
        width: 100%;
    }
    .formBox input{
        width: 500px;
        height: 50px;
        outline: none;
        font-size: 25px;
    }
    .formBox select{
        width: 100px;
        height: 30px;
        font-size: 23px;
    }
    button{
        /*width: 100px;*/
        height: 40px;
        font-size: 25px;
        background: #01AAED;
        outline: none;
        margin-top: 20px;
        color: white;
        padding:0 10px;
    }
    input{
        padding:0 5px;
    }
</style>
<body>
<!--题目。答案。四个选项。正确答案-->
<div class="box">
    <form class="template-form" id='apply_table'>
    @csrf
        <div class="formBox">
            <span class="FormName" >题 目:</span>
            <input type="text" placeholder="" name="title" value="{{$info->title}}">
        </div>
        <div class="formBox">
            <span class="FormName">选项A:</span>
            <input type="text" placeholder="" name="option_a" value="{{$info->option_a}}">
        </div>
        <div class="formBox">
            <span class="FormName">选项B:</span>
            <input type="text" placeholder="" name="option_b" value="{{$info->option_b}}">
        </div>
        <div class="formBox">
            <span class="FormName">选项C:</span>
            <input type="text" placeholder="" name="option_c" value="{{$info->option_c}}">
        </div>
        <div class="formBox">
            <span class="FormName">选项D:</span>
            <input type="text" placeholder="" name="option_d" value="{{$info->option_d}}">
        </div>
        <div class="formBox">
            <span class="FormName" style="position: relative;">正确答案</span>
            <select name="right">
                <option value="A" @if ($info->right == 'A') selected @endif>A</option>
                <option value="B" @if ($info->right == 'B') selected @endif>B</option>
                <option value="C" @if ($info->right == 'C') selected @endif>C</option>
                <option value="D" @if ($info->right == 'D') selected @endif>D</option>
            </select>
        </div>
        <input type="hidden" name="id" value="{{$info->id}}">
        <button id="btn_submit" type="button"> 
            提交
        </button>
        <button id="btn_back" type="button"> 
            返回题库
        </button>

    </form>

</div>
</body>
<script src="/js/jquery.js"></script>
<script src="/js/layer/layer.js"></script>
<script>

$('#btn_submit').click(function(){

    $.ajax({
      type:"post",
      url:"/admin/edit",
      data:$("form").serialize(),
      dataType:'json',
      success:function(rdata){

        if(rdata.code==1){
            layer.msg(rdata.info,{time:2000},function(){
                location.reload();
            });
        }else{
            layer.msg(rdata.info);
        }
      }
    });

});

$('#btn_back').click(function(){
     window.location.href = '/admin/home';
});

</script>
</html>