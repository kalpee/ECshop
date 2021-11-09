<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class MypageController extends Controller {
    /**
     * マイページ画面表示
     * 
     * @return Illuminate\Support\Facades\View
     */

    public function index() 
    {
        return view('user.mypage');
    }
}