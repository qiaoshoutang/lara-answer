<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
//     use AuthenticatesUsers;
    //
    public function login(){


        $userInfoTemp = session('oauth_user');

        $userInfo = DB::table('user')->where('openid',$userInfoTemp['openid'])->select(['id','openid','avatar','nickname'])->first(); //检索用户是否存在

        if($userInfo){  //用户登录
            
            $userInfo = json_decode(json_encode($userInfo),true);
//             dd($userInfo);
            session(['user_info'=>$userInfo]);
            if(!session('user_info')){ //登录失败
                return redirect('/');
            }
            
        }else{          //用户注册
            $avatar  = downImg($userInfoTemp['headimgurl']); //下载头像到本地
            
            $sdata['openid']   = $userInfoTemp['openid'];
            $sdata['nickname'] = $userInfoTemp['nickname'];
            $sdata['headimgurl'] = $userInfoTemp['headimgurl'];
            $sdata['avatar'] = $avatar;
            $sdata['status']   = 1;
            $id = DB::table('user')->insertGetId ($sdata);

            if(!$id){ //注册失败
                return redirect('/');
            }
            $sdata['id'] = $id;
            $userInfo =  DB::table('user')->where('id',$id)->first();
            $userInfo = json_decode(json_encode($userInfo),true);
            session(['user_info'=>$userInfo]);
            if(!session('user_info')){ //登录失败
                return redirect('/');
            }
            
        }

        return redirect('/home');
    }
    
    public function logout(Request $request){
//         $request->session()->forget('user_info');
        $request->session()->flush();
        
        return '删除了所有session';
    }
}
