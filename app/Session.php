<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function orders() {
        return $this->hasMany('App\Order');
    }

    public function products() {
        return $this->hasMany('App\SessionProduct');
    }

}
