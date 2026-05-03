<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class ProfessoresSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('professores')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM professores')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $faker = FakerFactory::create('pt_BR');

        $rows = [];
        for ($i = 0; $i < 25; $i++) {
            $cpfDigits = $faker->numerify('###########');
            $cpf = substr($cpfDigits, 0, 3) . '.' . substr($cpfDigits, 3, 3) . '.' . substr($cpfDigits, 6, 3) . '-' . substr($cpfDigits, 9, 2);

            $rows[] = [
                'nome' => $faker->name(),
                'cpf' => $faker->optional(0.85)->passthrough($cpf),
                'siape' => (int)$faker->unique()->numerify('########'),
                'cress' => $faker->optional(0.15)->numberBetween(10000, 999999),
                'regiao' => $faker->optional(0.15)->numberBetween(1, 9),
                'codigo_telefone' => '21',
                'telefone' => $faker->optional(0.7)->numerify('####-####'),
                'codigo_celular' => '21',
                'celular' => $faker->optional(0.7)->numerify('#####-####'),
                'email' => substr($faker->unique()->safeEmail(), 0, 40),
                'curriculolattes' => $faker->optional(0.5)->numerify('http://lattes.cnpq.br/################'),
                'atualizacaolattes' => $faker->optional(0.5)->date(),
                'dataingresso' => $faker->optional(0.6)->date(),
                'departamento' => $faker->optional(0.6)->randomElement(['ESS', 'PPGSS', 'Departamento de Serviço Social']),
                'dataegresso' => null,
                'motivoegresso' => null,
                'observacoes' => $faker->optional(0.3)->sentence(),
                'user_id' => null,
                'estagiario_count' => 0,
            ];
        }

        $this->insert('professores', $rows);
    }
}
