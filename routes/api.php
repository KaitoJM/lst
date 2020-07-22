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
        $sess_prod->with('product', 'orderItems');
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
                'expense' => $session->expense,
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
                        'status' => $order->status,
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
                        'qty' => $product->quantity,
                        'total_order_qty_ordered' => $product->orderItems->sum('qty'), //total product reserve/ordered in a session
                        'total_order_qty_paid' => 0, //total product paid in a session
                        'total_order_amount' => $product->quantity * $product->product->price, //total product amount in a session
                        'total_order_ordered' => $product->orderItems->sum('qty') * $product->product->price, //total product amount ordered in a session
                        'total_order_paid' => 0, //total product amount paid in a session
                    ];
                })
            ];
        });
    } else {
        $formatted = [
            'id' => $session->id,
            'start_date' => $session->start_date,
            'end_date' => $session->end_date,
            'expense' => $session->expense,
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
                    'status' => $order->status,
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
                    'qty' => $product->quantity,
                    'total_order_qty_ordered' => $product->orderItems->sum('qty'), //total product reserve/ordered in a session
                    'total_order_qty_paid' => 0, //total product paid in a session
                    'total_order_amount' => $product->quantity * $product->product->price, //total product amount in a session
                    'total_order_ordered' => $product->orderItems->sum('qty') * $product->product->price, //total product amount ordered in a session
                    'total_order_paid' => 0, //total product amount paid in a session
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
        $session->expense = (float)$request->input('expense');
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

Route::post('pay-order', function(Request $request) {
    $error = 0;
    $message = '';

    if ($request->has('order_id') && $request->input('order_id')) {
        $order = App\Order::find($request->input('order_id'));
        $order->status = 1;
        $save = $order->save();

        if (!$save) {
            $error++;
            $message = 'This order was already paid.';
        }
    } else {
        $error++;
        $message = 'Invalid order.';
    }
    
    return [
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('unpay-order', function(Request $request) {
    $error = 0;
    $message = '';

    if ($request->has('order_id') && $request->input('order_id')) {
        $order = App\Order::find($request->input('order_id'));
        $order->status = 0;
        $save = $order->save();

        if (!$save) {
            $error++;
            $message = 'This order was already paid.';
        }
    } else {
        $error++;
        $message = 'Invalid order.';
    }
    
    return [
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('get-session-by-product', function(Request $request) {
    $session = null;
    $error = 0;
    $message = '';

    if ($request->has('session_id') && $request->input('session_id')) {
        $session = App\Session::with(['products' => function($p) use ($request) {
            $p->with('product')->with(['orderItems' => function($item) use ($request){
                $item->with(['order' => function($order) {
                    $order->with('customer');
                }]);

                if ($request->has('user_id') && $request->input('user_id')) {
                    $item->whereHas('order', function($order) use ($request) {
                        $order->where('author_id', $request->input('user_id'));
                    });
                }
            }]);
        }])->where('id', $request->input('session_id'))->first();
       
        if (!$session) {
            $error++;
            $message = 'No result.';
        }
    } else {
        $error++;
        $message = 'Invalid order.';
    }

    return [
        'session' => $session,
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('login', function(Request $request) {
    $user = null;
    $error = 0;
    $message = '';

    if ($request->has('username') && $request->input('username') && $request->has('password') && $request->input('password')) {
        $check = App\User::where('email', $request->input('username'))
            ->where('password', md5($request->input('password'))
        )->first();
        
        if ($check) {
            $user = $check;
        } else {
            $error++;
            $message = 'Invalid user. Try again.';
        }
    } else {
        $error++;
        $message = 'Invalid user. Try again.';
    }

    return [
        'user' => $user,
        'err' => $error,
        'msg' => $message,
    ];
});

Route::get('deliveries', function() {
    $deliveries = [];
    $error = 0;
    $message = '';

    $check_session = App\Session::where('status', 1)->first();

    if ($check_session) {
        $session = $check_session;

        $users = App\User::all();

        if (count($users)) {
            foreach($users as $user) {
                $session = App\Session::with(['products' => function($p) use ($user) {
                    $p->with('product')->with(['orderItems' => function($item) use ($user){
                        $item->with(['order' => function($order) {
                            $order->with('customer');
                        }]);
        
                        $item->whereHas('order', function($order) use ($user) {
                            $order->where('author_id', $user->id);
                        });
                    }]);
                }])->where('id', $session->id)->first();

                array_push($deliveries, ['session' => $session, 'user' => $user]);
            }
        } else {
            $error++;
            $message = 'There are no users yet.';
        }
    } else {
        $error++;
        $message = 'There are no active sessions yet.';
    }

    return [
        'deliveries' => $deliveries,
        'err' => $error,
        'msg' => $message,
    ];
});

Route::get('transactions', function(Request $request) {
    $users = App\User::with(['orders' => function($order) use ($request) {
        $order->where('session_id', $request->input('session_id'));
        $order->with(['items' => function($item) {
            $item->with(['session_product' => function($session_product) {
                $session_product->with('product');
            }]);
        }]);
    }])->whereHas('orders', function($order) use ($request){
        $order->where('session_id', $request->input('session_id'));
    })->with(['transactions' => function($transaction) use ($request) {
        $transaction->where('session_id', $request->input('session_id'))->where('cash_direction', 'cash-in');
    }])->get();
    
    return $users;
});

Route::post('add-transaction', function(Request $request) {
    $id = 0;
    $date = '';
    $error = 0;
    $message = '';

    if (($request->has('user_id') && $request->input('user_id')) && ($request->has('session_id') && $request->input('session_id'))) {
        $transaction = new App\Transaction();

        $type = $request->input('type');

        $transaction->session_id = $request->input('session_id');
        $transaction->from = $request->input('user_id');
        $transaction->amount = $request->input('amount');

        if ($type == 'true') {
            $transaction->payment_type = 'bank';
        }

        $save = $transaction->save();

        if (!$save) {
            $error++;
            $message = 'Error while saving transaction. Please Try again.';
        } else {
            $id = $transaction->id;
            $date = date('M. d, Y', strtotime($transaction->created_at));

            $money_update = App\Money::find(1);
            if ($type) {
                $money_update->cash_on_bank =  (float) $money_update->cash_on_bank + (float) $transaction->amount;
            } else {
                $money_update->cash_on_hand =  (float) $money_update->cash_on_hand + (float) $transaction->amount;
            }
            $money_update->save();
        }
    } else {
        $error++;
        $message = 'Invalid Transaction.';
    }
    
    return [
        'id' => $id,
        'date' => $date,
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('remove-transaction', function(Request $request) {
    $error = 0;
    $message = '';

    if ($request->has('transaction_id') && $request->input('transaction_id')) {
        $transaction = App\Transaction::find($request->input('transaction_id'));

        $amount = $transaction->amount;
        $type = $transaction->payment_type;

        $del = $transaction->delete();

        if (!$del) {
            $error++;
            $message = 'Error while removing transaction. Please Try again.';
        } else {
            $money_update = App\Money::find(1);

            if ($type == 'bank') {
                $money_update->cash_on_bank =  (float) $money_update->cash_on_bank - (float) $amount;
            } else {
                $money_update->cash_on_hand =  (float) $money_update->cash_on_hand - (float) $amount;
            }

            $money_update->save();
        }
    } else {
        $error++;
        $message = 'Invalid Transaction.';
    }
    
    return [
        'err' => $error,
        'msg' => $message,
    ];
});

Route::post('transaction', function(Request $request) {
    $error = 0;
    $message = '';

    if ($request->has('amount') && $request->input('amount')) {
        $ins = new App\Transaction();

        if ($request->has('payment_type')) {
            $ins->payment_type = $request->input('payment_type');
        }

        if ($request->has('cash_direction')) {
            $ins->cash_direction = $request->input('cash_direction');
        }

        $ins->session_id = 0;
        $ins->from = 0;
        $ins->amount = $request->input('amount');
        $inserted = $ins->save();

        if ($inserted) {
            $money_update = App\Money::find(1);

            if ($ins->payment_type == 'cash') {
                if ($ins->cash_direction == 'cash-in') {
                    $money_update->cash_on_hand =  (float) $money_update->cash_on_hand + (float) $ins->amount;
                } else {
                    $money_update->cash_on_hand =  (float) $money_update->cash_on_hand - (float) $ins->amount;
                }
            } else {
                if ($ins->cash_direction == 'cash-in') {
                    $money_update->cash_on_bank =  (float) $money_update->cash_on_bank + (float) $ins->amount;
                } else {
                    $money_update->cash_on_bank =  (float) $money_update->cash_on_bank - (float) $ins->amount;
                }
            }

            $money_update->save();
        } else {
            $error++;
            $message = 'Error while saving transaction';
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

Route::get('get-money', function(Request $request) {
    return App\Money::find(1);
});

Route::get('get-money-transactions', function(Request $request) {
    $transactions = [];
    $transaction_type = null;

    if ($request->has('transaction_type') && $request->input('transaction_type')) {
        $transaction_type = $request->input('transaction_type');
    }

    $transaction_obj = App\Transaction::orderBy('created_at', 'DESC');

    if ($transaction_type) {
        $transaction_obj->where('cash_direction', $transaction_type);
    }
    
    $transactions = $transaction_obj->get();

    return $transactions;
});