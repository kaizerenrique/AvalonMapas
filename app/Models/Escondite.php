<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escondite extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo',
        'gremio_id',
        'mapa_id'
    ];

    public function gremio(){
        return $this->belongsTo(Gremio::class);
    }

    public function mapa(){
        return $this->belongsTo(Mapa::class);
    }
}
