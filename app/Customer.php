<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'company', 'name', 'phone', 'mobile', 'address', 'notes', 'balance', 'user_id'
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function payments()
    {
        return $this->hasMany('App\CustomerPayment');
    }

    public function updateBalance() {

        $this->balance = $this->orders()->sum('cost');
        $this->balance -= $this->payments()->sum('amount');

        $this->save();

        return $this->balance;
    }
}
