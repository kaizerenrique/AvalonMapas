<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Mapa;
use App\Models\User;


class Mapas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $modalAgregar = false;  
    public $buscar;
    public $name, $nivel, $tipo;
    public $imagen;

    protected function rules()
    {
        if ($modalAgregar = true) {
            return [
                'name' => 'required|string|min:4|max:30|unique:mapas,name',
                'nivel' => 'required|in:4,5,6,7,8',
                'tipo' => 'required|in:Cruce,Corredor,Santuario,Descanso',
                'imagen' => 'nullable|image|max:2048',
            ];
        }        
    }

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

     /**
     * Guardar el Mapa 
     * 
     */
    public function guardarmapa()
    {   
        $this->validate();

        $str = strtolower($this->name);
        $game = preg_replace('/\s+/', '-', $str);
        $codigo = Str::random(6); 
        $game = $game.'-'.$codigo;

        //almacenar imagen
        if (!empty($this->imagen)){
            $imagen = $this->imagen->store('public/mapas');
            $imagen_ruta = Storage::url($imagen);
        } else {
            $imagen_ruta = null;            
        }

        $mapa = auth()->user()->mapas()->create([
            'name'=> $this->name,
            'nivel' => $this->nivel,
            'tipo' => $this->tipo,
            'slug' => $game,
            'foto_mapa' => $imagen_ruta,
        ]);        
         
        $this->modalAgregar = false;
        session()->flash('message', 'La categoría se a creado correctamente'); 
    }
}
