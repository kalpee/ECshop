<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class TokushohoController extends Controller {
    /**
     * 特定商取引法に基づく表記画面表示
     * 
     * @return Illuminate\Support\Facades\View
     */

    public function index() 
    {
        return view('user.tokushoho');
    }
}