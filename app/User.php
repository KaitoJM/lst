<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function orders() {
        return $this->hasMany('App\Order', 'author_id');
    }

    public function transactions() {
        return $this->hasMany('App\Transaction', 'from');
    }
}
