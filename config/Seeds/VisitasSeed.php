<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class VisitasSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            InstituicoesSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('visitas')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM visitas')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $instituicoes = $this->fetchAll('SELECT id FROM instituicoes ORDER BY id ASC');
        if (!$instituicoes) {
            return;
        }
        $instituicaoIds = array_map(static fn (array $r): int => (int)$r['id'], $instituicoes);

        $faker = FakerFactory::create('pt_BR');

        $rows = [];
        for ($i = 0; $i < 80; $i++) {
            $rows[] = [
                'instituicao_id' => $faker->randomElement($instituicaoIds),
                'data' => $faker->date(),
                'motivo' => $faker->randomElement(['Visita técnica', 'Acompanhamento', 'Avaliação', 'Renovação de convênio']),
                'responsavel' => $faker->name(),
                'descricao' => $faker->paragraph(),
                'avaliacao' => $faker->randomElement(['Ótima', 'Boa', 'Regular', 'Ruim']),
            ];
        }

        $this->insert('visitas', $rows);
    }
}

