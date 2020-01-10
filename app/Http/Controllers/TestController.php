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
        $str = 'fohh阶级固化然后hhho';

        $img = Image::make('avatar/mould.jpg');
        $img ->insert('avatar/202001/1578040207_3474.png','bottom-right',150,10);

        $img->text($str, 300, 250, function($font) {
            $font->file(base_path().'/public/font/msyh.ttf');
            $font->size(140);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });
        $img->save('avatar/aaa.png');
//         session(['user_3'=>111]);
//         dump($img);
        return '按个';
        
        
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
