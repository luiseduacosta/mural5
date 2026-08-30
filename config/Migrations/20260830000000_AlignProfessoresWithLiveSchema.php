<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AlignProfessoresWithLiveSchema extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('professores');

        if ($table->hasColumn('tipocargo')) {
            $table->removeColumn('tipocargo');
        }
        if ($table->hasColumn('created')) {
            $table->removeColumn('created');
        }
        if ($table->hasColumn('modified')) {
            $table->removeColumn('modified');
        }
        if ($table->hasColumn('estagiario_count')) {
            $table->removeColumn('estagiario_count');
        }

        $table->update();

        $table = $this->table('professores');

        if ($table->hasColumn('nome')) {
            $table->changeColumn('nome', 'string', ['limit' => 50, 'null' => false]);
        }
        if ($table->hasColumn('cpf')) {
            $table->changeColumn('cpf', 'char', ['limit' => 14, 'null' => true]);
        }
        if ($table->hasColumn('siape')) {
            $table->changeColumn('siape', 'integer', ['limit' => 8, 'null' => false, 'signed' => false]);
        }
        if ($table->hasColumn('cress')) {
            $table->changeColumn('cress', 'integer', ['limit' => 10, 'null' => true, 'signed' => false]);
        }
        if ($table->hasColumn('regiao')) {
            $table->changeColumn('regiao', 'integer', ['limit' => 2, 'null' => true, 'signed' => false]);
        }
        if ($table->hasColumn('codigo_telefone')) {
            $table->changeColumn('codigo_telefone', 'char', ['limit' => 2, 'null' => false, 'default' => '21']);
        }
        if ($table->hasColumn('codigo_celular')) {
            $table->changeColumn('codigo_celular', 'char', ['limit' => 2, 'null' => false, 'default' => '21']);
        }
        if ($table->hasColumn('email')) {
            $table->changeColumn('email', 'string', ['limit' => 40, 'null' => true]);
        }

        $table->update();
    }
}
