<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember_me = false;

    protected $rules = [
        'email' => 'required|email:rfc,dns',
        'password' => 'required',
    ];

    public function mount()
    {
        $this->fill(['email' => 'kevin@mail.com', 'password' => '1234']);
    }

    public function login()
    {
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $user = User::where(["email" => $this->email, "enabled" => true])->first();

            if ($user != null) {
                auth()->login($user, $this->remember_me);
                return redirect()->intended('/dashboard');
            }
        }
        return $this->addError('email', trans('auth.failed'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
