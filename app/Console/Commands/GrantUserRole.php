<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GrantUserRole extends Command
{
    protected $signature = 'user:grant-role {email} {role : admin, ai_manager, auditor o editor}';

    protected $description = 'Asigna un rol institucional a una cuenta existente';

    public function handle(): int
    {
        $role = (string) $this->argument('role');
        if (! in_array($role, User::ROLES, true)) {
            $this->error('Rol inválido. Use: '.implode(', ', User::ROLES));

            return self::INVALID;
        }

        $user = User::query()->where('email', $this->argument('email'))->first();
        if (! $user) {
            $this->error('No existe una cuenta con ese correo.');

            return self::FAILURE;
        }

        $user->forceFill(['role' => $role])->save();
        $this->info("Rol {$role} asignado a {$user->email}.");

        return self::SUCCESS;
    }
}
