<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Mapa;

class Mapas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $modalAgregar = false;  
    public $categoria;
    public $imagen;

    protected $queryString = [
        'buscar' => ['except' => '']
    ];

    public function render()
    {

        //$mapas_avalon = Mapa::where('name', 'like', '%'.$this->buscar . '%')  //buscar por nombre                           
        //                    ->orderBy('id','desc') //ordenar de forma decendente
        //                    ->paginate(10); //paginacion

        return view('livewire.mapas');
    }

    /**
     * Despliega el modal para agregar 
     * un mapa
     */
    public function agregarmapa()
    {        
        $this->modalAgregar = true;
    }
}
