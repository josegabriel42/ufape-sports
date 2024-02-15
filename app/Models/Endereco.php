<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado',
        'cidade',
        'bairro',
        'logradouro',
        'cep',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
