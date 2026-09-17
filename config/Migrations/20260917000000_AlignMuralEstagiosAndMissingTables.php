<?php
declare(strict_types=1);

use Migrations\BaseMigration;

/**
 * Aligns a database created from the legacy schema with the schema defined by
 * the migrations: converts mural_estagios to snake_case columns, creates the
 * tables legacy databases never had and seeds the required reference rows.
 */
class AlignMuralEstagiosAndMissingTables extends BaseMigration
{
    private const LEGACY_BACKUP_TABLE = 'mural_estagios_legacy_backup_20260917';

    private const LEGACY_RENAMES = [
        'id_estagio' => 'instituicao_id',
        'cargaHoraria' => 'carga_horaria',
        'dataSelecao' => 'data_selecao',
        'dataInscricao' => 'data_inscricao',
        'horarioSelecao' => 'horario_selecao',
        'localSelecao' => 'local_selecao',
        'formaSelecao' => 'forma_selecao',
        'localInscricao' => 'local_inscricao',
    ];

    private const LEGACY_DROPS = ['id_area', 'id_professor', 'datafax'];

    public function up(): void
    {
        $this->convertMuralEstagios();
        $this->createMissingTables();
        $this->addQuestoesForeignKey();
        $this->seedReferenceData();
    }

    /**
     * Tables created by this migration are kept: on databases built by the
     * earlier migrations they already exist and must not be dropped here.
     */
    public function down(): void
    {
        $this->restoreLegacyMuralEstagios();
    }

    private function convertMuralEstagios(): void
    {
        if (!$this->hasTable('mural_estagios')) {
            return;
        }

        $table = $this->table('mural_estagios');
        $legacyColumns = array_merge(array_keys(self::LEGACY_RENAMES), self::LEGACY_DROPS);

        $hasLegacyColumns = false;
        foreach ($legacyColumns as $column) {
            if ($table->hasColumn($column)) {
                $hasLegacyColumns = true;
                break;
            }
        }

        if (!$hasLegacyColumns) {
            return;
        }

        // Full copy so the values of dropped columns stay recoverable.
        if (!$this->hasTable(self::LEGACY_BACKUP_TABLE)) {
            $this->execute('CREATE TABLE `' . self::LEGACY_BACKUP_TABLE . '` LIKE `mural_estagios`');
            $this->execute('INSERT INTO `' . self::LEGACY_BACKUP_TABLE . '` SELECT * FROM `mural_estagios`');
        }

        foreach (self::LEGACY_RENAMES as $legacy => $current) {
            if ($table->hasColumn($legacy) && !$table->hasColumn($current)) {
                $table->renameColumn($legacy, $current);
            }
        }

        foreach (self::LEGACY_DROPS as $legacy) {
            if ($table->hasColumn($legacy)) {
                $table->removeColumn($legacy);
            }
        }

        $table->update();
    }

    private function createMissingTables(): void
    {
        if (!$this->hasTable('categorias')) {
            $this->table('categorias')
                ->addColumn('categoria', 'string', ['limit' => 50, 'null' => false])
                ->create();
        }

        if (!$this->hasTable('administradores')) {
            $this->table('administradores')
                ->addColumn('nome', 'string', ['limit' => 128, 'null' => false])
                ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => true])
                ->addIndex(['user_id'], ['unique' => true])
                ->create();
        }

        if (!$this->hasTable('instituicoes')) {
            $this->table('instituicoes', ['id' => false, 'primary_key' => ['id']])
                ->addColumn('id', 'integer', ['limit' => 4, 'identity' => true])
                ->addColumn('area_id', 'integer', ['limit' => 3, 'null' => true])
                ->addColumn('natureza', 'string', ['limit' => 50, 'null' => true])
                ->addColumn('instituicao', 'string', ['limit' => 120, 'default' => '', 'null' => false])
                ->addColumn('cnpj', 'char', ['limit' => 18, 'null' => true])
                ->addColumn('email', 'string', ['limit' => 90, 'null' => true])
                ->addColumn('url', 'string', ['limit' => 100, 'null' => true])
                ->addColumn('endereco', 'string', ['limit' => 105, 'default' => '', 'null' => false])
                ->addColumn('bairro', 'string', ['limit' => 30, 'null' => true])
                ->addColumn('municipio', 'string', ['limit' => 30, 'null' => true])
                ->addColumn('cep', 'char', ['limit' => 9, 'default' => '', 'null' => false])
                ->addColumn('telefone', 'string', ['limit' => 50, 'default' => '', 'null' => false])
                ->addColumn('beneficios', 'string', ['limit' => 50, 'null' => true])
                ->addColumn('fim_de_semana', 'char', ['limit' => 1, 'default' => '0', 'null' => true])
                ->addColumn('convenio', 'integer', ['limit' => 4, 'null' => true])
                ->addColumn('expira', 'date', ['null' => true])
                ->addColumn('seguro', 'char', ['limit' => 1, 'null' => true])
                ->addColumn('observacoes', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('estagiarios_count', 'integer', ['default' => 0, 'null' => true])
                ->create();
        }

        if (!$this->hasTable('turnos')) {
            $this->table('turnos', ['id' => false, 'primary_key' => ['id']])
                ->addColumn('id', 'integer', ['limit' => 3, 'identity' => true])
                ->addColumn('turno', 'string', ['limit' => 70, 'null' => true])
                ->create();
        }

        if (!$this->hasTable('turmas')) {
            $this->table('turmas', ['id' => false, 'primary_key' => ['id']])
                ->addColumn('id', 'integer', ['limit' => 3, 'identity' => true])
                ->addColumn('turma', 'string', ['limit' => 70, 'null' => false])
                ->create();
        }

        if (!$this->hasTable('inscricoes')) {
            $this->table('inscricoes')
                ->addColumn('registro', 'integer', ['limit' => 9, 'null' => false])
                ->addColumn('aluno_id', 'integer', ['limit' => 11, 'null' => false])
                ->addColumn('muralestagio_id', 'integer', ['limit' => 3, 'null' => false])
                ->addColumn('periodo', 'char', ['limit' => 6, 'null' => false])
                ->addColumn('data', 'date', ['null' => false])
                ->addColumn('timestamp', 'timestamp', [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP',
                    'null' => false,
                ])
                ->create();
        }

        if (!$this->hasTable('questionarios')) {
            $this->table('questionarios')
                ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
                ->addColumn('description', 'text', ['null' => false])
                ->addColumn('created', 'datetime', ['null' => false])
                ->addColumn('modified', 'datetime', ['null' => false])
                ->addColumn('is_active', 'boolean', ['null' => false])
                ->addColumn('category', 'string', ['limit' => 100, 'null' => false])
                ->addColumn('target_user_type', 'string', ['limit' => 50, 'null' => false])
                ->create();
        }

        if (!$this->hasTable('questoes')) {
            $this->table('questoes')
                ->addColumn('questionario_id', 'integer', ['limit' => 11, 'null' => false])
                ->addColumn('text', 'text', ['null' => false])
                ->addColumn('type', 'string', ['limit' => 50, 'null' => false])
                ->addColumn('options', 'text', ['null' => false])
                ->addColumn('created', 'datetime', ['null' => false])
                ->addColumn('modified', 'datetime', ['null' => false])
                ->addColumn('ordem', 'integer', ['limit' => 11, 'null' => false])
                ->addIndex(['questionario_id'])
                ->create();
        }

        if (!$this->hasTable('respostas')) {
            $this->table('respostas')
                ->addColumn('questionario_id', 'integer', ['limit' => 11, 'null' => false])
                ->addColumn('estagiario_id', 'integer', ['limit' => 11, 'null' => false])
                ->addColumn('response', 'text', ['null' => false])
                ->addColumn('created', 'datetime', ['null' => false])
                ->addColumn('modified', 'datetime', ['null' => false])
                ->addIndex(['estagiario_id'])
                ->create();
        }

        if (!$this->hasTable('configuracoes')) {
            $this->table('configuracoes')
                ->addColumn('instituicao', 'string', ['limit' => 120, 'default' => 'ESS/UFRJ', 'null' => false])
                ->addColumn('mural_periodo_atual', 'char', ['limit' => 6, 'null' => false])
                ->addColumn('curso_turma_atual', 'integer', ['limit' => 2, 'null' => true])
                ->addColumn('curso_abertura_inscricoes', 'date', ['null' => true])
                ->addColumn('curso_encerramento_inscricoes', 'date', ['null' => true])
                ->addColumn('termo_compromisso_periodo', 'char', ['limit' => 6, 'null' => false])
                ->addColumn('termo_compromisso_inicio', 'date', ['null' => false])
                ->addColumn('termo_compromisso_final', 'date', ['null' => false])
                ->addColumn('periodo_calendario_academico', 'char', ['limit' => 6, 'null' => false])
                ->create();
        }

        if (!$this->hasTable('visitas')) {
            $this->table('visitas')
                ->addColumn('instituicao_id', 'integer', ['limit' => 11, 'null' => false])
                ->addColumn('data', 'date', ['null' => false])
                ->addColumn('motivo', 'string', ['limit' => 256, 'null' => false])
                ->addColumn('responsavel', 'string', ['limit' => 50, 'null' => false])
                ->addColumn('descricao', 'text', ['null' => false])
                ->addColumn('avaliacao', 'string', ['limit' => 50, 'null' => false])
                ->create();
        }
    }

    private function addQuestoesForeignKey(): void
    {
        if (!$this->hasTable('questoes') || !$this->hasTable('questionarios')) {
            return;
        }

        $questoes = $this->table('questoes');

        if (!$questoes->hasForeignKey('questionario_id')) {
            $questoes->addForeignKey('questionario_id', 'questionarios', 'id', ['delete' => 'CASCADE'])
                ->update();
        }
    }

    private function seedReferenceData(): void
    {
        if ($this->isEmpty('categorias')) {
            $this->execute("INSERT INTO `categorias` (`id`, `categoria`) VALUES "
                . "(1, 'Administrador'), (2, 'Aluno'), (3, 'Professor'), (4, 'Supervisor')");
        }

        if ($this->isEmpty('turnos')) {
            $this->execute("INSERT INTO `turnos` (`id`, `turno`) VALUES "
                . "(1, 'diurno'), (2, 'noturno'), (3, 'integral'), (4, 'outro')");
        }

        // The listing screens read mural_periodo_atual on every request.
        if ($this->isEmpty('configuracoes')) {
            $this->execute("INSERT INTO `configuracoes` "
                . "(`instituicao`, `mural_periodo_atual`, `curso_turma_atual`, `termo_compromisso_periodo`, "
                . "`termo_compromisso_inicio`, `termo_compromisso_final`, `periodo_calendario_academico`) "
                . "VALUES ('ESS/UFRJ', '2025-1', 1, '2025-1', '2025-03-01', '2025-07-31', '2025-1')");
        }
    }

    private function isEmpty(string $table): bool
    {
        if (!$this->hasTable($table)) {
            return false;
        }

        $row = $this->fetchRow('SELECT COUNT(*) AS total FROM `' . $table . '`');

        return $row !== false && (int)$row['total'] === 0;
    }

    private function restoreLegacyMuralEstagios(): void
    {
        if (!$this->hasTable(self::LEGACY_BACKUP_TABLE) || !$this->hasTable('mural_estagios')) {
            return;
        }

        $table = $this->table('mural_estagios');

        foreach (self::LEGACY_RENAMES as $legacy => $current) {
            if ($table->hasColumn($current) && !$table->hasColumn($legacy)) {
                $table->renameColumn($current, $legacy);
            }
        }

        // Values of the dropped columns remain available in the backup table.
        $restoredColumns = ['id_area' => 'integer', 'id_professor' => 'integer', 'datafax' => 'date'];
        foreach ($restoredColumns as $legacy => $type) {
            if (!$table->hasColumn($legacy)) {
                $table->addColumn($legacy, $type, ['null' => true]);
            }
        }

        $table->update();
    }
}
