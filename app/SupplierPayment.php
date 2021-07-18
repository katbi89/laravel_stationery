<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPayment extends Model
{
    use SoftDeletes;

    protected $table = 'supplier_payments';

    protected $fillable = [
        'amount', 'date', 'time', 'notes', 'supplier_id',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
