<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class FixEstagiariosCountFields extends BaseMigration
{
    public function change(): void
    {
        $alunos = $this->table('alunos');
        if ($alunos->hasColumn('estagiario_count')) {
            if (!$alunos->hasColumn('estagiarios_count')) {
                $alunos->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
                $alunos->update();
                $this->execute('UPDATE alunos SET estagiarios_count = estagiario_count');
            }
            $alunos->removeColumn('estagiario_count');
            $alunos->update();
        } elseif (!$alunos->hasColumn('estagiarios_count')) {
            $alunos->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
            $alunos->update();
        }

        $professores = $this->table('professores');
        if ($professores->hasColumn('estagiario_count')) {
            if (!$professores->hasColumn('estagiarios_count')) {
                $professores->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
                $professores->update();
                $this->execute('UPDATE professores SET estagiarios_count = estagiario_count');
            }
            $professores->removeColumn('estagiario_count');
            $professores->update();
        } elseif (!$professores->hasColumn('estagiarios_count')) {
            $professores->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
            $professores->update();
        }

        $supervisores = $this->table('supervisores');
        if ($supervisores->hasColumn('estagiario_count')) {
            if (!$supervisores->hasColumn('estagiarios_count')) {
                $supervisores->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
                $supervisores->update();
                $this->execute('UPDATE supervisores SET estagiarios_count = estagiario_count');
            }
            $supervisores->removeColumn('estagiario_count');
            $supervisores->update();
        } elseif (!$supervisores->hasColumn('estagiarios_count')) {
            $supervisores->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
            $supervisores->update();
        }

        $instituicoes = $this->table('instituicoes');
        if ($instituicoes->hasColumn('estagiario_count')) {
            if (!$instituicoes->hasColumn('estagiarios_count')) {
                $instituicoes->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
                $instituicoes->update();
                $this->execute('UPDATE instituicoes SET estagiarios_count = estagiario_count');
            }
            $instituicoes->removeColumn('estagiario_count');
            $instituicoes->update();
        } elseif (!$instituicoes->hasColumn('estagiarios_count')) {
            $instituicoes->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true]);
            $instituicoes->update();
        }
    }
}
