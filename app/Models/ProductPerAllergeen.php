<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPerAllergeen extends Model
{
    protected $table = 'productperallergeen';

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

    public function allergeen()
    {
        return $this->belongsTo(
            Allergeen::class,
            'AllergeenId',
            'Id'
        );
    }
}
