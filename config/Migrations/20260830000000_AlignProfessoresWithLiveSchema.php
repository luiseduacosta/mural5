<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AlignProfessoresWithLiveSchema extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('professores');

        // Live schema stores observacoes as MEDIUMTEXT.
        if ($table->hasColumn('observacoes')) {
            $table->changeColumn('observacoes', 'text', [
                'limit' => MysqlAdapter::TEXT_MEDIUM,
                'null' => true,
            ]);
        }

        // Defensive: the legacy singular count column must not exist in the live schema.
        if ($table->hasColumn('estagiario_count')) {
            $table->removeColumn('estagiario_count');
        }

        $table->update();
    }
}
