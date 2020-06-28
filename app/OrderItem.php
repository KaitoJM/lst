<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function session_product() {
        return $this->hasOne('App\SessionProduct', 'id', 'session_product_id');
    }

    public function order() {
        return $this->belongsTo('App\Order');
    }
}
