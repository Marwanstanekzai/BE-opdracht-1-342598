<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    protected $table = 'Contact';

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public $timestamps = false;

    /**
     * Relatie naar de bijbehorende leverancier.
     */
    public function leverancier(): HasOne
    {
        return $this->hasOne(
            Leverancier::class,
            'ContactId',
            'Id'
        );
    }
}
