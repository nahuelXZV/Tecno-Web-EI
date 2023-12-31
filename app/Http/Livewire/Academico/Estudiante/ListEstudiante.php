<?php

namespace App\Http\Livewire\Academico\Estudiante;

use App\Models\Estudiante;
use App\Models\Pagina;
use Livewire\Component;
use Livewire\WithPagination;

class ListEstudiante extends Component
{
    use WithPagination;
    public $search = '';
    public $notificacion = false;
    public $type = 'success';
    public $message = 'Creado correctamente';

    public function mount()
    {
        Pagina::UpdateVisita('estudiante.list');
    }

    public function toggleNotificacion()
    {
        $this->notificacion = !$this->notificacion;
        $this->emit('notificacion');
    }

    //Metodo de reinicio de buscador
    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $estudiante = Estudiante::GetEstudiante($id);
        if (Estudiante::DeleteEstudiante($estudiante)) {
            $this->message = 'Eliminado correctamente';
            $this->type = 'success';
        } else {
            $this->message = 'Error al eliminar';
            $this->type = 'error';
        }
        $this->notificacion = true;
    }

    public function render()
    {
        $estudiantes = Estudiante::GetAllSearch($this->search, 'DESC', 10);
        $visitas = Pagina::GetPagina('estudiante.list');
        return view('livewire.academico.estudiante.list-estudiante', compact('estudiantes', 'visitas'))->layout(auth()->user()->tema);
    }
}
