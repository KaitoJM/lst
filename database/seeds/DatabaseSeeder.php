<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\ProductCategory;
use App\Product;
use App\Session as LstSession;
use App\SessionProduct;

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
                'password' => Hash::make('123123123'),
            ],
            [
                'fname' => 'Ma. Fatima',
                'lname' => 'Guinte',
                'email' => 'fatimaguinte@gmail.com',
                'password' => Hash::make('123123123'),
            ],
            [
                'fname' => 'Gerlyn',
                'lname' => 'Delantar',
                'email' => 'delantargerlyn12@gmail.com',
                'password' => Hash::make('123123123'),
            ],
            [
                'fname' => 'Ranie',
                'lname' => 'Monforte',
                'email' => 'ranie.nis@nwtf.org.ph',
                'password' => Hash::make('123123123'),
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

        $sessions = [
            [
                'name' => 'Fathers Day Special',
                'start_date' => '2020-06-20',
                'status' => 1
            ]
        ];

        foreach($sessions as $session) {
            LstSession::create($session);
        }

        $session_products = [
            [
                'session_id' => 1,
                'product_id' => 2,
                'quantity' => 18
            ],
            [
                'session_id' => 1,
                'product_id' => 3,
                'quantity' => 18
            ],
            [
                'session_id' => 1,
                'product_id' => 6,
                'quantity' => 10
            ],
            [
                'session_id' => 1,
                'product_id' => 7,
                'quantity' => 10
            ]
        ];

        foreach($session_products as $s_prod) {
            SessionProduct::create($s_prod);
        }
    }
}
