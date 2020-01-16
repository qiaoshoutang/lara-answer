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
    <link rel="stylesheet" href="/css/index.css?22">

</head>
<style>

</style>
<body>
    <div class="box">
        <!--规则页-->
        <div class="rulepage">
            <div class="closebtn">
                <img src="images/dacha.png" alt="" >
            </div>
            <div class="ruleAndMxTitle">
                <div class="MxBox" >
                    <img src="images/RuleDown.png" alt="" class="MxBoxDown">
                    <img src="images/RuleUp.png" alt="" style="display: none" class="MxBoxUp">
                </div>
                <div class="ruleBox">
                    <img src="images/MxDown.png" alt=""style="display: none" class="ruleBoxDown">
                    <img src="images/MxUp.png" alt="" class="ruleBoxUp">
                </div>

            </div>
            <img src="images/rulepage.png?41" alt="" class="rulepageImg">
            <img src="images/MxPage.png" alt="" class="MxPageImg" style="display: none">
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
            <p>新年答题，一起瓜分百万元界DNA</p>
        </div>
        <!--答题规则-->
        <div class="AnswerRule">
            <img src="images/rule.png?55" alt="">
        </div>
        <!--开始答题-->
        <div class="BeiginBtn">
            <img src="images/btnBeigin.png" alt="" onclick='start()'>
        </div>
    </div>
     @csrf
</body>
<script src="js/jquery.js"></script>
<script src="js/layer/layer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
</html>
<script>
    $(".MxBoxUp").click(function () {
        $(".MxBoxUp").hide();
        $(".ruleBoxUp").show();
        $(".ruleBoxDown").hide();
        $(".rulepageImg").show();
        $(".MxPageImg").hide();
        $(".MxBoxDown").show()
    })
    $(".ruleBoxUp").click(function () {
        $(".MxBoxUp").show();
        $(".ruleBoxUp").hide();
        $(".ruleBoxDown").show();
        $(this).hide();
        $(".rulepageImg").hide();
        $(".MxPageImg").show();
        $(".MxBoxDown").hide()
    })
</script>
<script>

    wx.config({
      debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
      appId: 'wxdebea819f65bfb54', // 必填，公众号的唯一标识
      timestamp: "{{$signaturn['timestamp']}}", // 必填，生成签名的时间戳
      nonceStr: "{{$signaturn['noncestr']}}", // 必填，生成签名的随机串
      signature: "{{$signaturn['signature']}}",// 必填，签名
      jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'] // 必填，需要使用的JS接口列表
    });
    wx.ready(function (){
        wx.onMenuShareTimeline({
          title: '新年答题瓜分百万元界DNA', // 分享标题
          link: 'http://hd.lpchain.net/home', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: 'http://hd.lpchain.net/images/share.jpg', // 分享图标
          success: function () {
          // 用户点击了分享后执行的回调函数
            var token = $("input[name='_token']").val();
            $.ajax({
              type:"post",
              url:"/ajax/share",
              data:{'_token':token,'share':true},
              dataType:'json',
              success:function(rdata){
              }
            });
          }
        });
        wx.onMenuShareAppMessage({
          title: '新年答题瓜分百万元界DNA', // 分享标题
          desc: '参与元界DNA新春登顶大会，答题赢取DNA奖励', // 分享描述
          link: 'http://hd.lpchain.net/home', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: 'http://hd.lpchain.net/images/share.jpg', // 分享图标
          type: 'link', // 分享类型,music、video或link，不填默认为link
          dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
          success: function () {
            // 用户点击了分享后执行的回调函数
            var token = $("input[name='_token']").val();
            $.ajax({
              type:"post",
              url:"/ajax/share",
              data:{'_token':token,'share':true},
              dataType:'json',
              success:function(rdata){
              }
            });
          }
        });
    });

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

    /*分享出去的代码*/
    function share() {
        var hiddenProperty = 'hidden' in document ? 'hidden':'webkitHidden' in document ? 'webkitHidden':'mozHidden' in document ? 'mozHidden':null;
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
                            window.location.href="/home"
                        });
                    }else{
                        layer.msg(rdata.info);
                    }
                  }
                });
            }
        };
        document.addEventListener(visibilityChangeEvent, onVisibilityChange);
    }
</script>
