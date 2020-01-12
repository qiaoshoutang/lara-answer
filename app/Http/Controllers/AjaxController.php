<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\User;


class AjaxController extends Controller
{

    //验证答案
    public function check(Request $request){
        $data = $request->all();
        
        $page_id = $data['page_id'];
        if(($page_id<1) || ($page_id>15)){
            return '页面参数有误';
        }
        $answer = session('answer');
        if(isset($answer[$page_id])){  //该题已答过  跳往下一题
            if($page_id == 15){
                $next_url = '/report/this';
            }else{
                $next_url = '/content/'.($page_id+1);
            }
            $rdata['code'] = 3;
            $rdata['info'] = '您已经回答过该题！';
            $rdata['data'] = $next_url;

            return $rdata;
        }
        
        if($page_id == 15){
            $next_url = '/report/this';
        }else{
            $next_url = '/content/'.($page_id+1);
        }

        $subject_arr = json_decode(session('subject'),true);
        $subject_id = $subject_arr[$page_id-1];
        
        if(empty($subject_id)){
            return '找不到题目';
        }
        //更新答案到session

        $answer[$page_id] = $data['answer'];
        session(['answer'=>$answer]);
        
        $subjectMod = new Subject();
        $subject_info = $subjectMod->select('right')->find($subject_id);
        if($data['answer'] == $subject_info->right){
            $score = session('score',0) +1;
            session(['score'=>$score]);
            $rdata['code'] = 1;
            $rdata['info'] = '答案正确';
            $rdata['data'] = $next_url;
            $rdata['right'] = $subject_info->right;
            return $rdata;
        }else{
            $rdata['code'] = 2;
            $rdata['info'] = '答案错误';
            $rdata['data'] = $next_url;
            $rdata['right'] = $subject_info->right;
            return $rdata;
        }
    }
    
    //已分享
    public function share(Request $request){
        $data = $request->all();
        if($data['share'] == true){
            $userMod = new User();
            $userInfo = $userMod->where('id',session('user_info.id'))->first();
            
            if(date('Y-m-d',$userInfo->share) == date('Y-d-d')){ //最新分享时间不是今天
                $rdata['code'] = 2;
                $rdata['info'] = '您今天已经分享过了~';
                return $rdata;
            }else{

                $sdata['share_time'] = time();
                $sdata['last_time'] = time() - 86400;              //最新答题时间改为昨天。这样用户今天可以再答题一次。
                
                $res = $userMod->where('id',$userInfo->id)->update($sdata);
                if($res){
                    $rdata['code'] = 1;
                    $rdata['info'] = '分享成功！';
                    return $rdata;
                }else{
                    $rdata['code'] = 0;
                    $rdata['info'] = '分享失败！';
                    return $rdata;
                }
            }
        }
        $rdata['code'] = 0;
        $rdata['info'] = '分享失败！';
        return $rdata;
        
    }
    
}
 