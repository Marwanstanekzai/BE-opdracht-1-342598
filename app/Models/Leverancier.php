<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'leverancier';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public function producten()
    {
        return $this->belongsToMany(
            Product::class,
            'productperleverancier',
            'LeverancierId',
            'ProductId'
        );
    }
}
