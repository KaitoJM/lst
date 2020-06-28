<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\ProductCategory;
use App\Product;
use App\Session as LstSession;
use App\SessionProduct;
use App\Customer;
use App\Order;
use App\OrderItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'fname' => 'John Mark',
                'lname' => 'Mancol',
                'email' => 'johnmarkmancol@gmail.com',
                'password' => md5('123123123'),
            ],
            [
                'fname' => 'Ma. Fatima',
                'lname' => 'Guinte',
                'email' => 'fatimaguinte@gmail.com',
                'password' => md5('123123123'),
            ],
            [
                'fname' => 'Gerlyn',
                'lname' => 'Delantar',
                'email' => 'delantargerlyn12@gmail.com',
                'password' => md5('123123123'),
            ],
            [
                'fname' => 'Ranie',
                'lname' => 'Monforte',
                'email' => 'ranie.nis@nwtf.org.ph',
                'password' => md5('123123123'),
            ],
        ];

        foreach($users as $user) {
            User::create($user);
        }

        $categores = [
            ['name' => 'Tapioca'],
            ['name' => 'Graham'],
        ];

        foreach($categores as $category) {
            ProductCategory::create($category);
        }

        $products = [
            [
                'name' => 'Mango Tapioca',
                'price' => 35,
                'category_id' => 1,
            ],
            [
                'name' => 'Choco Tapioca',
                'price' => 35,
                'category_id' => 1,
            ],
            [
                'name' => 'Ube Tapioca',
                'price' => 35,
                'category_id' => 1,
            ],
            [
                'name' => 'Strawberry Tapioca',
                'price' => 35,
                'category_id' => 1,
            ],
            [
                'name' => 'Mango Graham Float in a Cup',
                'price' => 45,
                'category_id' => 2,
            ],
            [
                'name' => 'Mango Ice Cream Roll',
                'price' => 65,
                'category_id' => 2,
            ],
            [
                'name' => 'Caramel Pudding',
                'price' => 50,
            ]
        ];

        foreach($products as $product) {
            Product::create($product);
        }

        // $sessions = [
        //     [
        //         'name' => 'Fathers Day Special',
        //         'start_date' => '2020-06-20',
        //         'status' => 1
        //     ]
        // ];

        // foreach($sessions as $session) {
        //     LstSession::create($session);
        // }

        // $session_products = [
        //     [ // choco
        //         'session_id' => 1,
        //         'product_id' => 2,
        //         'quantity' => 18
        //     ],
        //     [ // Ube
        //         'session_id' => 1,
        //         'product_id' => 3,
        //         'quantity' => 18
        //     ],
        //     [ // icecream roll
        //         'session_id' => 1,
        //         'product_id' => 6,
        //         'quantity' => 10
        //     ],
        //     [ // pudding
        //         'session_id' => 1,
        //         'product_id' => 7,
        //         'quantity' => 10
        //     ]
        // ];

        // foreach($session_products as $s_prod) {
        //     SessionProduct::create($s_prod);
        // }

        // $customers = [
        //     [ //1
        //         'fname' => 'Claire',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //2
        //         'fname' => 'Bryan',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //3
        //         'fname' => 'Roy joseph',
        //         'lname' => 'Argumedo',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //4
        //         'fname' => 'Alexandra',
        //         'lname' => 'Bernaldo',
        //         'email' => 'alexandrabernaldo@gmail.com',
        //         'gender' => 0
        //     ],
        //     [ //5
        //         'fname' => 'Bingbing',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //6
        //         'fname' => 'Marinelle',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //7
        //         'fname' => 'Mark Ryan',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //8
        //         'fname' => 'Ron',
        //         'lname' => 'Cano',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //9
        //         'fname' => 'Alfred',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //10
        //         'fname' => 'Generoso',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //11
        //         'fname' => 'Georgie',
        //         'lname' => 'Boii',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //12
        //         'fname' => 'Claud',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //13
        //         'fname' => 'Zeus',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //14
        //         'fname' => 'Fatima',
        //         'lname' => 'Tallo',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //15
        //         'fname' => 'Don don',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 1
        //     ],
        //     [ //16
        //         'fname' => 'Lara',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //17
        //         'fname' => 'Meca',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //18
        //         'fname' => 'Roda',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //19
        //         'fname' => 'Weng weng',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //20
        //         'fname' => 'Dianne',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //21
        //         'fname' => 'Deanna',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //22
        //         'fname' => 'Abegail',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //23
        //         'fname' => 'Anna',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //24
        //         'fname' => 'Mama ni Imang',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //25
        //         'fname' => 'Mic mic',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //26
        //         'fname' => 'Lady Anne',
        //         'lname' => '',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        //     [ //27
        //         'fname' => 'Anj',
        //         'lname' => 'Calimbo',
        //         'email' => '',
        //         'gender' => 0
        //     ],
        // ];

        // foreach($customers as $customer) {
        //     Customer::create($customer);
        // }

        // $orders = [
        //     //Choco Tapioca
        //     [ // 1
        //         'session_id' => 1,
        //         'customer_id' => 1,
        //         'status' => 0,
        //         'author_id' => 4
        //     ],
        //     [ // 2
        //         'session_id' => 1,
        //         'customer_id' => 2,
        //         'status' => 0,
        //         'author_id' => 2
        //     ],
        //     [ // 3
        //         'session_id' => 1,
        //         'customer_id' => 3,
        //         'status' => 0,
        //         'author_id' => 4
        //     ],
        //     [ // 4
        //         'session_id' => 1,
        //         'customer_id' => 4,
        //         'status' => 0,
        //         'author_id' => 1
        //     ],
        //     [ // 5
        //         'session_id' => 1,
        //         'customer_id' => 5,
        //         'status' => 0,
        //         'author_id' => 2
        //     ],
        //     [ // 6
        //         'session_id' => 1,
        //         'customer_id' => 6,
        //         'status' => 0,
        //         'author_id' => 4
        //     ],
        //     [ // 7
        //         'session_id' => 1,
        //         'customer_id' => 8,
        //         'status' => 0,
        //         'author_id' => 1
        //     ],
        //     [ // 8
        //         'session_id' => 1,
        //         'customer_id' => 9,
        //         'status' => 0,
        //         'author_id' => 1
        //     ],
        //     [ // 9
        //         'session_id' => 1,
        //         'customer_id' => 10,
        //         'status' => 0,
        //         'author_id' => 1
        //     ],
        //     [ // 10
        //         'session_id' => 1,
        //         'customer_id' => 7,
        //         'status' => 0,
        //         'author_id' => 1
        //     ],
        //     [ // 11
        //         'session_id' => 1,
        //         'customer_id' => 11,
        //         'status' => 0,
        //         'author_id' => 1
        //     ],
        //     [ // 12
        //         'session_id' => 1,
        //         'customer_id' => 12,
        //         'status' => 0,
        //         'author_id' => 1
        //     ],
        //     [ // 13
        //         'session_id' => 1,
        //         'customer_id' => 14,
        //         'status' => 0,
        //         'author_id' => 3
        //     ],
        //     [ // 14
        //         'session_id' => 1,
        //         'customer_id' => 15,
        //         'status' => 0,
        //         'author_id' => 2
        //     ],
        //     // Ube
        //     [ // 15
        //         'session_id' => 1,
        //         'customer_id' => 16,
        //         'status' => 0,
        //         'author_id' => 2
        //     ],
        //     [ // 16
        //         'session_id' => 1,
        //         'customer_id' => 17,
        //         'status' => 0,
        //         'author_id' => 4
        //     ],
        //     [ // 17
        //         'session_id' => 1,
        //         'customer_id' => 18,
        //         'status' => 0,
        //         'author_id' => 4
        //     ],
        //     [ // 18
        //         'session_id' => 1,
        //         'customer_id' => 19,
        //         'status' => 0,
        //         'author_id' => 3
        //     ],
        //     [ // 19
        //         'session_id' => 1,
        //         'customer_id' => 20,
        //         'status' => 0,
        //         'author_id' => 4
        //     ],
        //     [ // 20
        //         'session_id' => 1,
        //         'customer_id' => 21,
        //         'status' => 0,
        //         'author_id' => 4
        //     ],
        //     //Pudding
        //     [ // 21
        //         'session_id' => 1,
        //         'customer_id' => 22,
        //         'status' => 0,
        //         'author_id' => 3
        //     ],
        //     [ // 22
        //         'session_id' => 1,
        //         'customer_id' => 23,
        //         'status' => 0,
        //         'author_id' => 3
        //     ],
        //     [ // 23
        //         'session_id' => 1,
        //         'customer_id' => 24,
        //         'status' => 0,
        //         'author_id' => 2
        //     ],
        //     [ // 24
        //         'session_id' => 1,
        //         'customer_id' => 25,
        //         'status' => 0,
        //         'author_id' => 3
        //     ],
        //     [ // 25
        //         'session_id' => 1,
        //         'customer_id' => 26,
        //         'status' => 0,
        //         'author_id' => 2
        //     ],
        //     [ // 26
        //         'session_id' => 1,
        //         'customer_id' => 27,
        //         'status' => 0,
        //         'author_id' => 3
        //     ],
        // ];

        // foreach($orders as $order) {
        //     Order::create($order);
        // }

        // $order_items = [
        //     [
        //         'order_id' => 1,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 2,
        //         'session_product_id' => 1,
        //         'qty' => 3,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 2,
        //         'session_product_id' => 2,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 3,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 3,
        //         'session_product_id' => 2,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 4,
        //         'session_product_id' => 1,
        //         'qty' => 3,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 4,
        //         'session_product_id' => 2,
        //         'qty' => 2,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 4,
        //         'session_product_id' => 3,
        //         'qty' => 2,
        //         'price' => 65
        //     ],
        //     [
        //         'order_id' => 5,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 5,
        //         'session_product_id' => 2,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 6,
        //         'session_product_id' => 1,
        //         'qty' => 2,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 6,
        //         'session_product_id' => 2,
        //         'qty' => 2,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 7,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 8,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 9,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 10,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 10,
        //         'session_product_id' => 3,
        //         'qty' => 1,
        //         'price' => 65
        //     ],
        //     [
        //         'order_id' => 11,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 12,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 13,
        //         'session_product_id' => 1,
        //         'qty' => 2,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 13,
        //         'session_product_id' => 4,
        //         'qty' => 1,
        //         'price' => 50
        //     ],
        //     [
        //         'order_id' => 13,
        //         'session_product_id' => 3,
        //         'qty' => 1,
        //         'price' => 65   
        //     ],
        //     [
        //         'order_id' => 14,
        //         'session_product_id' => 1,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 15,
        //         'session_product_id' => 2,
        //         'qty' => 2,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 16,
        //         'session_product_id' => 2,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 17,
        //         'session_product_id' => 2,
        //         'qty' => 3,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 18,
        //         'session_product_id' => 2,
        //         'qty' => 1,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 19,
        //         'session_product_id' => 2,
        //         'qty' => 3,
        //         'price' => 35
        //     ],
        //     [
        //         'order_id' => 21,
        //         'session_product_id' => 4,
        //         'qty' => 1,
        //         'price' => 50
        //     ],
        //     [
        //         'order_id' => 22,
        //         'session_product_id' => 4,
        //         'qty' => 1,
        //         'price' => 50
        //     ],
        //     [
        //         'order_id' => 23,
        //         'session_product_id' => 4,
        //         'qty' => 1,
        //         'price' => 50
        //     ],
        //     [
        //         'order_id' => 24,
        //         'session_product_id' => 4,
        //         'qty' => 2,
        //         'price' => 50
        //     ],
        //     [
        //         'order_id' => 24,
        //         'session_product_id' => 3,
        //         'qty' => 1,
        //         'price' => 65
        //     ],
        //     [
        //         'order_id' => 25,
        //         'session_product_id' => 4,
        //         'qty' => 1,
        //         'price' => 50
        //     ],
        //     [
        //         'order_id' => 26,
        //         'session_product_id' => 3,
        //         'qty' => 1,
        //         'price' => 65
        //     ],
        //     [
        //         'order_id' => 20,
        //         'session_product_id' => 3,
        //         'qty' => 1,
        //         'price' => 65
        //     ],
            
        // ];
        
        // foreach($order_items as $item) {
        //     OrderItem::create($item);
        // }
    }
}
