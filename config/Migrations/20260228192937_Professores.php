<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class Professores extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('professores');
        
        if (!$table->hasColumn('user_id')) {
            $table->addColumn('user_id', 'integer', ['default' => null, 'null' => true]);
        }
        if (!$table->hasColumn('estagiario_count')) {
            $table->addColumn('estagiario_count', 'integer', ['default' => 0]);
        }
        if (!$table->hasColumn('estagiarios_count')) {
            $table->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
        }
        if (!$table->hasColumn('status')) {
            $table->addColumn('status', 'string', ['limit' => 10, 'default' => 'ativo', 'null' => false]);
        }
        if (!$table->hasColumn('tipocargo')) {
            $table->addColumn('tipocargo', 'string', ['limit' => 20, 'default' => null, 'null' => true]);
        }
        if (!$table->hasColumn('created')) {
            $table->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'null' => false]);
        }
        if (!$table->hasColumn('modified')) {
            $table->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'null' => false]);
        }

        $table->update();
    }
}
