<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Product';

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public $timestamps = false;

    public function magazijn()
    {
        return $this->hasOne(Magazijn::class, 'ProductId', 'Id');
    }

    public function allergenen()
    {
        return $this->belongsToMany(
            Allergeen::class,
            'ProductPerAllergeen',
            'ProductId',
            'AllergeenId'
        );
    }

    public function leveranciers()
    {
        return $this->belongsToMany(
            Leverancier::class,
            'ProductPerLeverancier',
            'ProductId',
            'LeverancierId'
        );
    }
}
