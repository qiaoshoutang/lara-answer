<?php

namespace App\Http\Middleware;

use Closure;

class WxAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//         var_dump(session('oauth_user'));

        if(config('app.env') == 'local'){
            $userInfo = array('openid'=>'aaaaa','nickname'=>'翘首','headimgurl'=>'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJtxfkusaicfaFaPfspIxyPvA1TeSzHiahAr6eGrmVN5oKH8oB3x65su1sMTtk9MicFLIQiaTdlWOsBWg/132');
            session(['oauth_user' => $userInfo]);
        }
        if (!session('oauth_user')) {
            
            if ($request->has('state') && $request->has('code')) {
                var_dump('aaa');
                $url_base = 'https://api.weixin.qq.com/sns/oauth2/access_token';
                $param = 'appid='.config('app.APPID').'&secret='.config('app.APPSECRET').'&code='.$request->code.'&grant_type=authorization_code';
                $target_url = $url_base.'?'.$param;
                $dataTemp = $this->curl_get($target_url);
                
                $dataTemp = json_decode($dataTemp,true);

                if(isset($dataTemp['errcode'])){
                    echo '微信授权失败1'.$dataTemp['errmsg'];
                    exit;
                }
                $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$dataTemp['access_token'].'&openid='.$dataTemp['openid'].'&lang=zh_CN';
                $userInfo = $this->curl_get($url);
                $userInfo = json_decode($userInfo,true);
                if(isset($userInfo['errcode'])){
                    echo '微信授权失败2'.$data['errmsg'];
                    exit;
                }

                session(['oauth_user' => $userInfo]);
                return redirect($request->s);
            }
            
            $url_base = 'https://open.weixin.qq.com/connect/oauth2/authorize';
            $param = 'appid='.config('app.APPID').'&redirect_uri='.$request->fullUrl().'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            $target_url = $url_base.'?'.$param;
//             dd($target_url);
            return redirect($target_url);
        }
        return $next($request);  
    }
    private function curl_get($url){
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//设置url属性
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);//获取数据
        curl_close($ch);//关闭curl
        return $output;

    }
}
