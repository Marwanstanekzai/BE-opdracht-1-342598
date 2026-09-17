<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public function magazijn()
    {
        return $this->hasOne(Magazijn::class, 'ProductId', 'Id');
    }

    public function allergenen()
    {
        return $this->belongsToMany(
            Allergeen::class,
            'productperallergeen',
            'ProductId',
            'AllergeenId'
        );
    }

    public function leveranciers()
    {
        return $this->belongsToMany(
            Leverancier::class,
            'productperleverancier',
            'ProductId',
            'LeverancierId'
        );
    }
}
