<?php

namespace App\Http\Livewire\Inventario\Inventario;

use App\Models\Inventario;
use App\Models\Pagina;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewInventario extends Component
{
    use WithFileUploads;

    public $inventarioArray = [];
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
        Pagina::UpdateVisita('inventario.new');
        $this->inventarioArray = [
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
        $this->inventarioArray['dir'] =  $url . '/inf513/grupo06sa/Tecno-Web-EI/public/storage/' . $this->foto->store('public/inventario', 'public');
        $new = Inventario::CreateInventario($this->inventarioArray);
        if (!$new) {
            $this->message = 'Error al crear el inventario';
            $this->type = 'error';
            $this->notificacion = true;
            return;
        }
        return redirect()->route('inventario.list');
    }

    public function render()
    {
        $visitas = Pagina::GetPagina('inventario.new');
        return view('livewire.inventario.inventario.new-inventario', compact('visitas'))->layout(auth()->user()->tema);
    }
}
