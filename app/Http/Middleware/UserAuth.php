<?php

namespace App\Http\Middleware;

use Closure;

class UserAuth
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
//         dd(session('user_info'),'gg33g');
        if(session('user_info')){
            return $next($request);
        }else{
//             $param = $request->getRequestUri(); //每次跳转参数会被解开一层，所以用三层编码
            $wx_login_url = '/wx/login';  //微信登录
            
            return redirect()->guest($wx_login_url);
        }
        
    }
}
