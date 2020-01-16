<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\User;

class AdminController extends Controller
{
    // 首页
    public function index(Request $request)
    {
        $subjectMod = new Subject();
        $subjectList = $subjectMod->where('status',1)->orderBy('id','desc')->get();

        
        return view('admin.home',['subjectList'=>$subjectList]);
    }
    
    // 题库列表
    public function subjectList(Request $request){
        $subjectMod = new Subject();
        $subjectList = $subjectMod->where('status',1)->orderBy('id','desc')->paginate(20);
        
        $subjectList->links();

        return view('admin.subjectList',['subjectList'=>$subjectList]);
    }
    //题目添加界面
    public function content(Request $request){

        if($request->method() == 'POST'){ //数据提交
            
            $data = $request->only(['title','option_a','option_b','option_c','option_d','right']);

            if(empty($data['title'])||empty($data['option_a'])||empty($data['option_b'])||empty($data['option_c'])||empty($data['option_d'])||empty($data['right'])){
                $rdata['code'] = 0;
                $rdata['info'] = '必填项不能为空';
                return $rdata;
            }
            unset($data['_token']);
            $data['status'] = 1;
            
            $subjectMod = new Subject();
            $res = $subjectMod->insert($data);

            if($res){
                $rdata['code'] = 1;
                $rdata['info'] = '添加成功';
                return $rdata;
            }else{
                $rdata['code'] = 0;
                $rdata['info'] = '添加失败';
                return $rdata;
            }
        }
        return view('admin.content');
    }
    
    //题目修改界面
    public function edit(Request $request){

        if($request->method() == 'POST'){ //数据提交
            
            $data = $request->only(['id','title','option_a','option_b','option_c','option_d','right']);

            if(empty($data['title'])||empty($data['option_a'])||empty($data['option_b'])||empty($data['option_c'])||empty($data['option_d'])||empty($data['right'])){
                $rdata['code'] = 0;
                $rdata['info'] = '必填项不能为空';
                return $rdata;
            }
            if(empty($data['id'])){
                $rdata['code'] = 0;
                $rdata['info'] = '题目id不能为空';
                return $rdata;
            }
            unset($data['_token']);
            $data['status'] = 1;

            $subjectMod = new Subject();
            $res = $subjectMod->where('id',$data['id'])->update($data);

            if($res){
                $rdata['code'] = 1;
                $rdata['info'] = '修改成功';
                return $rdata;
            }else{
                $rdata['code'] = 0;
                $rdata['info'] = '修改失败';
                return $rdata;
            }
        }
        $id = $request->id;
        $subjectMod = new Subject();
        $info = $subjectMod->where('id',$id)->first();

        return view('admin.info',['info'=>$info]);
    }
    //题目删除
    public function del(Request $request){
  
        $data = $request->all();

        if(empty($data['id'])){
            $rdata['code'] = 0;
            $rdata['info'] = '题目id不能为空';
            return $rdata;
        }
        
        $subjectMod = new Subject();
        $res = $subjectMod->destroy($data['id']);

        if($res){
            $rdata['code'] = 1;
            $rdata['info'] = '删除成功';
            return $rdata;
        }else{
            $rdata['code'] = 0;
            $rdata['info'] = '删除失败';
            return $rdata;
        }
    }
    
    // 成绩列表
    public function resultList(Request $request){
        $userMod = new User();
        $userList = $userMod->where('status',1)->orderBy('id','desc')->paginate(20);

        $userList->links();
        return view('admin.resultList',['userList'=>$userList]);
    }
    
    // 再一次答题机会
    public function userChance(Request $request){
        $data = $request->all();

        if(empty($data['id'])){
            $rdata['code'] = 0;
            $rdata['info'] = '参数不能为空！';
            return $rdata;
        }
        $userMod = new User();
        $res = $userMod->where('id',$data['id'])->increment('last_time');
        if($res){
            $rdata['code'] = 1;
            $rdata['info'] = '操作成功！';
            return $rdata;
        }else{
            $rdata['code'] = 0;
            $rdata['info'] = '操作失败！';
            return $rdata;
        }
    }
    
    // 删除用户
    public function userDel(Request $request){
        $data = $request->all();
        if(empty($data['id'])){
            $rdata['code'] = 0;
            $rdata['info'] = '参数不能为空！';
            return $rdata;
        }
        $userMod = new User();
        
        $res = $userMod->destroy($data['id']);
        if($res){
            $rdata['code'] = 1;
            $rdata['info'] = '操作成功！';
            return $rdata;
        }else{
            $rdata['code'] = 0;
            $rdata['info'] = '操作失败！';
            return $rdata;
        }
    }
    
    public function login(Request $request){
        $key = $request->key;
        if(empty($key)){
            return 'key不能为空';
        }
        //md5(laravelanswer@#$0108,32) = 24673df72520001da39f3abce8c2f729
        if($key != '24673df72520001da39f3abce8c2f729'){
            return 'key不正确';
        }

        session(['admin_info'=>1]);
        return redirect('/admin/home');
    }
    
    public function logout(Request $request){
        $request->session()->forget('admin_info');
        echo '请先登录';
    }
    
}
 



