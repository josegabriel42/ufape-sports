<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_titular',
        'data_vencimento_cartao',
        'numero_cartao',
        'cod_seguranca',
        'endereco_entrega',
    ];

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class);
    }
}
