var audio = document.getElementById("audio");
document.ontouchend = function() {
    audio.play()
}

//音乐自动播放
$(document).ready(function(){
    setTimeout(function () {
        autoPlayMusic();
        audioAutoPlay();
    },3000)
});
function audioAutoPlay() {
    a=1;
    var audio = document.getElementById('audio');
    audio.play();

    $("#bgmvideo1").click(function () {
        if(a==1){
            audio.pause();
            $(this).css({
                "background":" url('/images/unXlB.png')top center no-repeat",
                "background-size":"100% 100%"
            });
            a=0
        }else {
            audio.play();
            $(this).css({
                "background":" url('/images/XlB.png')top center no-repeat",
                "background-size":"100% 100%"
            });
            a=1
        }
        console.log(a)
    });

    document.addEventListener("WeixinJSBridgeReady", function () {
        audio.play();
    }, false);
}
// 音乐播放
function autoPlayMusic() {
    // 自动播放音乐效果，解决浏览器或者APP自动播放问题
    function musicInBrowserHandler() {
        musicPlay(true);
        document.body.removeEventListener('touchstart', musicInBrowserHandler);
    }
    document.body.addEventListener('touchstart', musicInBrowserHandler);
    // 自动播放音乐效果，解决微信自动播放问题
    function musicInWeixinHandler() {
        musicPlay(true);
        document.addEventListener("WeixinJSBridgeReady", function () {
            musicPlay(true);
        }, false);
        document.removeEventListener('DOMContentLoaded', musicInWeixinHandler);
    }
    document.addEventListener('DOMContentLoaded', musicInWeixinHandler);
}
function musicPlay(isPlay) {
    var media = document.querySelector('#bg-music');
    if (isPlay && media.paused) {
        media.play();
    }
    if (!isPlay && !media.paused) {
        media.pause();
    }
}
