<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\User;
use Intervention\Image\Facades\Image;

class IndexController extends Controller
{
    // 首页
    public function index(Request $request)
    {


        $signaturn = get_wx_signature();
        if(empty($signaturn)){
            return '获取微信签名失败';
        }
        
        return view('index',['signaturn'=>$signaturn]);
    }
    
    //答题界面
    public function content(Request $request){
        
        
        
        $page_id = $request->subject;
        if(($page_id<1) || ($page_id>15)){
            return '页面参数有误';
        }


//         dd(isset($answer[$page_id]));

        if($page_id == 1){ //开始答题   进行数据处理
            
            $userMod = new User();
            $userInfo = $userMod->where('id',session('user_info.id'))->select(['last_time','share_time'])->first();
            if(empty($userInfo)){
                return redirect('/');
            }
            if(date('Y-m-d',$userInfo['last_time']) == date('Y-m-d')){          //今天已经答题
                if(date('Y-m-d',$userInfo['share_time']) == date('Y-m-d')){     //今天已经分享
                    return back()->withErrors('您今天的机会已经用完，明天再来挑战吧!');
                }else{
                    return back()->withErrors('您今天已经进行过答题，分享可以再获得一次机会哦！');
                }
            }
            //答题开始  刷新数据
            $subjectMod = new Subject();
            $subjectList = $subjectMod->inRandomOrder()->take(15)->get();
            $subject_arr;
            foreach($subjectList as $subject){
                $subject_arr[] = $subject->id;
            }
            
            session(['subject'=>json_encode($subject_arr),'score'=>0,'answer'=>[]]);
            $res = $userMod->where('id',session('user_info.id'))->update(['last_time'=>time()]);
            if(empty($res)){
                return back()->withErrors('修改信息失败！');
            }

        }
        $answer = session('answer');
        if(isset($answer[$page_id])){  //该题已答过  跳往下一题
            if($page_id == 15){
                $next_url = '/report/this';
            }else{
                $next_url = '/content/'.($page_id+1);
            }
            return redirect($next_url);
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

//         dd(session('answer'));
        $data = $request->all();
        if(isset($data['from'])){
            return redirect('/home');
        }
        $type = $request->type;
        if(empty($type)){
            return '参数错误';
        }
        $userMod = new User();
        if($type == 'best'){
            $userInfo = $userMod->where('id',session('user_info.id'))->first();
            
            if(empty($userInfo->poster)){
                return back()->withErrors('您还未完成过答题，加油吧！');
            }
            $poster = $userInfo->poster;
        }
        if($type == 'this'){
            $score = session('score',0);
            
            $userInfo = $userMod->where('id',session('user_info.id'))->first();
            
            $poster = $this->makePoster($score,$userInfo);
            if(empty($poster)){
                return '海报生成错误';
            }
            
            if((empty($userInfo->poster))||($score>$userInfo->best)){
                $res = $userMod->where('id',$userInfo['id'])->update(['best'=>$score,'poster'=>$poster]);
                if(empty($res)){
                    return '更新信息失败';
                }
            }
        }
        if(date('Y-m-d',$userInfo->last_time) == date('Y-m-d')){  //今天已经答题
            $can_answer = 0;
        }else{
            $can_answer = 1;
        }
        if(date('Y-m-d',$userInfo->share_time) == date('Y-m-d')){  //今天已经分享
            $can_share = 0;
        }else{
            $can_share = 1;
        }

        $signaturn = get_wx_signature();
        if(empty($signaturn)){
            return '获取微信签名失败';
        }
//         dd($signaturn);
        return view('report',['poster'=>$poster,'can_answer'=>$can_answer,'can_share'=>$can_share,'signaturn'=>$signaturn]);

    }
     
    //奖品领取
    public function reward(Request $request){
        
        if($request->method() == 'POST'){ //数据提交
            
            $data = $request->all();
            if(empty($data['wechat'])||empty($data['r_account'])||empty($data['r_uid'])){
                $rdata['code'] = 0;
                $rdata['info'] = '必填项不能为空';
                return $rdata;
            }
            unset($data['_token']);

            $sdata['wechat'] = htmlspecialchars($data['wechat']);
            $sdata['r_account'] = htmlspecialchars($data['r_account']);
            $sdata['r_uid'] = htmlspecialchars($data['r_uid']);

            $userInfo = session('user_info');
            
            $userMod = new User();
            $res = $userMod->where('id',session('user_info.id'))->update($sdata);
            
            if($res){
                $rdata['code'] = 1;
                $rdata['info'] = '提交成功';
                return $rdata;
            }else{
                $rdata['code'] = 0;
                $rdata['info'] = '提交失败';
                return $rdata;
            }
        }
        $userInfo = User::where('id',session('user_info.id'))->select(['wechat','r_account','r_uid'])->first();
        $userInfo->wechat = htmlspecialchars_decode($userInfo->wechat);
        $userInfo->r_account = htmlspecialchars_decode($userInfo->r_account);
        $userInfo->r_uid = htmlspecialchars_decode($userInfo->r_uid);

        return view('reward',['userInfo'=>$userInfo]);
    }
    //生成海报
    private function makePoster($score=0,$userInfo){
        $rewardArr =[
            '1'=>['grade'=>'images/D-.png','prize'=>'0 DNA','word'=>['天呐，你对区块链一无所知，好好学习，别','被时代的洪流甩下啊！现在的你还不适合接','触区块链投资，继续学习吧！']],
            '2'=>['grade'=>'images/D.png','prize'=>'10 DNA','word'=>['你对区块链所知甚少，好好学习，别被时代','的洪流甩下啊！无论何时开始学习都不晚，','知识越丰富，收获越多，继续修炼吧！']],
            '3'=>['grade'=>'images/C.png','prize'=>'50 DNA','word'=>['你比萌新多了一些成熟，但还缺乏历练，仍','须仔细甄别区块链炒作乱象，避免被忽悠~','学海无涯，可以在区块链的海洋中继续漂泊~']],
            '4'=>['grade'=>'images/B.png','prize'=>'100 DNA','word'=>['你是个小小的区块链百晓生，保持这种学习','劲头，假以时日必然更进一步！学海无涯，','别太快上岸，财运早晚会眷顾你！']],
            '5'=>['grade'=>'images/A.png','prize'=>'300 DNA','word'=>['你是区块链百事通，相信你会成为一个优秀','的布道者！无论是学习还是生活，付出总会','收获回报！']],
            '6'=>['grade'=>'images/A+.png','prize'=>'500 DNA','word'=>['区块链百晓生就是你了吧！请不要吝啬你的','智慧，多为别人答疑解惑！继续学习，会有','更多的回报！坚定信仰，下一个扑克牌大佬','可能就是你！']]
        ];
        if(($score>=1)&&($score<=5)){
            $rewardInfo = $rewardArr['2'];
        }elseif(($score>=6)&&($score<=9)){
            $rewardInfo = $rewardArr['3'];
        }elseif(($score>=10)&&($score<=12)){
            $rewardInfo = $rewardArr['4'];
        }elseif(($score>=13)&&($score<=14)){
            $rewardInfo = $rewardArr['5'];
        }elseif($score==15){
            $rewardInfo = $rewardArr['6'];
        }else{
            $rewardInfo = $rewardArr['1'];
        }

        $targetUrl = 'poster/'.$userInfo->id.'_'.$score.'.jpg';

        $img = Image::make('images/mould.jpg');
        $img ->insert($userInfo->avatar,'top-left',156,484);                   //合成头像
        $img ->insert('images/circle.png','top-left',150,474);                   //合成头像
        $img->text($userInfo->nickname, 230, 630, function($font) {            //水印昵称
            $font->file(base_path().'/public/font/pf.ttf');
            $font->size(26);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });

        $img->text($score*10, 510, 475, function($font) {                      //水印分数
            $font->file(base_path().'/public/font/pf.ttf');
            $font->size(50);
            $font->color('#f0130b');
            $font->align('center');
            $font->valign('top');
        });
        $img ->insert($rewardInfo['grade'],'top-left',490,547);                  //合成成绩
        $img->text($rewardInfo['prize'], 520, 615, function($font) {             //水印奖励
            $font->file(base_path().'/public/font/pf.ttf');
            $font->size(35);
            $font->color('#f0130b');
            $font->align('center');
            $font->valign('top');
        });
        
        $start_x_word = 120;
        $start_y_word = 768;
        foreach($rewardInfo['word'] as $word){
            $img->text($word, $start_x_word, $start_y_word, function($font) {
                $font->file(base_path().'/public/font/pf.ttf');
                $font->size(26);
                $font->color('#000');
                $font->align('left');
                $font->valign('top');
            });
            $start_y_word += 36;
        }
        
        $img->save($targetUrl);

        return $targetUrl;
        
    }
    
    
}
 