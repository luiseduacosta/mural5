<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class InstituicoesSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            AreasSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('instituicoes')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM instituicoes')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $areas = $this->fetchAll('SELECT id FROM areas ORDER BY id ASC');
        if (!$areas) {
            return;
        }
        $areaIds = array_map(static fn (array $r): int => (int)$r['id'], $areas);

        $faker = FakerFactory::create('pt_BR');

        $rows = [];
        for ($i = 0; $i < 30; $i++) {
            $rows[] = [
                'area_id' => $faker->randomElement($areaIds),
                'natureza' => $faker->randomElement(['Pública', 'Privada', 'ONG', 'Autarquia']),
                'instituicao' => strtoupper($faker->unique()->company()),
                'cnpj' => $faker->numerify('##.###.###/####-##'),
                'email' => $faker->companyEmail(),
                'url' => $faker->url(),
                'endereco' => $faker->streetAddress(),
                'bairro' => $faker->bairro(),
                'municipio' => $faker->city(),
                'cep' => $faker->postcode(),
                'telefone' => $faker->phoneNumber(),
                'beneficio' => $faker->randomElement(['VT', 'VR', 'Auxílio transporte', null]),
                'fim_de_semana' => $faker->randomElement(['0', '1', '2']),
                'convenio' => $faker->randomElement([null, 0, 1]),
                'expira' => $faker->optional(0.5)->date(),
                'seguro' => $faker->randomElement([null, '0', '1']),
                'observacoes' => $faker->optional(0.7)->sentence(),
            ];
        }

        $this->insert('instituicoes', $rows);
    }
}

