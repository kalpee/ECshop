<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




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

    /**
     * 退会機能
     * 
     * @return Illuminate\Support\Facades\Redirect
     */

    public function destroy()
    {
        User::findOrFail(Auth::id())->delete();

        return redirect()
        ->route('user.login')
        ->with([
            'status' => '退会完了しました。',
        ]);
    }

    /**
     * 退会確認画面表示
     * 
     * @return Illuminate\Support\Facades\View
     */

    public function delete_confirm()
    {
        return view('user.delete_confirm');
    }
}