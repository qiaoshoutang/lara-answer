<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

//         dd(config('app.APPID'),config('app.APPSECRET'));
//         cache(['a'=>'aa'],10);
//         $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.config('app.APPID').'&secret='.config('app.APPSECRET');
// //         dd($url);
//         $res = $this->curl_get($url);
//         dd(json_decode($res,true));
        $signaturn = get_wx_signature();
        dd($signaturn);
        return '按个';
        
        
    }
    public function test(Request $request)
    {
        dd(cache('a'));

        
        
    }
    public function to_unicode($string)
        {
            $str = mb_convert_encoding($string, 'UCS-2', 'UTF-8');
            $arrstr = str_split($str, 2);
            $unistr = '';
            foreach ($arrstr as $n) {
                $dec = hexdec(bin2hex($n));
                $unistr .= '&#' . $dec . ';';
            }
            return $unistr;
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
