<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mapa;
use Livewire\Attributes\Layout;

class Vermapas extends Component
{
    public $datos;

    public function mount(Mapa $slug)
    {
        $this->datos = $slug;
    }

    public function render()
    {        
        $info = $this->datos;
        
        return view('livewire.vermapas',[
            'info' => $info,
        ]);
    }
}
