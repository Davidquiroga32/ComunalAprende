<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CrearAdmin extends Command
{
    protected $signature   = 'crear:admin';
    protected $description = 'Crea el usuario administrador de Comunal Aprende';

    public function handle(): void
    {
        $this->info('');
        $this->info('════════════════════════════════════════');
        $this->info('   Crear Usuario Administrador');
        $this->info('════════════════════════════════════════');
        $this->info('');

        // Nombre
        $name = $this->ask('Nombre completo del administrador', 'Administrador Comunal');

        // Documento
        $documento = $this->ask('Documento de identidad');
        while (User::where('documento', $documento)->exists()) {
            $this->warn('⚠ Ese documento ya está registrado.');
            $documento = $this->ask('Ingresa otro documento');
        }

        // Email
        $email = $this->ask('Correo electrónico');
        while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->warn('⚠ Correo no válido.');
            $email = $this->ask('Correo electrónico');
        }
        while (User::where('email', $email)->exists()) {
            $this->warn('⚠ Ese correo ya está registrado.');
            $email = $this->ask('Ingresa otro correo');
        }

        // Contraseña
        $password = $this->secret('Contraseña (mínimo 8 caracteres)');
        while (strlen($password) < 8) {
            $this->warn('⚠ La contraseña debe tener al menos 8 caracteres.');
            $password = $this->secret('Contraseña');
        }
        $confirm = $this->secret('Confirmar contraseña');
        while ($password !== $confirm) {
            $this->warn('⚠ Las contraseñas no coinciden.');
            $password = $this->secret('Contraseña');
            $confirm  = $this->secret('Confirmar contraseña');
        }

        // Celular (opcional)
        $celular = $this->ask('Celular (opcional, presiona Enter para omitir)', null);

        $this->info('');
        $this->info('Resumen:');
        $this->table(['Campo','Valor'], [
            ['Nombre',    $name],
            ['Documento', $documento],
            ['Email',     $email],
            ['Celular',   $celular ?? '(no ingresado)'],
            ['Rol',       'admin'],
        ]);

        if (!$this->confirm('¿Confirmas la creación del administrador?', true)) {
            $this->warn('Operación cancelada.');
            return;
        }

        $admin = User::create([
            'name'       => $name,
            'documento'  => $documento,
            'email'      => $email,
            'password'   => Hash::make($password),
            'celular'    => $celular,
            'condicion'  => 'afiliado',
            'role'       => 'admin',
        ]);

        $this->info('');
        $this->info('✅ Administrador creado exitosamente.');
        $this->info("   ID: {$admin->id}  |  Email: {$admin->email}");
        $this->info('');
    }
}