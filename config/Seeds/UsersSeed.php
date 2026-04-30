<?php
declare(strict_types=1);

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class UsersSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('users')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM users')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $faker = FakerFactory::create('pt_BR');
        $hasher = new DefaultPasswordHasher();

        $defaultPasswordHash = $hasher->hash('senha123');

        $rows = [[
            'nome' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => $defaultPasswordHash,
            'categoria' => '1',
            'role' => 'admin',
            'identificacao' => 100000001,
            'entidade_id' => 1,
            'ativo' => 1,
        ]];

        for ($i = 0; $i < 40; $i++) {
            $nome = $faker->name();
            $email = $faker->unique()->safeEmail();
            $dre = (int)$faker->unique()->numerify('#########');

            $rows[] = [
                'nome' => $nome,
                'email' => $email,
                'password' => $defaultPasswordHash,
                'categoria' => '2',
                'role' => 'aluno',
                'identificacao' => $dre,
                'entidade_id' => null,
                'aluno_id' => null,
                'supervisor_id' => null,
                'professor_id' => null,
                'ativo' => 1,
            ];
        }

        $this->insert('users', $rows);
    }
}
