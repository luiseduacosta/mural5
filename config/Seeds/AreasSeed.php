<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class AreasSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            ConfiguracoesSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('areas')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM areas')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $faker = FakerFactory::create('pt_BR');

        $rows = [
            ['area' => 'Saúde'],
            ['area' => 'Educação'],
            ['area' => 'Assistência Social'],
        ];

        for ($i = 0; $i < 7; $i++) {
            $rows[] = ['area' => ucfirst($faker->unique()->words(2, true))];
        }

        $this->insert('areas', $rows);
    }
}

