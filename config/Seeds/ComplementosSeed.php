<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class ComplementosSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('complementos')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM complementos')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $this->insert('complementos', [
            ['id' => 1, 'periodo_especial' => 'REMOTO'],
            ['id' => 2, 'periodo_especial' => 'PLE'],
        ]);
    }
}
