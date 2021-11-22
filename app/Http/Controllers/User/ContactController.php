<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ContactSendmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{

/**
 * お問合せ画面表示
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function index()
    {
        return view('user.contact.index');
    }

/**
 * お問合せ内容確認画面表示
 * 
 * @param Request $request
 * @return Illuminate\Support\Facades\View
 */
    public function confirm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'required',
            'contact'  => 'required',
        ]);

        $inputs = $request->all();


        return view('user.contact.confirm',
        compact('inputs'));
    }

/**
 * thanksメール送信機能表示
 * 
 * @param Request $request
 * @return Illuminate\Support\Facades\View
 */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'required',
            'contact'  => 'required',
        ]);

        $action = $request->input('action');
        
        $inputs = $request->except('action');
        dd($inputs);


        if($action !== 'submit'){
            return redirect()
                ->route('user.contact.index')
                ->withInput($inputs);

        } else {
            Mail::to($inputs['email'])->send(new ContactSendmail($inputs));

            $request->session()->regenerateToken();

            return view('user.contact.thanks');
            
        }
    }
}
