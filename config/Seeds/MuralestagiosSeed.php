<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class MuralestagiosSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            ConfiguracoesSeed::class,
            InstituicoesSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('mural_estagios')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM mural_estagios')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $instituicoes = $this->fetchAll('SELECT id, instituicao, email FROM instituicoes ORDER BY id ASC');
        if (!$instituicoes) {
            return;
        }

        $config = $this->fetchRow('SELECT mural_periodo_atual FROM configuracoes ORDER BY id ASC LIMIT 1');
        $periodo = (string)($config['mural_periodo_atual'] ?? '2026-1');

        $faker = FakerFactory::create('pt_BR');

        $rows = [];
        for ($i = 0; $i < 60; $i++) {
            $inst = $faker->randomElement($instituicoes);

            $rows[] = [
                'instituicao_id' => (int)$inst['id'],
                'instituicao' => (string)$inst['instituicao'],
                'convenio' => $faker->randomElement(['0', '1']),
                'vagas' => $faker->numberBetween(1, 10),
                'beneficios' => $faker->optional(0.7)->randomElement(['VT', 'VR', 'Auxílio transporte', 'Bolsa', null]),
                'final_de_semana' => $faker->randomElement(['0', '1', '2']),
                'carga_horaria' => $faker->optional(0.8)->randomElement([20, 25, 30]),
                'requisitos' => $faker->optional(0.7)->sentence(12),
                'horario' => $faker->randomElement(['M', 'T', 'N', null]),
                'data_selecao' => $faker->optional(0.7)->date(),
                'data_inscricao' => $faker->optional(0.8)->date(),
                'horario_selecao' => $faker->optional(0.7)->numerify('##:##'),
                'local_selecao' => $faker->optional(0.7)->streetAddress(),
                'forma_selecao' => $faker->optional(0.7)->randomElement(['0', '1', '2']),
                'contato' => $faker->optional(0.8)->name(),
                'outras' => $faker->optional(0.6)->sentence(),
                'periodo' => $periodo,
                'local_inscricao' => $faker->randomElement(['0', '1']),
                'email' => (string)($inst['email'] ?: $faker->companyEmail()),
            ];
        }

        $this->insert('mural_estagios', $rows);
    }
}

