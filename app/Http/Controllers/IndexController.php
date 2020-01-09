<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;

class IndexController extends Controller
{
    // 首页
    public function index(Request $request)
    {
        $subjectMod = new Subject();
        $subjectList = $subjectMod->inRandomOrder()->take(5)->get();
        $subject_arr;
        foreach($subjectList as $subject){
            $subject_arr[] = $subject->id;
        }
        
        session(['subject'=>json_encode($subject_arr),'score'=>0]);
        
        return view('index');
    }
    
    //答题界面
    public function content(Request $request){
        $page_id = $request->subject;
        if(($page_id<1) || ($page_id>15)){
            return '页面参数有误';
        }
        $subject_arr = json_decode(session('subject'),true);
        $subject_id = $subject_arr[$page_id-1];
        
        if(empty($subject_id)){
            return '找不到题目';
        }
        $subjectMod = new Subject();
        $subject_info = $subjectMod->find($subject_id);
        if(empty($subject_info)){
            return '找不到题目';
        }
        
        return view('content',['subjectInfo'=>$subject_info,'page_id'=>$page_id]);
    }
    
    //报告页
    public function report(Request $request){

        $score = session('score',0);
        return view('report');
    }
    
    //验证答案
    public function check(Request $request){
        $data = $request->all();
        
        $page_id = $data['page_id'];
        if(($page_id<1) || ($page_id>15)){
            return '页面参数有误';
        }
        if($page_id == 15){
            $next_url = '/report';
        }else{
            $next_url = '/content/'.++$page_id;
        }
        $subject_arr = json_decode(session('subject'),true);
        $subject_id = $subject_arr[$page_id-1];
        
        if(empty($subject_id)){
            return '找不到题目';
        }
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
    
}
 