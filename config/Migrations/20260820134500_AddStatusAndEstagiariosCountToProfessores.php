<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddStatusAndEstagiariosCountToProfessores extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('professores');
        
        if (!$table->hasColumn('estagiarios_count')) {
            $table->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
        }
        if (!$table->hasColumn('status')) {
            $table->addColumn('status', 'string', ['limit' => 10, 'default' => 'ativo', 'null' => false]);
        }

        $table->update();
    }
}
