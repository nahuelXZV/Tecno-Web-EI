<?php

namespace App\Http\Livewire\Academico\Prospecto;

use App\Models\Pagina;
use App\Models\Prospecto;
use Livewire\Component;

class NewProspecto extends Component
{
    public $prospectoArray = [];
    public $notificacion = false;
    public $type = 'success';
    public $message = 'Creado correctamente';
    public $listeners = ['store' => 'save'];

    public function mount()
    {
        Pagina::UpdateVisita('prospecto.new');
        $this->prospectoArray = [
            'nombre',
            'telefono',
            'correo',
            'interes',
            'carrera',
            'estado' => "Pendiente",
            'detalles',
        ];
    }

    public function save()
    {
        $new = Prospecto::CreateProspecto($this->prospectoArray);
        if (!$new) {
            $this->message = 'Error al crear el prospecto';
            $this->type = 'error';
            $this->notificacion = true;
            return;
        }
        return redirect()->route('prospecto.list');
    }

    public function render()
    {
        $visitas = Pagina::GetPagina('prospecto.new');
        return view('livewire.academico.prospecto.new-prospecto', compact('visitas'))->layout(auth()->user()->tema);
    }
}
