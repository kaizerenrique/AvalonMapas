<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gremio extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_albion_gremio',
        'nombre_gremio',
    ];

    /**
    * Relación con tabla de Escondite.
    *  
    */
    public function escondites()
    {
        return $this->hasMany(Escondite::class);
    }
}
