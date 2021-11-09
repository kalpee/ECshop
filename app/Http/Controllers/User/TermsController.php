<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class TermsController extends Controller {
    /**
     * 利用規約画面表示
     * 
     * @return Illuminate\Support\Facades\View
     */

    public function index() 
    {
        return view('user.terms');
    }
}