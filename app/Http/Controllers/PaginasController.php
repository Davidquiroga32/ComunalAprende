<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// use App\Mail\ContactoMail;  // Descomentar cuando se cree el Mailable

class PaginasController extends Controller
{
    /**
     * Página de inicio
     */
    public function inicio()
    {
        return view('welcome');
    }

    /**
     * Página de contacto
     */
    public function contacto()
    {
        return view('contacto');
    }

    /**
     * Procesar formulario de contacto
     */
    public function enviarContacto(Request $request)
    {
        // Validación con Laravel (reemplaza la validación manual de JS)
        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'subject' => 'required|string|in:informacion,asesoria,soporte,alianzas,otro',
            'message' => 'required|string|min:10|max:2000',
        ], [
            'name.required'    => 'El nombre es obligatorio.',
            'email.required'   => 'El correo electrónico es obligatorio.',
            'email.email'      => 'Ingresa un correo electrónico válido.',
            'subject.required' => 'Selecciona un asunto.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.min'      => 'El mensaje debe tener al menos 10 caracteres.',
        ]);

        // Enviar correo (descomentar cuando se configure el Mailable)
        // Mail::to('info@comunalaprende.com')->send(new ContactoMail($validated));

        // Por ahora solo se redirige con mensaje de éxito
        return redirect()->route('contacto')
            ->with('success', '¡Mensaje enviado exitosamente! Te contactaremos pronto.');
    }

    /**
     * Página de normatividad
     */
    public function normatividad()
    {
        return view('normatividad');
    }
}