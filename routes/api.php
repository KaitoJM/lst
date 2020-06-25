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

function getSession($id = null, $status = 1, $strict_current = false) {
    $session = App\Session::with(['orders' => function($q) {
        return $q->with([
            'items' => function($item) {
                return $item->with(['session_product' => function($sess_prod) {
                    $sess_prod->with('product');
                }]);
            },
            'customer',
            'author'
        ])->withCount('items')->orderBy('created_at', 'DESC');
    }])->with(['products' => function($sess_prod) {
        $sess_prod->with('product');
    }]);

    if ($id) {
        $session->where('id', $id);
        $session = $session->get();
    } else if ($status == 1) {
        $check_session = App\Session::where('status', 1)->get();

        if (count($check_session) == 0 && !$strict_current) {
            $session->where('status', 0);
            $session->orderBy('start_date', 'ASC');
            $session = $session->first();
        } else {
            $session->where('status', 1);
            $session = $session->first();
        }
    } else if ($status == 2) {
        $session->where('status', 2);
        $session->orderBy('start_date', 'DESC');
        $session = $session->get();
    } else {
        $session->where('status', 0);
        $session->orderBy('start_date', 'ASC');
        $session = $session->get();
    }

    // return $session;

    if (!isset($session->id)) {
        $formatted = collect($session)->map( function($session) {
            return [
                'id' => $session->id,
                'start_date' => $session->start_date,
                'end_date' => $session->end_date,
                'status' => $session->status,
                'name' => $session->name,
                'orders' => collect($session->orders)->map(function($order) {
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
                                'session_product_id' => $item->session_product->id,
                                'price' => $item->price,
                                'qty' => $item->qty,
                                'total' => $item->qty * $item->price,
                            ];
                        }),
                    ];
                }),
                'products' => collect($session->products)->map(function($product) {
                    return [
                        'id' => $product->id,
                        'product_id' => $product->product_id,
                        'product' => $product->product->name,
                        'image' => $product->product->image,
                        'price' => $product->product->price,
                        'qty' => $product->qty,
                    ];
                })
            ];
        });
    } else {
        $formatted = [
            'id' => $session->id,
            'start_date' => $session->start_date,
            'end_date' => $session->end_date,
            'status' => $session->status,
            'name' => $session->name,
            'orders' => collect($session->orders)->map(function($order) {
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
                            'session_product_id' => $item->session_product->id,
                            'price' => $item->price,
                            'qty' => $item->qty,
                            'total' => $item->qty * $item->price,
                        ];
                    })
                ];
            }),
            'products' => collect($session->products)->map(function($product) {
                return [
                    'id' => $product->id,
                    'product_id' => $product->product_id,
                    'product' => $product->product->name,
                    'image' => $product->product->image,
                    'price' => $product->product->price,
                    'qty' => $product->qty,
                ];
            })
        ];
    }
    // return $session;

    return $formatted;
}

Route::get('get-current-session', function() {
    return getSession();
});

Route::get('get-current-session/current-only', function() {
    return getSession(null, 1, true);
});

Route::get('get-sessions', function() {
    return [
        'preparation' => getSession(null, 0),
        'ended' => getSession(null, 2),
    ];
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
        // $customer = new App\Customer;

        // $customer->fname = $request->input('customer_fname');
        // $customer->lname = $request->input('customer_lname');
        // $customer->email = $request->input('customer_email');
        // $customer->phone = $request->input('customer_phone');
        // $customer->address = $request->input('customer_address');
        // $customer->gender = $request->input('customer_gender');

        // $save = $customer->save();

        // if ($save) {
            $error++;
            $message = 'Invalid customer.';
        // }
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

Route::post('submit-customer', function(Request $request) {
    // return $request->all();
    $id = 0;
    $error = 0;
    $message = '';

    $customer = new App\Customer;

    if ($request->has('fname')) {
        $customer->fname = $request->input('fname');
        $customer->lname = $request->input('lname');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->address = $request->input('address');
        $customer->gender = $request->input('gender');
    
        $saved = $customer->save();

        if (!$saved) {
            $error++;
            $message = 'invalid customer info.';
        } else {
            $id = $customer->id;
        }
    } else {
        $error++;
        $message = 'No data received.';
    }
    
    return [
        'id'  => $id,
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('delete-order', function(Request $request) {
    // return $request->all();
    $error = 0;
    $message = '';

    if ($request->has('order_id')) {
        $deleted = App\Order::where('id', $request->input('order_id'))->delete();

        if ($deleted) {
            App\OrderItem::where('order_id', $request->input('order_id'))->delete();
        } else {
            $error++;
            $message = 'Invalid order.';
        }
    } else {
        $error++;
        $message = 'No data received.';
    }
    
    return [
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('update-order', function(Request $request) {
    $error = 0;
    $message = '';

    if ($request->has('order_id') && $request->input('order_id') && $request->has('items')) {
        $items = json_decode($request->input('items'));

        if (count($items)) {
            App\OrderItem::where('order_id', $request->input('order_id'))->delete();

            foreach($items as $item) {
                $new_item = new App\OrderItem;
    
                $new_item->order_id = $request->input('order_id');
                $new_item->session_product_id = $item->session_product_id;
                $new_item->qty = $item->qty;
                $new_item->price = $item->price;
    
                $new_item->save();
            }
        }
    } else {
        $error++;
        $message = 'No data received.';
    }

    return [
        'err' => $error,
        'msg' => $message,
    ];
});

Route::get('get-products', function() {
    return App\Product::all();
});

Route::post('add-session', function(Request $request) {
    // return $request->all();
    $error = 0;
    $message = '';

    if ($request->has('name') && $request->has('products') && !empty($request->input('products'))) {
        $products = json_decode($request->input('products'));

        $session = new App\Session;

        if ($request->has('id') && $request->input('id')) {
            $session = App\Session::find($request->input('id'));
        }

        $session->name = $request->input('name');
        $session->start_date = $request->input('start_date');
        $session->status = 0;

        $session->save();

        if (count($products)) {
            $products_exist = array_filter(collect($products)->pluck('id')->toArray());
            $products_to_delete = App\SessionProduct::whereNotIn('id', $products_exist)->where('session_id', $session->id)->get();

            #delete non used session product
            if (count($products_to_delete)) {
                foreach($products_to_delete as $prod) {
                    App\OrderItem::where('session_product_id', $prod->id)->delete();
                    $prod->delete();
                }
            }

            foreach($products as $product) {
                $sessionProduct = new App\SessionProduct;

                if ($product->id) {
                    $sessionProduct = App\SessionProduct::find($product->id);
                }
                
                $sessionProduct->session_id = $session->id;
                $sessionProduct->product_id = $product->product_id;
                $sessionProduct->quantity   = $product->qty;

                $sessionProduct->save();
            }
        } else {
            $error++;
            $message = 'Invalid entry.';
        }
    } else {
        $error++;
        $message = 'Invalid entry.';
    }

    return [
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('delete-session', function(Request $request) {
    // return $request->all();
    $error = 0;
    $message = '';

    if ($request->has('session_id')) {
        $deleted = App\Session::where('id', $request->input('session_id'))->delete();

        if ($deleted) {
            App\SessionProduct::where('session_id', $request->input('session_id'))->delete();

            $orders = App\Order::where('session_id', $request->input('session_id'))->get();
            
            if (count($orders)) {
                foreach ($orders as $order) {
                    App\OrderItem::where('order_id', $order->id)->delete();
                    $order->delete();
                }
            }

        } else {
            $error++;
            $message = 'Invalid session.';
        }
    } else {
        $error++;
        $message = 'No data received.';
    }
    
    return [
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('open-session', function(Request $request) {
    $error = 0;
    $message = '';

    if ($request->has('session_id') && $request->input('session_id')) {
        #check for open sessions
        $check = App\Session::where('status', 1)->get();

        if (!count($check)) {
            $session = App\Session::where('id', $request->input('session_id'))->first();
            $session->status = 1;
            $session->save();
        } else {
            $error++;
            $message = 'There are still open sessions found. Please close it to continue.';
        }
    } else {
        $error++;
        $message = 'Invalid session revieved.';
    }

    return [
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('close-session', function(Request $request) {
    $error = 0;
    $message = '';
    
    if ($request->has('session_id') && $request->input('session_id')) {
        $session = App\Session::where('id', $request->input('session_id'))->first();
        $session->status = 2;
        $session->end_date = date('Y-m-d');
        $session->save();
    } else {
        $error++;
        $message = 'Invalid session revieved.';
    }

    return [
        'err' => $error,
        'msg' => $message,
    ];
});