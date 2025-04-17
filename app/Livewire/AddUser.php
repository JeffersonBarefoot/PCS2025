<?php

namespace App\Livewire;

use Livewire\Component;

class AddUser extends Component
{

    public $name;
    public $email;
    public $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ];

    public function submit()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'User successfully added.');
    }

    public function render()
    {
        return view('livewire.add-user');
    }
}
