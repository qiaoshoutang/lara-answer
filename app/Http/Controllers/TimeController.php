<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class TimeController extends Controller
{
    // 新的一天  刷新数据
    public function newDay(Request $request)
    {


        $userMod = new User();
        
        $res = $userMod->where('last_time','<',3)->update(['last_time'=>3]);
        
        return $res;
    }
    
}