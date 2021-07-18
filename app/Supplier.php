<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'suppliers';

    protected $fillable = [
        'company', 'name', 'phone', 'mobile', 'address', 'notes', 'balance'
    ];

    public function bills()
    {
        return $this->hasMany('App\Bill');
    }

    public function payments()
    {
        return $this->hasMany('App\SupplierPayment');
    }

    public function updateBalance() {

        $this->balance = $this->bills()->sum('cost');
        $this->balance -= $this->payments()->sum('amount');

        $this->save();

        return $this->balance;
    }
}
