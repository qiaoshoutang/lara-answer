<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登顶大会</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <script>
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if(clientWidth>=640){
                        docEl.style.fontSize = '100px';
                    }else{
                        docEl.style.fontSize = 100 * (clientWidth / 640) + 'px';
                    }
                };
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
    <link rel="stylesheet" href="/css/index.css">

</head>
<body>
    <div class="box">
        <!--规则页-->
        <div class="rulepage">
            <div class="closebtn">
                <img src="images/dacha.png" alt="" >
            </div>
            <img src="images/rulepage.png" alt="" class="rulepageImg">
        </div>
        <!--成绩单-->
        <div class="reportCard">
            <div class="closebtnCard">
                <img src="images/dacha.png" alt="" >
            </div>
            <img src="images/chengjidan.jpg" alt="" class="reportCardImg">

        </div>

        <!--答题规则与最好成绩-->
        <div class="rightbtnBox">
            <div class="datibtn">
                <img src="images/datibtn.png" alt="">
            </div>
            <div class="chengji">
                <img src="images/chengji.png" alt="">
            </div>
            
        </div>
        <!--dna图标-->
        <div class="dnaLogo">
            <img src="images/DNA.png" alt="">
        </div>
        <!--狮子logo-->
        <div class="logoCenter">
            <img src="images/logoCenter.png" alt="">
            <p>答题测试你的区块链投资段位</p>
        </div>
        <!--答题规则-->
        <div class="AnswerRule">
            <img src="images/rule.png" alt="">
        </div>
        <!--开始答题-->
        <div class="BeiginBtn">
            <img src="images/btnBeigin.png" alt="" onclick='start()'>
        </div>
    </div>
</body>
<script src="js/jquery.js"></script>
<script src="js/layer/layer.js"></script>
</html>
<script>
    var error = {{count($errors)}};

    if(error){
        var str="{{$errors}}";
        str = str.slice(8,-8);
        layer.msg(str);
    }

    $(".closebtn img").click(function () {
        $(".rulepage").hide();
    });
    $(".closebtnCard img").click(function () {
        $(".reportCard").hide()
    });
    $(".datibtn img").click(function () {
        $(".rulepage").show()
    });
    $(".chengji img").click(function () {
        window.location.href = '/report/best';
    });

    function start(){
         window.location.href = '/content/1';
    }

</script>