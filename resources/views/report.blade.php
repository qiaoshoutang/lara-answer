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
    <link rel="stylesheet" href="/css/reportCard.css">

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
            <img src="/images/sharebtn.png" alt="">
        </div>
        <div class="ChenJiDD">
            <img src="/{{$poster}}" alt="">
        </div>
        <!--按钮-->
        <div class="BtnCjd">
            <ul class="BtnCjdUl">
                <li class="again">
                    <img src="/images/again.png" alt="">
                </li>
                <li>
                    <img src="/images/keepimg.png" alt="">
                </li>
                <li>
                    <img src="/images/Receiveawards.png" alt="" onclick='getReward()'>
                </li>
            </ul>
        </div>
        @csrf
    </div>
</body>
<script src="/js/jquery.js"></script>
<script src="/js/layer/layer.js"></script>
</html>
<script>
    var can_answer = {{$can_answer}}; 
    var can_share  = {{$can_share}};

    $(".again img").click(function () {
        if(can_answer){
            window.location.href="/home"
        }else{
            if(can_share){
                $(".sharePage").show();
                share();
            }else{
                layer.msg('您今天的机会已经用完了，明天加油！');
            }
            
        }
        
    });
    $(".sharePage").click(function () {
        $(this).hide();
    });

    function getReward(){
        window.location.href="/reward"
    }

    /*分享出去的代码*/
    function share() {
        var hiddenProperty = 'hidden' in document ? 'hidden' :  'webkitHidden' in document ? 'webkitHidden' :  'mozHidden' in document ? 'mozHidden' : null;
        var visibilityChangeEvent = hiddenProperty.replace(/hidden/i, 'visibilitychange');
        var onVisibilityChange = function(){
            if (!document[hiddenProperty]) {
                console.log('页面非激活');
                var token = $("input[name='_token']").val();
                $.ajax({
                  type:"post",
                  url:"/ajax/share",
                  data:{'_token':token,'share':true},
                  dataType:'json',
                  success:function(rdata){
                    if(rdata.code==1){
                        layer.msg(rdata.info,{time:2000},function(){
                            window.location.href="/report/this"
                        });
                    }else{
                        layer.msg(rdata.info);
                    }
                  }
                });
                return;
                window.location.href="/home"
            }else{
                console.log('页面激活');
            }
        };
        document.addEventListener(visibilityChangeEvent, onVisibilityChange);
    }
</script>