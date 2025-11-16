<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClienteModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class NewCliente extends Component
{
    use LivewireAlert;

    public $showModal = false;

    public $nombre = '';
    public $apellidos = '';
    public $ci = '';
    public $direccion = '';
    public $email = '';

    protected $listeners = [
        'openModal' => 'openModal' // permite recibir el evento emitido desde la vista: $emitTo('new-cliente','openModal')
    ];

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:80',
            'apellidos' => 'required|string|max:80',
            'ci' => 'required|string|max:30|unique:Cliente,ci',
            'direccion' => 'required|string|max:80',
            'email' => 'required|email|max:80|unique:Cliente,email',
        ];
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->resetInputs();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputs();
        $this->resetValidation();
    }

    public function resetInputs()
    {
        $this->nombre = '';
        $this->apellidos = '';
        $this->ci = '';
        $this->direccion = '';
        $this->email = '';
    }

    public function enviarClick()
    {
        $this->validate();

        ClienteModel::create([
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'ci' => $this->ci,
            'direccion' => $this->direccion,
            'email' => $this->email,
        ]);

        $this->alert('success', 'Cliente registrado correctamente');

        $this->closeModal();

        // opcional: emitir para que otros componentes refresquen sus listas
        $this->emit('clienteRegistrado');
    }

    public function render()
    {
        return view('livewire.new-cliente');
    }
}
