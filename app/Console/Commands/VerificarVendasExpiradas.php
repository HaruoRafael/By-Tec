<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Venda;
use Carbon\Carbon;

class VerificarVendasExpiradas extends Command
{
    protected $signature = 'vendas:verificar-expiradas';
    protected $description = 'Verifica e atualiza o status das vendas expiradas';

    public function handle()
    {
        // Recupera todas as vendas ativas
        $vendasAtivas = Venda::where('status', 'Ativo')->get();

        foreach ($vendasAtivas as $venda) {
            // Verifica se o plano expirou
            if (Carbon::now()->greaterThan($venda->data_expiracao)) {
                // Atualiza o status para "Finalizado"
                $venda->status = 'Finalizado';
                $venda->save();
                $this->info("Venda {$venda->id} finalizada.");
            }
        }

        $this->info('Verificação de vendas expiradas concluída.');
    }
}

