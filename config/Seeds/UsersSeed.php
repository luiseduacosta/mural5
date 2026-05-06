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
        $now = (new DateTimeImmutable('now'))->format('Y-m-d H:i:s');

        $rows = [[
            'nome' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => $defaultPasswordHash,
            'categoria' => '1',
            'role' => 'admin',
            'identificacao' => 100000001,
            'entidade_id' => 1,
            'ativo' => 1,
            'criado_em' => $now,
            'atualizado_em' => $now,
        ]];

        for ($i = 0; $i < 40; $i++) {
            $nome = $faker->name();
            $email = $faker->unique()->safeEmail();
            $identificacao = (int)$faker->unique()->numerify('#########');

            $categoria = $faker->randomElement(['2', '3', '4']);
            $entidade_id = $i + 1;
            
            $role = '';
            $aluno_id = null;
            $professor_id = null;
            $supervisor_id = null;

            if ($categoria === '2') {
                $role = 'aluno';
                $aluno_id = $entidade_id;
            } elseif ($categoria === '3') {
                $role = 'professor';
                $professor_id = $entidade_id;
            } elseif ($categoria === '4') {
                $role = 'supervisor';
                $supervisor_id = $entidade_id;
            }

            $rows[] = [
                'nome' => $nome,
                'email' => $email,
                'password' => $defaultPasswordHash,
                'categoria' => $categoria,
                'role' => $role,
                'identificacao' => $identificacao,
                'entidade_id' => $entidade_id,
                'aluno_id' => $aluno_id,
                'supervisor_id' => $supervisor_id,
                'professor_id' => $professor_id,
                'ativo' => 1,
                'criado_em' => $now,
                'atualizado_em' => $now,
            ];
        }

        $this->insert('users', $rows);
    }
}
