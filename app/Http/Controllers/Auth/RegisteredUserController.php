<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                     => ['required', 'string', 'max:150'],
            'documento'                => ['required', 'string', 'max:20', 'unique:users'],
            'email'                    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'celular'                  => ['required', 'string', 'max:20'],
            'departamento'             => ['required', 'string', 'max:100'],
            'municipio'                => ['required', 'string', 'max:150'],
            'pertenece_oac'            => ['nullable', 'boolean'],
            'organismo_accion_comunal' => ['nullable', 'string', 'max:255',
                                        'required_if:pertenece_oac,1'],
            'condicion'                => ['required', 'in:afiliado,particular'],
            'password'                 => ['required', 'confirmed', Rules\Password::defaults()],
            'terms'                    => ['required', 'accepted'],
        ], [
            'name.required'                     => 'El nombre completo es obligatorio.',
            'documento.required'                => 'El documento de identidad es obligatorio.',
            'documento.unique'                  => 'Este documento ya está registrado.',
            'email.required'                    => 'El correo electrónico es obligatorio.',
            'email.unique'                      => 'Este correo ya está registrado.',
            'celular.required'                  => 'El número de celular es obligatorio.',
            'departamento.required'             => 'Selecciona un departamento.',
            'municipio.required'                => 'Selecciona un municipio.',
            'condicion.required'                => 'Selecciona una condición.',
            'organismo_accion_comunal.required_if' => 'Ingresa el nombre del organismo al que perteneces.',
            'password.confirmed'                => 'Las contraseñas no coinciden.',
            'terms.required'                    => 'Debes aceptar los términos y condiciones.',
        ]);

        $user = User::create([
            'name'                     => $request->name,
            'documento'                => $request->documento,
            'email'                    => $request->email,
            'celular'                  => $request->celular,
            'departamento'             => $request->departamento,
            'municipio'                => $request->municipio,
            'pertenece_oac'            => $request->boolean('pertenece_oac'),
            'organismo_accion_comunal' => $request->boolean('pertenece_oac')
                                            ? $request->organismo_accion_comunal
                                            : null,
            'condicion'                => $request->condicion,
            'newsletter'               => $request->boolean('newsletter'),
            'password'                 => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}