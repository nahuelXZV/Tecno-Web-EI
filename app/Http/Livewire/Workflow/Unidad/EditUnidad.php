<?php

namespace App\Http\Livewire\Workflow\Unidad;

use App\Models\Pagina;
use App\Models\Unidad;
use Livewire\Component;

class EditUnidad extends Component
{
    public $unidadArray = [];
    public $notificacion = false;
    public $type = 'success';
    public $message = 'Creado correctamente';
    public $listeners = ['store' => 'save'];

    // Data
    public $unidad;

    public function mount(Unidad $unidad)
    {
        Pagina::UpdateVisita('unidad.edit');
        $this->unidad = $unidad;
        $this->unidadArray = [
            'nombre' => $unidad->nombre,
        ];
    }

    public function save()
    {
        $new = Unidad::UpdateUnidad($this->unidad, $this->unidadArray);
        if (!$new) {
            $this->message = 'Error al actualizar la unidad';
            $this->type = 'error';
            $this->notificacion = true;
            return;
        }
        return redirect()->route('unidad.list');
    }

    public function render()
    {
        $visitas = Pagina::GetPagina('unidad.edit');
        return view('livewire.workflow.unidad.edit-unidad', compact('visitas'))->layout(auth()->user()->tema);
    }
}
