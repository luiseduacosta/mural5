<?php
declare(strict_types=1);

use Migrations\BaseSeed;

class TurnosSeed extends BaseSeed
{
    public function run(): void
    {
        if (!$this->hasTable('turnos')) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM turnos')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $this->insert('turnos', [
            ['id' => 1, 'turno' => 'diurno'],
            ['id' => 2, 'turno' => 'noturno'],
            ['id' => 3, 'turno' => 'integral'],
            ['id' => 4, 'turno' => 'outro'],
        ]);
    }
}
