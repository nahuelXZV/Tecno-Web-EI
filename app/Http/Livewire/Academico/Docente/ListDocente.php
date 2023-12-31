<?php

namespace App\Http\Livewire\Academico\Docente;

use App\Models\Docente;
use App\Models\Pagina;
use Livewire\Component;
use Livewire\WithPagination;

class ListDocente extends Component
{
    use WithPagination;
    public $search = '';
    public $notificacion = false;
    public $type = 'success';
    public $message = 'Creado correctamente';

    public function mount()
    {
        Pagina::UpdateVisita('docente.list');
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
        $docente = Docente::GetPrograma($id);
        if (Docente::DeletePrograma($docente)) {
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
        $docentes = Docente::GetAllSearch($this->search, 'DESC', 10);
        $visitas = Pagina::GetPagina('docente.list');
        return view('livewire.academico.docente.list-docente', compact('docentes', 'visitas'))->layout(auth()->user()->tema);
    }
}
