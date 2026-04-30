<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class AvaliacoesSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            EstagiariosSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('avaliacoes') || !$this->hasTable('estagiarios')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM avaliacoes')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $estagiarios = $this->fetchAll('SELECT id FROM estagiarios ORDER BY id ASC LIMIT 200');
        if (!$estagiarios) {
            return;
        }
        $estagiarioIds = array_map(static fn (array $r): int => (int)$r['id'], $estagiarios);

        $faker = FakerFactory::create('pt_BR');

        $rows = [];
        foreach ($estagiarioIds as $estagiarioId) {
            $score = static fn (): string => (string)$faker->numberBetween(1, 5);

            $rows[] = [
                'estagiario_id' => $estagiarioId,
                'avaliacao1' => $score(),
                'avaliacao2' => $score(),
                'avaliacao3' => $score(),
                'avaliacao4' => $score(),
                'avaliacao5' => $score(),
                'avaliacao6' => $score(),
                'avaliacao7' => $score(),
                'avaliacao8' => $score(),
                'avaliacao9' => $score(),
                'avaliacao9_1' => $faker->optional(0.25)->sentence(),
                'avaliacao10' => $score(),
                'avaliacao10_1' => $faker->optional(0.25)->sentence(),
                'avaliacao11' => $score(),
                'avaliacao11_1' => $faker->optional(0.25)->sentence(),
                'avaliacao12' => $score(),
                'avaliacao12_1' => $faker->optional(0.25)->sentence(),
                'avaliacao13' => $score(),
                'avaliacao13_1' => $faker->optional(0.25)->sentence(),
                'avaliacao14' => $faker->sentence(10),
                'observacoes' => $faker->optional(0.7)->sentence(12) ?? '',
            ];
        }

        $this->insert('avaliacoes', $rows);
    }
}
