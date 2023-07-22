<?php

namespace App\Http\Livewire\Sistema\Usuario;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class NewUsuario extends Component
{
    public $userArray = [];
    public $notificacion = false;
    public $type = 'success';
    public $message = 'Creado correctamente';
    public $listeners = ['store' => 'save'];

    public $roles = [];
    public $areas = [
        "Sistemas",
        "Contable",
        "Administracion",
        "Gerencia",
    ];

    public function mount()
    {
        $this->userArray = [
            'name' => '',
            'email' => '',
            'password' => '',
            'area' => '',
            'rol' => ''
        ];
        $this->roles = Role::all();
    }

    public function save()
    {
        $new = User::create($this->userArray);
        $new->assignRole($this->userArray['rol']);
        if (!$new) {
            $this->message = 'Error al crear el usuario';
            $this->type = 'error';
            $this->notificacion = true;
        }
        return redirect()->route('usuario.list');
    }

    public function render()
    {
        return view('livewire.sistema.usuario.new-usuario')->layout('layouts.adulto');
    }
}