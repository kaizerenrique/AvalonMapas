<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mapa;
use Livewire\Attributes\Layout;
use App\Models\Gremio;
use App\Models\Escondite;
use \App\Traits\AlbionOnline\GremioInfo;

class Detallesmapas extends Component
{
    use GremioInfo;

    public $datos;
    public $modalAgregar = false;
    public $buscar;
    public $identificador;
    public $modalGremio = false;
    public $id_gremio, $nombre_gremio, $alianza_gremio, $miembros_gremio, $escondite;

    public function mount(Mapa $slug)
    {
        $this->datos = $slug;
    }

    protected $queryString = [
        'buscar' => ['except' => '']
    ];

    protected function rules()
    {
        if ($modalGremio = true) {
            return [
                'id_gremio' => 'required|string',
                'nombre_gremio' => 'required|string',
                'escondite' => 'required|in:HO,HQ',
            ];
        }           
    }

    public function render()
    {
        $info = $this->datos;

        //$gremios = Gremio::where('nombre_gremio', 'like', '%'.$this->buscar . '%')  //buscar por nombre                           
        //                    ->orderBy('id','desc') //ordenar de forma decendente
        //                    ->paginate(8); //paginacion

        $gremios = $this->consultar($this->buscar);

        return view('livewire.detallesmapas',[
            'info' => $info,
            'gremios' => $gremios,
        ]);
    }

    /**
     * Despliega el modal para agregar 
     * un escondite
     */
    public function modalgremio()
    {                 
        $this->modalAgregar = true;
    }

    public function detallesdegremio($identificador)
    {
        $this->modalAgregar = false;
        $informacion = $this->consultargremio($identificador);

        $this->id_gremio = $informacion->guild->Id;
        $this->nombre_gremio = $informacion->guild->Name;
        $this->alianza_gremio = $informacion->guild->AllianceTag;
        $this->miembros_gremio = $informacion->basic->memberCount;

        $this->modalGremio = true;
    }

    public function guardarescondite()
    {
        $this->validate();

        $evalua = Gremio::where('id_albion_gremio', $this->id_gremio)->exists();

        if ($evalua == false) {
            $gremio = Gremio::create([
                'id_albion_gremio' => $this->id_gremio,
                'nombre_gremio' => $this->nombre_gremio,
            ])->escondites()->create([
                'tipo' => $this->escondite,
                'mapa_id' => $this->datos->id
            ]);
            
            session()->flash('message', 'El Escondite ha sido registrado correctamente.');
        } else {
            $orden = Gremio::where('id_albion_gremio', $this->id_gremio)->first();

            $resultado = $this->datos->escondites();
            
            Escondite::create([
                'tipo' => $this->escondite,
                'gremio_id' => $orden->id,
                'mapa_id' => $this->datos->id
            ]);

            session()->flash('message', 'El Escondite ha sido registrado correctamente.');
        }

        $this->modalGremio = false;
    }
    
}
