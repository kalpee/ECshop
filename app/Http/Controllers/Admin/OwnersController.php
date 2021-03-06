<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class OwnersController extends Controller
{

    
/**
 * ログインユーザー確認処理
 */
    public function __construct()
    {
        $this->middleware('auth:admin');
    } 

/**
 * オーナー一覧表示
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function index()
    {
        $owners = Owner::select('id', 'name', 'email', 'created_at')
        ->paginate(3);

        return view('admin.owners.index', 
        compact('owners'));
    }

/**
 * オーナー登録画面表示
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function create()
    {
        return view('admin.owners.create');
    }

/**
 * オーナー、店舗情報登録処理
 * 
 * @param Request $request
 * @return Illuminate\Support\Facades\Redirect
 */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:owners',
            'password' => 'required|string|confirmed|min:8',
        ]);

        try{
            DB::transaction(function() use($request)
            {
                $owner = Owner::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                Shop::create([
                    'owner_id' => $owner->id,
                    'name' => '店名を入力してください',
                    'information' => '',
                    'filename' => '',
                    'is_selling' => true
                ]);
            }, 2);
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }

        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー登録を実施しました。',
        'status' => 'info']);
    }

/**
 * オーナー情報編集画面
 * 
 * @param integer $id
 * @return Illuminate\Support\Facades\View
 */
    public function edit($id)
    {
        $owner = Owner::findOrFail($id);
        return view('admin.owners.edit', compact('owner'));
    }

/**
 * オーナー情報更新処理
 * 
 * @param Request $request
 * @param integer $id
 * @return Illuminate\Support\Facades\Redirect
 */
    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();

        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー情報を更新しました。',
        'status' => 'info']);
    }

/**
 * オーナー情報論理削除処理
 * 
 * @param integer $id
 * @return Illuminate\Support\Facades\Redirect
 */
    public function destroy($id)
    {
        Owner::findOrFail($id)->delete(); //ソフトデリート

        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー情報を削除しました。',
        'status' => 'alert']);
    }

/**
 * ゴミ箱にあるオーナー情報取得処理
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function expiredOwnerIndex()
    {
        $expiredOwners = Owner::onlyTrashed()->get();
        return view('admin.expired-owners', compact('expiredOwners'));
    }

/**
 * オーナー情報物理削除処理
 * 
 * @param integer $id
 * @return Illuminate\Support\Facades\Redirect
 */
    public function expiredOwnerDestroy($id)
    {
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.expired-owners.index'); 
    }
}
