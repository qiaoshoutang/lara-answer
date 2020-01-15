<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 2020/01/03
 * Time: 17:47
 */

/**
 * 公用的方法  返回json数据，进行信息的提示
 * @param $status 状态
 * @param string $message 提示信息
 * @param array $data 返回数据
 */
function showMsg($status,$message = '',$data = array()){
    $result = array(
        'status' => $status,
        'message' =>$message,
        'data' =>$data
    );
    exit(json_encode($result));
}

/**
 * 公用的方法  下载远程图片
 * @param $source 图片的网络地址
 * @param $path   图片的存放文件夹
 * @param $filename   图片的名称
 */
function downImg($source='',$path='',$filename=''){
    if(empty($source)){
        return false;
    }
    if(empty($path)){
        $path = 'avatar/'.date('Ym');
    }
    if(empty($filename)){
        $filename = time().'_'.rand(1000,9999).'.png';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $source);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_TIMEOUT,500);

    if(!file_exists($path)){
        @mkdir($path,0777,true);
    }

    $target = $path.'/'.$filename;
    $outfile = fopen($target,"wb+x");  //保存到本地文件的文件名
    curl_setopt($ch,CURLOPT_FILE,$outfile);
    $rtn = curl_exec($ch);
    fclose($outfile);
    if(curl_errno($ch)){
        echo 'Curl:error: '.curl_errno($ch);
        return false;
    }
    curl_close($ch);
    
    return $target;
}

function is_weixin()
{
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }
    return false;
}

//获取微信access_token
function get_wx_access_token()
{
    if(cache('access_token')){
        return cache('access_token');
    }
    
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.config('app.APPID').'&secret='.config('app.APPSECRET');

    $res = curl_get($url);
    if(empty($res)){
        return false;
    }
    $data = json_decode($res,true);
    cache(['access_token'=>$data['access_token']],$data['expires_in']);
    return $data['access_token'];

}

//获取微信ticker
function get_wx_ticket(){
    
    if(cache('ticket')){
        return cache('ticket');
    }
    $token = get_wx_access_token();
    if(empty($token)){
        return 'token 错误';
    }
    $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token.'&type=jsapi';
    $res = curl_get($url);
    if(empty($res)){
        return false;
    }
    $data = json_decode($res,true);
    cache(['ticket'=>$data['ticket']],$data['expires_in']);
    return $data['ticket'];
}

//获取微信内签名
function get_wx_signature(){
    $data['noncestr'] = getRandomStr(16);
    $data['jsapi_ticket'] = get_wx_ticket();
    $data['timestamp'] = time();
    $data['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    
    if(empty($data['jsapi_ticket'])||empty($data['noncestr'])){
        return false;
    }
    $string = 'jsapi_ticket='.$data['jsapi_ticket'].'&noncestr='.$data['noncestr'].'&timestamp='.$data['timestamp'].'&url='.$data['url'];
    
    $data['signature'] = sha1($string);
    
    return $data;
}

function curl_get($url){
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL, $url);//设置url属性
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);//获取数据
    curl_close($ch);//关闭curl
    return $output;
    
}

/**
 * 获得随机字符串
 * @param $len             需要的长度
 * @return string       返回随机字符串
 */
function getRandomStr($len){
    $chars = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
        "3", "4", "5", "6", "7", "8", "9"
    );
    
    $charsLen = count($chars) - 1;
    shuffle($chars);                            //打乱数组顺序
    $str = '';
    for($i=0; $i<$len; $i++){
        $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
    }
    return $str;
}

