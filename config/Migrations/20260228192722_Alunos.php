<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class Alunos extends BaseMigration
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
        $table = $this->table('alunos');

        if (!$table->hasColumn('user_id')) {
            $table->addColumn('user_id', 'integer', ['default' => null, 'null' => true]);
        }
        if (!$table->hasColumn('estagiario_count')) {
            $table->addColumn('estagiario_count', 'integer', ['default' => 0]);
        }
        if (!$table->hasColumn('inscricao_count')) {
            $table->addColumn('inscricao_count', 'integer', ['default' => 0]);
        }

        $table->update();
    }
}
