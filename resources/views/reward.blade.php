<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>领取奖励</title>
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
    <link rel="stylesheet" href="css/rewardPage.css">
</head>
<body>
    <div class="box">
        <div class="dnaLogo">
            <img src="images/DNA.png" alt="">
        </div>
        <div class="DdDh">
            <img src="images/datishizi.png" alt="">
        </div>
        <!--输入微信号、R网账号、R网UID-->
        <form action="">
            <div class="inputBox">
                <div class="WxH">
                    <input type="text" placeholder="填写微信号" name="wechat" value='{{$userInfo->wechat}}'>
                </div>
                <div class="Name">
                    <input type="text" placeholder="R网账号" name="r_account" value='{{$userInfo->r_account}}'>
                </div>
                <div class="RId">
                    <input type="text" placeholder="R网UID" name="r_uid" value='@if($userInfo->r_uid) $userInfo->r_uid; @endif'>
                </div>
                <div class="sbmitBtn">
                    <img src="images/sbmitBtn.png" alt="" id="sbmitBtn">
                    <p>*R网注册地址：www.rightbtc.pro</p>
                    <p>*如填写内容有误，可直接修改后再提交</p>
                    <p>*奖励将在活动结束后7个工作日内发放完毕</p>
                    <p>*从首页【最好成绩-领取奖励】可进入本界面</p>
                </div>
            </div>
            @csrf
        </form>
    </div>
</body>
<script src="js/jquery.js"></script>
<script src="js/layui/layui.js"></script>
</html>

<script>

    layui.use('layer', function(){  //layer弹框
        var layer = layui.layer;
    });
    $("#sbmitBtn").click(function () {
        var wechat=$("input[name='wechat']").val();
        var r_account=$("input[name='r_account']").val();
        var r_uid=$("input[name='r_uid']").val();
        if(wechat==''||wechat=='null'){
          layer.msg("微信号不能为空");
          return false
        }
        if(r_account==''||r_account=='null'){
            layer.msg("R网账号不能为空");
            return false
        }
        if(r_uid==''||r_uid=='null'){
            layer.msg("R网UID不能为空");
            return false
        }
        if(isNaN(r_uid)){
            layer.msg("R网UID只能为数字");
            return false
        }

        $.ajax({
          type:"post",
          url:"/reward",
          data:$("form").serialize(),
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
    })
</script>
