<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class AlunosSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            TurnosSeed::class,
            UsersSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('alunos') || !$this->hasTable('users')) {
            return;
        }

        $alunosCount = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM alunos')['total'] ?? 0);
        if ($alunosCount > 0) {
            return;
        }

        $turnos = $this->fetchAll('SELECT id FROM turnos ORDER BY id ASC');
        if (!$turnos) {
            return;
        }
        $turnoIds = array_map(static fn (array $r): int => (int)$r['id'], $turnos);

        $users = $this->fetchAll(
            "SELECT id, nome, email, identificacao FROM users WHERE categoria = '2' AND (aluno_id IS NULL OR aluno_id = 0) ORDER BY id ASC LIMIT 60"
        );
        if (!$users) {
            return;
        }

        $faker = FakerFactory::create('pt_BR');

        $usedRegistros = $this->fetchAll('SELECT registro FROM alunos');
        $usedRegistroSet = [];
        foreach ($usedRegistros as $r) {
            $usedRegistroSet[(string)$r['registro']] = true;
        }

        $rows = [];
        foreach ($users as $user) {
            $userId = (int)$user['id'];
            $registro = (int)($user['identificacao'] ?? 0);
            if ($registro <= 0 || isset($usedRegistroSet[(string)$registro])) {
                do {
                    $registro = (int)$faker->unique()->numerify('#########');
                } while (isset($usedRegistroSet[(string)$registro]));
            }
            $usedRegistroSet[(string)$registro] = true;

            $cpfDigits = $faker->numerify('###########');
            $cpf = substr($cpfDigits, 0, 3) . '.' . substr($cpfDigits, 3, 3) . '.' . substr($cpfDigits, 6, 3) . '-' . substr($cpfDigits, 9, 2);

            $celular = sprintf(
                '(21) %05d.%04d',
                $faker->numberBetween(90000, 99999),
                $faker->numberBetween(0, 9999)
            );

            $ingresso = (string)$faker->randomElement([
                '2022-1',
                '2022-2',
                '2023-1',
                '2023-2',
                '2024-1',
                '2024-2',
                '2025-1',
                '2025-2',
                '2026-1',
            ]);

            $rows[] = [
                'nome' => (string)$user['nome'],
                'nomesocial' => $faker->optional(0.15)->firstName(),
                'ingresso' => $ingresso,
                'turno_id' => $faker->randomElement($turnoIds),
                'registro' => $registro,
                'codigo_telefone' => 21,
                'telefone' => $faker->optional(0.7)->numerify('####-####'),
                'codigo_celular' => 21,
                'celular' => $celular,
                'email' => (string)$user['email'],
                'cpf' => $cpf,
                'identidade' => $faker->optional(0.5)->numerify('#########'),
                'orgao' => $faker->optional(0.4)->randomElement(['SSP', 'DETRAN', 'IFP']),
                'nascimento' => $faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
                'endereco' => $faker->streetAddress(),
                'cep' => $faker->numerify('#####-###'),
                'municipio' => $faker->city(),
                'bairro' => $faker->words(2, true),
                'observacoes' => $faker->optional(0.4)->sentence(),
                'user_id' => $userId,
                'estagiario_count' => 0,
                'inscricao_count' => 0,
            ];
        }

        $this->insert('alunos', $rows);

        $created = $this->fetchAll('SELECT id, user_id FROM alunos WHERE user_id IS NOT NULL');
        foreach ($created as $r) {
            $alunoId = (int)$r['id'];
            $userId = (int)$r['user_id'];
            if ($userId > 0 && $alunoId > 0) {
                $this->execute('UPDATE users SET aluno_id = ' . $alunoId . ' WHERE id = ' . $userId);
            }
        }
    }
}
