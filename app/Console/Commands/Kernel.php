<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        // Registra os comandos no Laravel
        $this->load(__DIR__.'/Commands');

        // Aqui você pode registrar comandos de console que não estão em uma classe separada
        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Exemplo de como agendar o comando para verificar vendas expiradas diariamente
        $schedule->command('vendas:verificar-expiradas')->daily();
        // Você pode adicionar mais agendamentos aqui
    }
}
