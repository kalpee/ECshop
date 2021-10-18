<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    
/**
 * 商品画像一覧
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function index()
    {
        $images = Image::where('owner_id', Auth::id())
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

        return view('owner.images.index',
        compact('images'));
    }
    
/**
 * ログインユーザー確認処理
 */
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('image');
            if(!is_null($id)) {
            $imagesOwnerId = Image::findOrFail($id)->owner->id;
                $imageId = (int)$imagesOwnerId;
                if($imageId !== Auth::id()) { 
                    abort(404);
                }
            }
            return $next($request);
        });
    }

/**
 * 商品画像登録画面表示
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function create()
    {
        return view('owner.images.create');
    }

/**
 * 商品画像登録処理
 * 
 * @param UploadImageRequest $request
 * @return Illuminate\Support\Facades\Redirect
 */
    public function store(UploadImageRequest $request)
    {
        $imageFiles = $request->file('files');
        if(!is_null($imageFiles)){
            foreach ($imageFiles as $imageFile) {
                $fileNameToStore = ImageService::upload($imageFile, 'products');
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore
                ]);
            }
        }

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像登録を実施しました。',
        'status' => 'info']);
    }

/**
 * 商品画像編集画面表示
 * 
 * @param integer $id
 * @return Illuminate\Support\Facades\View
 */
    public function edit($id)
    {
        $image =Image::findOrFail($id);
        return view('owner.images.edit', compact('image'));
    }

/**
 * 商品画像編集処理
 * 
 * @param Request $request
 * @param integer $id
 * @return Illuminate\Support\Facades\Redirect
 */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string|max:50',
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像情報を更新しました。',
        'status' => 'info']);
    }

/**
 * 商品画像物理処理
 * 
 * @param integer $id
 * @return Illuminate\Support\Facades\Redirect
 */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        $imageInProducts = Product::where('image1', $image->id)
        ->orWhere('image2', $image->id)
        ->orWhere('image3', $image->id)
        ->orWhere('image4', $image->id)
        ->get();

        if($imageInProducts){
            $imageInProducts->each(function($product) use($image){
                if($product->image1 === $image->id){
                    $product->image1 = null;
                    $product->save();
                }
                if($product->image2 === $image->id){
                    $product->image2 = null;
                    $product->save();
                }
                if($product->image3 === $image->id){
                    $product->imag3 = null;
                    $product->save();
                }
                if($product->image4 === $image->id){
                    $product->image4 = null;
                    $product->save();
                }
            });
        }

        $filePath = 'public/products/' . $image->filename;

        if(Storage::exists($filePath)){
            Storage::delete($filePath);
        }

        Image::findOrFail($id)->delete();

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像を削除しました。',
        'status' => 'alert']);
    }
}
