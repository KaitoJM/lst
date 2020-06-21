<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get-current-session', function() {
    $current_session = App\Session::where('status', 1)->with(['orders' => function($q) {
        return $q->with([
            'items' => function($item) {
                return $item->with(['session_product' => function($sess_prod) {
                    $sess_prod->with('product');
                }]);
            },
            'customer',
            'author'
        ])->withCount('items');
    }])->orderBy('start_date', 'DESC')->first();

    // return $current_session;
    $formatted = [
        'id' => $current_session->id,
        'start_date' => $current_session->start_date,
        'name' => $current_session->name,
        'orders' => collect($current_session->orders)->map(function($order) {
            return [
                'id' => $order->id,
                'customer_id' => $order->customer_id,
                'author_id' => $order->author_id,
                'customer_fname' => $order->customer->fname,
                'customer_lname' => $order->customer->lname,
                'author_fname' => $order->author->fname,
                'author_lname' => $order->author->lname,
                'items_count' => $order->items_count,
                'products_count' => $order->items->sum('qty'),
                'total' => $order->items->sum(function($t){ 
                    return $t->qty * $t->price; 
                }),
                'items' => collect($order->items)->map(function($item) {
                    return [
                        'id' => $item->id,
                        'product' => $item->session_product->product->name,
                        'image' => $item->session_product->product->image,
                        'product_id' => $item->session_product->product->id,
                        'price' => $item->price,
                        'qty' => $item->qty,
                        'total' => $item->qty * $item->price,
                    ];
                })
            ];
        })
    ];

    return $formatted;
});

Route::get('get-sessions', function() {
    return App\Session::orderBy('start_date', 'DESC')->get();
});

Route::get('get-sessions-products/{session_id}', function($session_id) {
    $product_options = App\SessionProduct::where('session_id', $session_id)->with('product')->get();

    return collect($product_options)->map(function($option) {
        return [
            'id' => $option->id,
            'product_id' => $option->product_id,
            'product_name' => $option->product->name,
            'price' => $option->product->price,
            'quantity' => $option->quantity
        ];
    });
});

