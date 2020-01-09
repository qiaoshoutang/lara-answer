<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>成绩单</title>
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
    <link rel="stylesheet" href="css/reportCard.css">

</head>
<style>
    .sharePage{
        width: 100%;
        height: 100%;
        position: fixed;
        z-index: 999;
        background: rgba(86,86,86,1);
        display: none;
    }
    .sharePage img{
        width: 85%;
        position: absolute;
        right: 1%;
        top: .3rem;
    }
    .ChenJiDD{
        width: 100%;
    }
    .ChenJiDD img{
        width: 100%;
    }
</style>
<body>
    <div class="box">
        <div class="sharePage">
            <img src="images/sharebtn.png" alt="">
        </div>
        <div class="ChenJiDD">
            <img src="images/chengjidan.jpg" alt="">
        </div>
        <!--按钮-->
        <div class="BtnCjd">
            <ul class="BtnCjdUl">
                <li class="again">
                    <img src="images/again.png" alt="">
                </li>
                <li>
                    <img src="images/keepimg.png" alt="">
                </li>
                <li>
                    <img src="images/Receiveawards.png" alt="">
                </li>
            </ul>
        </div>


    </div>
</body>
<script src="js/jquery.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</html>
<script>




    /*分享出去的代码*/
    function share() {
        var hiddenProperty = 'hidden' in document ? 'hidden' :  'webkitHidden' in document ? 'webkitHidden' :  'mozHidden' in document ? 'mozHidden' : null;
        var visibilityChangeEvent = hiddenProperty.replace(/hidden/i, 'visibilitychange');
        var onVisibilityChange = function(){
            if (!document[hiddenProperty]) {
                console.log('页面非激活');
                window.location.href="https://www.baidu.com/"
            }else{
                console.log('页面激活');
            }
        };
        document.addEventListener(visibilityChangeEvent, onVisibilityChange);
    }


    $(".again img").click(function () {
        $(".sharePage").show();

        share()
    });
    $(".sharePage").click(function () {
        $(this).hide();
    });

</script>