<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class InstSuperSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            InstituicoesSeed::class,
            SupervisoresSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('inst_super')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM inst_super')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $instituicoes = $this->fetchAll('SELECT id FROM instituicoes ORDER BY id ASC');
        $supervisores = $this->fetchAll('SELECT id FROM supervisores ORDER BY id ASC');

        if (!$instituicoes || !$supervisores) {
            return;
        }

        $instituicaoIds = array_map(static fn (array $r): int => (int)$r['id'], $instituicoes);
        $supervisorIds = array_map(static fn (array $r): int => (int)$r['id'], $supervisores);

        $faker = FakerFactory::create('pt_BR');

        $pairs = [];
        $rows = [];
        $target = min(200, count($instituicaoIds) * 3);
        while (count($rows) < $target) {
            $instituicaoId = $faker->randomElement($instituicaoIds);
            $supervisorId = $faker->randomElement($supervisorIds);

            $key = $instituicaoId . ':' . $supervisorId;
            if (isset($pairs[$key])) {
                continue;
            }
            $pairs[$key] = true;

            $rows[] = [
                'instituicao_id' => $instituicaoId,
                'supervisor_id' => $supervisorId,
            ];
        }

        $this->insert('inst_super', $rows);
    }
}
