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
        ])->withCount('items')->orderBy('created_at', 'DESC');
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

Route::get('get-customers', function() {
    return App\Customer::all();
});

Route::get('get-users', function() {
    return App\User::all();
});

Route::post('submit-order', function(Request $request) {
    // return $request->all();
    $error = 0;
    $message = '';
    $customer = null;

    if ($request->has('customer_id') && $request->input('customer_id')) {
        $customer = App\Customer::find($request->input('customer_id'));

        if (!$customer) {
            $error++;
            $message = 'Invalid customer.';
        }
    } else {
        $customer = new App\Customer;

        $customer->fname = $request->input('customer_fname');
        $customer->lname = $request->input('customer_lname');
        $customer->email = $request->input('customer_email');
        $customer->phone = $request->input('customer_phone');
        $customer->address = $request->input('customer_address');
        $customer->addgenderress = $request->input('customer_gender');

        $save = $customer->save();

        if ($save) {
            $error++;
            $message = 'Invalid customer.';
        }
    }

    if ($customer) {
        $order = new App\Order;

        $order->session_id = $request->input('session_id');
        $order->customer_id = $customer->id;
        $order->author_id = $request->input('author_id');
        $order->status = 0;

        $save = $order->save();

        if ($save) {
            $items = json_decode($request->input('items'));

            if (is_array($items) && count($items)) {
                foreach($items as $item) {
                    $orderItem = new App\OrderItem;

                    $orderItem->order_id = $order->id;
                    $orderItem->session_product_id = $item->session_product_id;
                    $orderItem->qty = $item->qty;
                    $orderItem->price = $item->price;
                
                    $orderItem->save();
                }
            } else {
                $error++;
                $message = 'No order items selected.';
            }
        } else {
            $error++;
            $message = 'Invalid order.';
        }
    } else {
        $error++;
        $message = 'Invalid customer.';
    }

    return [
        'err' => $error,
        'msg' => $message,
    ];
});

