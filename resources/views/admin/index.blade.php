<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台题库</title>
</head>
<style>
    ul li{
        list-style: none;
        width:100%;
        border: 1px silver solid;
        float: left;
        margin-left: 20px;
        margin-top: 20px;
        min-height: 300px;
    }
</style>
<body>
    <div class="box">
        <ul>
            @foreach ($subjectList as $subject)
                <li>
                    <div>题目1：</div>
                    <div>
                        <p>A：吃的骄傲吃的好吃的骄傲吃的好吃的骄傲吃的好吃的骄傲吃的好吃的骄傲吃的好吃的骄傲吃的好吃的骄傲吃的好</p>
                        <p>B：吃的骄傲</p>
                        <p>C：吃的好</p>
                        <p>D：</p>
                    </div>
                </li>
            @endforeach
            

        </ul>

    </div>

</body>
</html>