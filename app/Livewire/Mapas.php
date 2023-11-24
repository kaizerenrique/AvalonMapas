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
    public $confirmarEliminarMapa = false;  
    public $buscar;
    public $name, $nivel, $tipo, $inicio, $fin, $visible;
    public $imagen;
    public $mensajemapa, $idmapa;

    protected function rules()
    {
        if ($modalAgregar = true) {
            return [
                'name' => 'required|string|min:4|max:30|unique:mapas,name',
                'nivel' => 'required|in:4,5,6,7,8',
                'tipo' => 'required|in:Cruce,Corredor,Santuario,Descanso',
                'imagen' => 'nullable|image|max:12288',
                'inicio' => 'string',
                'fin' => 'string',
                'visible' => 'boolean',
            ];
        }        
    }

    protected $queryString = [
        'buscar' => ['except' => '']
    ];

    public function render()
    {

        $mapas = Mapa::where('name', 'like', '%'.$this->buscar . '%')  //buscar por nombre                           
                            ->orderBy('id','desc') //ordenar de forma decendente
                            ->paginate(8); //paginacion

        return view('livewire.mapas',[
            'mapas' => $mapas
        ]);
    }

    /**
     * Despliega el modal para agregar 
     * un mapa
     */
    public function agregarmapa()
    {
        $this->reset(['name']);
        $this->reset(['nivel']);
        $this->reset(['tipo']); 
        $this->reset(['imagen']);  
        $this->reset(['inicio']);
        $this->reset(['fin']); 
        $this->visible = true;          
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
            'inicio' => $this->inicio,
            'fin' => $this->fin,
            'visible' => $this->visible,
        ]);        
         
        $this->modalAgregar = false;

        if ($this->tipo == 'Descanso' ) {
            $this->redirectRoute('detallesmapas', $game);    
        } else {
            session()->flash('message', 'El Mapa ha sido registrado correctamente.');
        }
        
         
    }

    /**
     * Consultar si se borrara el Mapa 
     * 
     */
    public function consultarborrarmapa($id)
    {
        $ma = Mapa::find($id);
        $this->mensajemapa = $ma->name;
        $this->idmapa = $ma->id;
        $this->confirmarEliminarMapa = true;
    }

    /**
    * Borrar el Mapa 
    * 
    */
    public function borrarmapa( $id)
    {
        $mapa = Mapa::find($id);
        $this->confirmarEliminarMapa = false;
        session()->flash('message', 'Se a eliminado correctamente el Mapa: '.$mapa->name);
        
        if(!empty($mapa->foto_mapa)){
            $url = str_replace('storage','public',$mapa->foto_mapa);
            Storage::delete($url);
        }                

        $mapa->delete(); 
    }   
}
