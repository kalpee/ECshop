<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SendThanksMail;
use App\Jobs\SendOrderedMail;
use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

/**
 * カート画面表示
 * 
 * @return Illuminate\Support\Facades\View
 */
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $products = $user->products;
        $totalPrice = 0;

        foreach ($products as $product){
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        return view('user.cart',
        compact('products', 'totalPrice'));
    }

/**
 * カート追加処理
 * 
 * @param Request $request
 * @return Illuminate\Support\Facades\Redirect
 */
    public function add(Request $request)
    {
        $itemInCart = Cart::where('product_id', $request->product_id)
        ->where('user_id', Auth::id())->first();

        if($itemInCart){
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();

        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('user.cart.index');
    }

/**
 * カート内商品物理削除処理
 * 
 * @param integer $id
 * @return Illuminate\Support\Facades\Redirect
 */
    public function delete($id)
    {
        Cart::where('product_id', $id)
        ->where('user_id', Auth::id())
        ->delete();

        return redirect()->route('user.cart.index');
    }

/**
 * 商品購入処理(stripe)
 * 
 * @return Illuminate\Support\Facades\Redirect
 */
    public function checkout()
    {

        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        $lineItems = [];
        foreach ($products as $product){
            $quantity = '';
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');

            if($product->pivot->quantity > $quantity){
                return view('user.cart.index');
            } else {
                $lineItem = [
                    'name' => $product->name,
                    'description' => $product->information,
                    'amount' => $product->price,
                    'currency' => 'jpy',
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }
        }

        foreach ($products as $product){
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['reduce'],
                'quantity' => $product->pivot->quantity * -1
            ]);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('user.cart.success'),
            'cancel_url' => route('user.cart.cancel'),
        ]);

        return redirect($session->url, 303);
    }

/**
 * 決済成功時の処理
 * 
 * @return Illuminate\Support\Facades\Redirect
 */
    public function success()
    {

        $items = Cart::where('user_id', Auth::id())->get();
        $products = CartService::getItemsInCart($items);
        $user = User::findOrFail(Auth::id());

        SendThanksMail::dispatch($products, $user);
        foreach ($products as $product){
            SendOrderedMail::dispatch($product, $user);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.items.index');
    }

/**
 * 決済中に購入キャンセルした時の処理
 * 
 * @return Illuminate\Support\Facades\Redirect
 */
    public function cancel()
    {
        $user = User::findOrFail(Auth::id());
        
        foreach ($user->products as $product){
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['add'],
                'quantity' => $product->pivot->quantity
            ]);
        }

        return redirect()->route('user.cart.index');
    }
}
