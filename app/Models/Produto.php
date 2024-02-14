<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'descricao',
        'marca',
        'cor',
        'preco',
        'peso',
        'estoque',
        'categoria_id',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    // public function carrinhos(): BelongsToMany
    // {
    //     return $this->belongsToMany(Carrinho::class, 'item_carrinho')->withPivot('preco_total', 'qnt', 'preco_unitario');
    // }

    public function promocoes(): BelongsToMany
    {
        return $this->belongsToMany(Promocao::class, 'produto_promocao');
    }

}
