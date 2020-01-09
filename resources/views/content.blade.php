<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登顶大会答题</title>
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
    <link rel="stylesheet" href="/css/answerContent.css">

    <link rel="stylesheet" href="/css/Time.css">
</head>
<style>
    .redbgNew{
        background:#dd2620!important;
        color: white;
    }
    .green{
         background:#3c7f25!important;
         color: white;
    }
</style>
<body>
     <div class="box">
         <!--狮子头-->
         <div class="contentLogo">
             <img src="/images/datishizi.png" alt="">
         </div>
         <!--答题内容-->
         <div class="AnswerContent">
             <div class="textAnswer">
                 <!--倒计时-->
                 <div class="game_center">
                     <div class="game_time">
                         <div class="hold">
                             <div class="pie pie1"></div>
                         </div>
                         <div class="hold">
                             <div class="pie pie2"></div>
                         </div>
                         <div class="bg"> </div>
                         <div class="time"></div>
                     </div>
                 </div>

                 <div class="textAnswerTitle">
                     <p class="numberTopic">第<span>{{$page_id}}</span>/15题</p>
                     <p class="Topic">{{$subjectInfo->title}}</p>
                     <!--4个题目-->
                     <ul class="textAnswerUl">
                         <li onclick="choose(this)" data='A'>
                             A、{{$subjectInfo->option_a}}
                         </li>
                         <li onclick="choose(this)" data='B'>
                             B、{{$subjectInfo->option_b}}
                         </li>
                         <li onclick="choose(this)" data='C'>
                             C、{{$subjectInfo->option_c}}
                         </li>
                         <li onclick="choose(this)" data='D'>
                             D、{{$subjectInfo->option_d}}
                         </li>
                     </ul>
                 </div>

             </div>
         </div>
         <!--logoDna-->
         <div class="logoDna">
             <img src="/images/DNA.png" alt="">
         </div>

    @csrf
     </div>

</body>
</html>
<script src="/js/jquery.js"></script>
<script src="/js/time_js.js"></script>
<script> 
    var page_id = '{{$page_id}}';
    var token = $('input[name="_token"]').val();
    var selected = false;
    var second =15;
    var time_index;
    countDown();
    time_index = setInterval("setTime()",1000);
    function setTime(){
        if(second >0){
            second = parseInt(second)-1;
        }else{
            clearInterval(time_index);
            // answer_check('H',$('.textAnswerUl'));
        }
    }

    function choose(para){
        if(selected == true){
            return false;
        }
        selected = true;

        var answer = $(para).attr('data');
        var obj = $(para).parent('ul');

        answer_check(answer,obj);

    }
    function answer_check(answer,obj){
        $.ajax({
          type:"post",
          url:"/content/check",
          data:{'page_id':page_id,'_token':token,'answer':answer},
          dataType:'json',
          success:function(rdata){
            if(rdata.code==1){  //回答正确
      
                obj.find('li[data="'+rdata.right+'"]').addClass('redbgNew');
                setTimeout(function(){
                    window.location.href = rdata.data;
                },1000);
            }else if(rdata.code==2){  //回答错误
                obj.find('li[data="'+rdata.right+'"]').addClass('redbgNew');
                obj.find('li[data="'+answer+'"]').addClass('green');
                setTimeout(function(){
                    window.location.href = rdata.data;
                },1000);
            }else{
                layer.msg(rdata.info);
                selected = false;
            }
          }
        });
    }
</script>