<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazijn extends Model
{
    protected $table = 'magazijn';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'ProductId',
            'Id'
        );
    }
}
