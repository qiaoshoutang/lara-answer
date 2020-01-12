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
