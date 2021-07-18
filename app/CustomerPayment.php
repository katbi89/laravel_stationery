<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPayment extends Model
{
    use SoftDeletes;

    protected $table = 'customer_payments';

    protected $fillable = [
        'amount', 'date', 'time', 'notes', 'customer_id',
    ];


    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
