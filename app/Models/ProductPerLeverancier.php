<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPerLeverancier extends Model
{
    protected $table = 'productperleverancier';

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

    public function leverancier()
    {
        return $this->belongsTo(
            Leverancier::class,
            'LeverancierId',
            'Id'
        );
    }
}
