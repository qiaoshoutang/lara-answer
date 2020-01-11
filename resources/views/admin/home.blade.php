<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台首页</title>
</head>

<body>

    <div style='text-align: center;margin:100px 0 20px'>
        <button id ='subject' style='padding:10px 30px;font-size:30px;margin:0 50px'>
            题库列表
        </button>
        <button id ='result' style='padding:10px 30px;font-size:30px;margin:0 50px'>
            成绩列表
        </button>
    </div>

</body>
<script src="/js/jquery.js"></script>
<script>
$('#subject').click(function(){
     window.location.href = '/admin/subject';
});
$('#result').click(function(){
     window.location.href = '/admin/result';
});
</script>
</html>