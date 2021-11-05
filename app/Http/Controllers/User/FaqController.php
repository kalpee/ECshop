<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class FaqController extends Controller {
    /**
     * よくある質問画面表示
     * 
     * @return Illuminate\Support\Facades\View
     */

    public function index() 
    {
        return view('user.faq');
    }
}