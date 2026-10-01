<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazijn extends Model
{
    protected $table = 'Magazijn';

    protected $primaryKey = 'Id';

    protected $guarded = [];

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
