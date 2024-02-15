<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pagamento extends Model
{
    use HasFactory;

    public function compra(): HasOne
    {
        return $this->hasOne(Compra::class);
    }
}
