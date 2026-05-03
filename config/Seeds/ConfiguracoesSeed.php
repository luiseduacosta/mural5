<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class ConfiguracoesSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('configuracoes')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM configuracoes')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $this->insert('configuracoes', [[
            'instituicao' => 'ESS/UFRJ',
            'mural_periodo_atual' => '2026-1',
            'curso_turma_atual' => 1,
            'curso_abertura_inscricoes' => '2026-02-01',
            'curso_encerramento_inscricoes' => '2026-02-28',
            'termo_compromisso_periodo' => '2026-1',
            'termo_compromisso_inicio' => '2026-03-01',
            'termo_compromisso_final' => '2026-07-31',
            'periodo_calendario_academico' => '2026-1',
        ]]);
    }
}

