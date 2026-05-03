<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class InscricoesSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            ConfiguracoesSeed::class,
            MuralestagiosSeed::class,
            AlunosSeed::class,
        ];
    }

    public function run(): void
    {
        if (
            !$this->hasTable('inscricoes')
            || !$this->hasTable('alunos')
            || !$this->hasTable('mural_estagios')
        ) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM inscricoes')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $alunos = $this->fetchAll('SELECT id, registro FROM alunos ORDER BY id ASC');
        $muralestagios = $this->fetchAll('SELECT id FROM mural_estagios ORDER BY id ASC');

        if (!$alunos || !$muralestagios) {
            return;
        }

        $muralestagioIds = array_map(static fn (array $r): int => (int)$r['id'], $muralestagios);

        $config = $this->fetchRow('SELECT mural_periodo_atual FROM configuracoes ORDER BY id ASC LIMIT 1');
        $periodo = (string)($config['mural_periodo_atual'] ?? '2026-1');

        $faker = FakerFactory::create('pt_BR');

        $rows = [];
        foreach ($alunos as $aluno) {
            $alunoId = (int)$aluno['id'];
            $registro = (int)$aluno['registro'];

            $inscricoesPorAluno = $faker->numberBetween(1, 3);
            for ($i = 0; $i < $inscricoesPorAluno; $i++) {
                $rows[] = [
                    'registro' => $registro,
                    'aluno_id' => $alunoId,
                    'muralestagio_id' => $faker->randomElement($muralestagioIds),
                    'periodo' => $periodo,
                    'data' => $faker->dateTimeBetween('-45 days', 'now')->format('Y-m-d'),
                ];
            }
        }

        $this->insert('inscricoes', $rows);
    }
}
