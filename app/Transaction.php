<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $appends = ['transaction_date'];

    public function getTransactionDateAttribute() {
        return date('M. d, Y', strtotime($this->created_at));
    }
}
