<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'Leverancier';

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public $timestamps = false;

    public function producten()
    {
        return $this->belongsToMany(
            Product::class,
            'ProductPerLeverancier',
            'LeverancierId',
            'ProductId'
        );
    }
}
