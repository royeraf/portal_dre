<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PurgeChatbotLogs extends Command
{
    protected $signature = 'chatbot:purge-logs {--days= : Días de conservación}';

    protected $description = 'Elimina consultas anonimizadas del chatbot que superaron el plazo de conservación';

    public function handle(): int
    {
        if (! Schema::hasTable('chatbot_consultas')) {
            $this->info('La tabla chatbot_consultas todavía no existe.');

            return self::SUCCESS;
        }

        $days = max(1, (int) ($this->option('days') ?: config('chatbot.retention_days', 90)));
        $deleted = DB::table('chatbot_consultas')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();

        $this->info("Se eliminaron {$deleted} registros con más de {$days} días.");

        return self::SUCCESS;
    }
}
