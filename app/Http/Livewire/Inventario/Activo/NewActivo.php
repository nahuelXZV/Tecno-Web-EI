<?php

namespace App\Http\Livewire\Inventario\Activo;

use App\Models\Activo;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewActivo extends Component
{
    use WithFileUploads;

    public $activoArray = [];
    public $notificacion = false;
    public $type = 'success';
    public $message = 'Creado correctamente';
    public $listeners = ['store' => 'save'];
    public $foto;

    // Constantes
    public $estados = ['Activo', 'Inactivo', 'En reparación', 'En mantenimiento', 'En desuso', 'En baja'];
    public $tipos = ["Mueble", "Equipo Electronico", "Material Oficina", "Otro"];

    public function mount()
    {
        $this->activoArray = [
            'codigo',
            'nombre',
            'descripcion',
            'unidad',
            'estado',
            'tipo',
            'dir',
        ];
    }

    public function save()
    {
        $url = Request::getScheme() . '://' . Request::getHost();
        $this->activoArray['dir'] =  $url . '/storage/' . $this->foto->store('public/activos', 'public');
        $new = Activo::CreateActivo($this->activoArray);
        if (!$new) {
            $this->message = 'Error al crear el activo';
            $this->type = 'error';
            $this->notificacion = true;
            return;
        }
        return redirect()->route('activo.list');
    }

    public function render()
    {
        return view('livewire.inventario.activo.new-activo');
    }
}
