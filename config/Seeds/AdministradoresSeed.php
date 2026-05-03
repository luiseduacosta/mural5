<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class AdministradoresSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            UsersSeed::class,
        ];
    }

    public function run(): void
    {
        if (!$this->hasTable('administradores')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM administradores')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $adminUser = $this->fetchRow("SELECT id, nome FROM users WHERE categoria = '1' ORDER BY id ASC LIMIT 1");
        if (!$adminUser) {
            return;
        }

        $rows = [[
            'nome' => (string)$adminUser['nome'],
            'user_id' => (int)$adminUser['id'],
        ]];

        $faker = FakerFactory::create('pt_BR');
        $extra = $faker->numberBetween(2, 6);
        for ($i = 0; $i < $extra; $i++) {
            $rows[] = [
                'nome' => $faker->name(),
                'user_id' => null,
            ];
        }

        $this->insert('administradores', $rows);
    }
}
