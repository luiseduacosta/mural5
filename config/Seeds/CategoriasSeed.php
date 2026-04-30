<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class CategoriasSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('categorias')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM categorias')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $this->insert('categorias', [
            ['id' => 1, 'categoria' => 'Administrador'],
            ['id' => 2, 'categoria' => 'Aluno'],
            ['id' => 3, 'categoria' => 'Professor'],
            ['id' => 4, 'categoria' => 'Supervisor'],
        ]);
    }
}
