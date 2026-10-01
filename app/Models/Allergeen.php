<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergeen extends Model
{
    protected $table = 'Allergeen';

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public $timestamps = false;

    public function producten()
    {
        return $this->belongsToMany(
            Product::class,
            'ProductPerAllergeen',
            'AllergeenId',
            'ProductId'
        );
    }
}
