<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\CartFactory::new();
    }
}
