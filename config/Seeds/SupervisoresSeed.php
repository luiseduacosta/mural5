<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class SupervisoresSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('supervisores')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM supervisores')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $faker = FakerFactory::create('pt_BR');

        $rows = [];
        for ($i = 0; $i < 40; $i++) {
            $cpfDigits = $faker->numerify('###########');
            $cpf = substr($cpfDigits, 0, 3) . '.' . substr($cpfDigits, 3, 3) . '.' . substr($cpfDigits, 6, 3) . '-' . substr($cpfDigits, 9, 2);

            $rows[] = [
                'nome' => $faker->name(),
                'cpf' => $faker->optional(0.9)->passthrough($cpf),
                'endereco' => $faker->optional(0.8)->streetAddress(),
                'bairro' => $faker->optional(0.7)->bairro(),
                'municipio' => $faker->optional(0.7)->city(),
                'cep' => $faker->optional(0.7)->numerify('#####-###'),
                'codigo_telefone' => '21',
                'telefone' => $faker->optional(0.7)->numerify('####-####'),
                'codigo_celular' => '21',
                'celular' => $faker->optional(0.7)->numerify('#####-####'),
                'email' => substr($faker->unique()->safeEmail(), 0, 50),
                'escola' => $faker->optional(0.5)->company(),
                'ano_formatura' => (string)$faker->numberBetween(1990, 2025),
                'cress' => (int)$faker->unique()->numberBetween(100000, 999999),
                'regiao' => 7,
                'cargo' => $faker->optional(0.6)->randomElement(['Assistente social', 'Coordenador(a)', 'Supervisor(a)']),
                'observacoes' => $faker->optional(0.25)->sentence(),
                'user_id' => null,
                'estagiario_count' => 0,
            ];
        }

        $this->insert('supervisores', $rows);
    }
}
