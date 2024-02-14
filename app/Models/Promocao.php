<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promocao extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'promocoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'descricao',
        'percentagem',
        'data_inicio',
        'data_fim',
    ];

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'produto_promocao');
    }

}
