<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class TurmasSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('turmas')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM turmas')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $this->insert('turmas', [
            ['id' => 1, 'turma' => '1'],
            ['id' => 2, 'turma' => '2'],
            ['id' => 3, 'turma' => '3'],
            ['id' => 4, 'turma' => '4'],
        ]);
    }
}
