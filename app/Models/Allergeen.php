<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergeen extends Model
{
    protected $table = 'allergeen';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public function producten()
    {
        return $this->belongsToMany(
            Product::class,
            'productperallergeen',
            'AllergeenId',
            'ProductId'
        );
    }
}
