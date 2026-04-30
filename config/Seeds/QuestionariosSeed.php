<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class QuestionariosSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('questionarios')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM questionarios')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $faker = FakerFactory::create('pt_BR');
        $now = (new DateTimeImmutable('now'))->format('Y-m-d H:i:s');

        $rows = [[
            'id' => 1,
            'title' => 'Avaliação do Estágio',
            'description' => 'Questionário de avaliação do estágio.',
            'created' => $now,
            'modified' => $now,
            'is_active' => 1,
            'category' => 'estagio',
            'target_user_type' => 'aluno',
        ], [
            'id' => 2,
            'title' => 'Avaliação do Supervisor',
            'description' => 'Questionário de avaliação do supervisor.',
            'created' => $now,
            'modified' => $now,
            'is_active' => 1,
            'category' => 'supervisor',
            'target_user_type' => 'aluno',
        ]];

        for ($i = 0; $i < 3; $i++) {
            $rows[] = [
                'title' => $faker->sentence(4),
                'description' => $faker->paragraph(),
                'created' => $now,
                'modified' => $now,
                'is_active' => $faker->boolean(80) ? 1 : 0,
                'category' => $faker->randomElement(['estagio', 'supervisor', 'instituicao']),
                'target_user_type' => $faker->randomElement(['aluno', 'supervisor', 'professor']),
            ];
        }

        $this->insert('questionarios', $rows);
    }
}
