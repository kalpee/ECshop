<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Owner;
use App\Models\Product;
use App\Models\PrimaryCategory;
use App\Models\Shop;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

/**
 * ログインユーザー確認処理
 */
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('product');
            if(!is_null($id)) {
            $productOwnerId = Product::findOrFail($id)->shop->owner->id;
                $productId = (int)$productOwnerId;
                if($productId !== Auth::id()) { 
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    /**
 * 商品詳細画面表示
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function index()
    {
        $ownerInfo = Owner::with('shop.product.imageFirst')
        ->where('id', Auth::id())->get();

        return view('owner.products.index',
        compact('ownerInfo'));
    }

/**
 * 商品登録画面表示
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function create()
    {
        $shops = Shop::where('owner_id', Auth::id())
        ->select('id', 'name')
        ->get();

        $images = Image::where('owner_id', Auth::id())
        ->select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        return view('owner.products.create',
        compact('shops', 'images', 'categories'));
    }

/**
 * 商品登録処理
 * 
 * @param ProductRequest $request
 * @return Illuminate\Support\Facades\Redirect
 */
    public function store(ProductRequest $request)
    {

        try{
            DB::transaction(function () use($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'sort_order' => $request->sort_order,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'is_selling' => $request->is_selling
                ]);

                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1,
                    'quantity' => $request->quantity
                ]);
            }, 2);
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }

        return redirect()
        ->route('owner.products.index')
        ->with(['message' => '商品登録しました。',
        'status' => 'info']);
    }

/**
 * 商品情報編集画面表示
 * 
 * @param integer $id
 * @return Illuminate\Support\Facades\View
 */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
        ->sum('quantity');

        $shops = Shop::where('owner_id', Auth::id())
        ->select('id', 'name')
        ->get();

        $images = Image::where('owner_id', Auth::id())
        ->select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        return view('owner.products.edit',
        compact('product', 'quantity', 'shops', 'images', 'categories'));
    }

/**
 * 商品情報編集処理
 * 
 * @param ProductRequest $request
 * @param integer $id
 * @return Illuminate\Support\Facades\Redirect
 */
    public function update(ProductRequest $request, $id)
    {
        $request->validate([
            'current_quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
        ->sum('quantity');
        if($request->current_quantity !== $quantity){
            $id = $request->route()->parameter('product');
            return redirect()->route('owner.products.edit', [ 'product' => $id ])
            ->with(['message' => '在庫数が変更されています。再度確認してください。',
                'status' => 'alert']);
        } else {

            try{
                DB::transaction(function () use($request, $product) {

                        $product->name = $request->name;
                        $product->information = $request->information;
                        $product->price = $request->price;
                        $product->sort_order = $request->sort_order;
                        $product->shop_id = $request->shop_id;
                        $product->secondary_category_id = $request->category;
                        $product->image1 = $request->image1;
                        $product->image2 = $request->image2;
                        $product->image3 = $request->image3;
                        $product->image4 = $request->image4;
                        $product->is_selling = $request->is_selling;
                        $product->save();

                    if($request->type === \Constant::PRODUCT_LIST['add']){
                        $newQuantity = $request->quantity;
                    }
                    if($request->type === \Constant::PRODUCT_LIST['reduce']){
                        $newQuantity = $request->quantity * -1;
                    }
                    Stock::create([
                        'product_id' => $product->id,
                        'type' => $request->type,
                        'quantity' => $newQuantity
                    ]);
                }, 2);
            }catch(Throwable $e){
                Log::error($e);
                throw $e;
            }
    
            return redirect()
            ->route('owner.products.index')
            ->with(['message' => '商品情報を更新しました。',
            'status' => 'info']);
        }
    }

/**
 * 商品削除物理処理
 * 
 * @param integer $id
 * @return Illuminate\Support\Facades\Redirect
 */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()
        ->route('owner.products.index')
        ->with(['message' => '商品を削除しました。',
        'status' => 'alert']);
    }
}
