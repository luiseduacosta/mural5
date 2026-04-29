<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class Initial extends BaseMigration
{
    public function up(): void
    {
        // 1. categorias
        $this->table('categorias')
            ->addColumn('categoria', 'string', ['limit' => 50, 'null' => false])
            ->create();

        // 2. users
        $this->table('users')
            ->addColumn('nome', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('email', 'char', ['limit' => 50, 'null' => false])
            ->addColumn('password', 'char', ['limit' => 80, 'null' => false])
            ->addColumn('categoria', 'enum', ['values' => ['1','2','3','4'], 'default' => '2', 'null' => false])
            ->addColumn('role', 'enum', ['values' => ['admin','supervisor','professor','aluno'], 'default' => 'aluno', 'null' => true])
            ->addColumn('identificacao', 'integer', ['limit' => 9, 'null' => true])
            ->addColumn('entidade_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('aluno_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('supervisor_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('professor_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('ativo', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('criado_em', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true])
            ->addColumn('atualizado_em', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'null' => true])
            ->create();

        // 3. administradores
        $this->table('administradores')
            ->addColumn('nome', 'string', ['limit' => 128, 'null' => false])
            ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => true])
            ->addIndex(['user_id'], ['unique' => true])
            ->create();

        // 4. areas
        $this->table('areas', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['limit' => 3, 'identity' => true])
            ->addColumn('area', 'string', ['limit' => 90, 'default' => '', 'null' => false])
            ->create();

        // 5. instituicoes
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
            ->addColumn('beneficio', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('fim_de_semana', 'char', ['limit' => 1, 'default' => '0', 'null' => true])
            ->addColumn('convenio', 'integer', ['limit' => 4, 'null' => true])
            ->addColumn('expira', 'date', ['null' => true])
            ->addColumn('seguro', 'char', ['limit' => 1, 'null' => true])
            ->addColumn('observacoes', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('estagiario_count', 'integer', ['limit' => 11, 'default' => 0, 'null' => true])
            ->create();

        // 6. supervisores
        $this->table('supervisores', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['limit' => 4, 'identity' => true])
            ->addColumn('nome', 'string', ['limit' => 70, 'null' => false])
            ->addColumn('cpf', 'string', ['limit' => 14, 'null' => true])
            ->addColumn('endereco', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('bairro', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('municipio', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('cep', 'string', ['limit' => 9, 'null' => true])
            ->addColumn('codigo_telefone', 'char', ['limit' => 2, 'default' => '21', 'null' => true])
            ->addColumn('telefone', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('codigo_celular', 'char', ['limit' => 2, 'default' => '21', 'null' => true])
            ->addColumn('celular', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('email', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('escola', 'string', ['limit' => 70, 'null' => true])
            ->addColumn('ano_formatura', 'string', ['limit' => 4, 'null' => true])
            ->addColumn('cress', 'integer', ['limit' => 6, 'null' => false])
            ->addColumn('regiao', 'integer', ['limit' => 2, 'default' => 7, 'null' => false])
            ->addColumn('cargo', 'string', ['limit' => 25, 'null' => true])
            ->addColumn('observacoes', 'text', ['null' => true])
            ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('estagiario_count', 'integer', ['limit' => 11, 'default' => 0, 'null' => true])
            ->create();

        // 7. inst_super
        $this->table('inst_super', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['limit' => 4, 'identity' => true])
            ->addColumn('instituicao_id', 'integer', ['limit' => 4, 'null' => false])
            ->addColumn('supervisor_id', 'integer', ['limit' => 4, 'null' => false])
            ->create();

        // 8. professores
        $this->table('professores', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['limit' => 3, 'identity' => true])
            ->addColumn('nome', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('cpf', 'char', ['limit' => 14, 'null' => true])
            ->addColumn('siape', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('cress', 'integer', ['limit' => 10, 'null' => true])
            ->addColumn('regiao', 'integer', ['limit' => 3, 'null' => true])
            ->addColumn('codigo_telefone', 'char', ['limit' => 2, 'default' => '21', 'null' => false])
            ->addColumn('telefone', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('codigo_celular', 'char', ['limit' => 2, 'default' => '21', 'null' => false])
            ->addColumn('celular', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('email', 'string', ['limit' => 40, 'null' => true])
            ->addColumn('curriculolattes', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('atualizacaolattes', 'date', ['null' => true])
            ->addColumn('dataingresso', 'date', ['null' => true])
            ->addColumn('departamento', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('dataegresso', 'date', ['null' => true])
            ->addColumn('motivoegresso', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('observacoes', 'text', ['null' => true])
            ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('estagiario_count', 'integer', ['limit' => 11, 'default' => 0, 'null' => true])
            ->create();

        // 9. turnos
        $this->table('turnos', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['limit' => 3, 'identity' => true])
            ->addColumn('turno', 'string', ['limit' => 70, 'null' => true])
            ->create();

        // 10. alunos
        $this->table('alunos', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['limit' => 4, 'identity' => true])
            ->addColumn('nome', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('nomesocial', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('ingresso', 'char', ['limit' => 6, 'null' => false])
            ->addColumn('turno_id', 'string', ['limit' => 7, 'null' => true])
            ->addColumn('registro', 'integer', ['limit' => 9, 'default' => 0, 'null' => false])
            ->addColumn('codigo_telefone', 'integer', ['limit' => 2, 'default' => 21, 'null' => false])
            ->addColumn('telefone', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('codigo_celular', 'integer', ['limit' => 2, 'default' => 21, 'null' => false])
            ->addColumn('celular', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('email', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('cpf', 'string', ['limit' => 14, 'null' => false])
            ->addColumn('identidade', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('orgao', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('nascimento', 'date', ['null' => false])
            ->addColumn('endereco', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('cep', 'string', ['limit' => 9, 'null' => true])
            ->addColumn('municipio', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('bairro', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('observacoes', 'string', ['limit' => 250, 'null' => true])
            ->addColumn('user_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('estagiario_count', 'integer', ['limit' => 11, 'default' => 0, 'null' => true])
            ->addColumn('inscricao_count', 'integer', ['limit' => 11, 'default' => 0, 'null' => true])
            ->addIndex(['registro'], ['unique' => true])
            ->create();

        // 11. complementos
        $this->table('complementos')
            ->addColumn('periodo_especial', 'string', ['limit' => 10, 'null' => true])
            ->create();

        // 12. estagiarios
        $this->table('estagiarios')
            ->addColumn('aluno_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('registro', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('nivel', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('tc', 'integer', ['limit' => 6, 'null' => true])
            ->addColumn('tc_solicitacao', 'date', ['null' => true])
            ->addColumn('instituicao_id', 'integer', ['limit' => 6, 'null' => false])
            ->addColumn('supervisor_id', 'integer', ['limit' => 6, 'null' => true])
            ->addColumn('professor_id', 'integer', ['limit' => 6, 'null' => true])
            ->addColumn('periodo', 'string', ['limit' => 6, 'null' => false])
            ->addColumn('nota', 'decimal', ['precision' => 4, 'scale' => 2, 'null' => true])
            ->addColumn('ch', 'integer', ['limit' => 6, 'null' => true])
            ->addColumn('observacoes', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('complemento_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('ajuste2020', 'char', ['limit' => 1, 'default' => '1', 'null' => false])
            ->addColumn('benetransporte', 'boolean', ['null' => true])
            ->addColumn('benealimentacao', 'boolean', ['null' => true])
            ->addColumn('benebolsa', 'string', ['limit' => 5, 'null' => true])
            ->create();

        // 13. folhadeatividades
        $this->table('folhadeatividades')
            ->addColumn('estagiario_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('dia', 'date', ['null' => false])
            ->addColumn('inicio', 'time', ['null' => false])
            ->addColumn('final', 'time', ['null' => false])
            ->addColumn('atividade', 'string', ['limit' => 100, 'null' => false])
            ->create();
        
        $this->execute("ALTER TABLE folhadeatividades ADD horario TIME GENERATED ALWAYS AS (timediff(final,inicio)) STORED;");

        // 14. mural_estagios
        $this->table('mural_estagios', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['limit' => 3, 'identity' => true])
            ->addColumn('instituicao_id', 'integer', ['limit' => 4, 'null' => false])
            ->addColumn('instituicao', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('convenio', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('vagas', 'integer', ['limit' => 3, 'null' => false])
            ->addColumn('beneficios', 'string', ['limit' => 70, 'null' => true])
            ->addColumn('final_de_semana', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('carga_horaria', 'integer', ['limit' => 2, 'null' => true])
            ->addColumn('requisitos', 'string', ['limit' => 455, 'null' => true])
            ->addColumn('horario', 'char', ['limit' => 1, 'null' => true])
            ->addColumn('data_selecao', 'date', ['null' => true])
            ->addColumn('data_inscricao', 'date', ['null' => true])
            ->addColumn('horario_selecao', 'string', ['limit' => 5, 'null' => true])
            ->addColumn('local_selecao', 'string', ['limit' => 70, 'null' => true])
            ->addColumn('forma_selecao', 'char', ['limit' => 1, 'null' => true])
            ->addColumn('contato', 'string', ['limit' => 70, 'null' => true])
            ->addColumn('outras', 'text', ['null' => true])
            ->addColumn('periodo', 'string', ['limit' => 6, 'null' => true])
            ->addColumn('local_inscricao', 'set', ['values' => ['0', '1'], 'default' => '0', 'null' => false])
            ->addColumn('email', 'string', ['limit' => 70, 'null' => false])
            ->create();

        // 15. inscricoes
        $this->table('inscricoes')
            ->addColumn('registro', 'integer', ['limit' => 9, 'null' => false])
            ->addColumn('aluno_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('muralestagio_id', 'integer', ['limit' => 3, 'null' => false])
            ->addColumn('periodo', 'char', ['limit' => 6, 'null' => false])
            ->addColumn('data', 'date', ['null' => false])
            ->addColumn('timestamp', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->create();

        // 16. avaliacoes
        $this->table('avaliacoes')
            ->addColumn('estagiario_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('avaliacao1', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao2', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao3', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao4', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao5', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao6', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao7', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao8', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao9', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao9_1', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('avaliacao10', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao10_1', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('avaliacao11', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao11_1', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('avaliacao12', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao12_1', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('avaliacao13', 'char', ['limit' => 1, 'null' => false])
            ->addColumn('avaliacao13_1', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('avaliacao14', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('observacoes', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('criado_em', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('atualizado_em', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->create();

        // 17. questionarios
        $this->table('questionarios')
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['null' => false])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addColumn('is_active', 'boolean', ['null' => false])
            ->addColumn('category', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('target_user_type', 'string', ['limit' => 50, 'null' => false])
            ->create();

        // 18. questoes
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

        // 19. respostas
        $this->table('respostas')
            ->addColumn('questionario_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('estagiario_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('response', 'text', ['null' => false])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['estagiario_id'])
            ->create();

        // 20. turmas
        $this->table('turmas', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', ['limit' => 3, 'identity' => true])
            ->addColumn('turma', 'string', ['limit' => 70, 'null' => false])
            ->create();

        // 21. configuracoes
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

        // 22. visitas
        $this->table('visitas')
            ->addColumn('instituicao_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('data', 'date', ['null' => false])
            ->addColumn('motivo', 'string', ['limit' => 256, 'null' => false])
            ->addColumn('responsavel', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('descricao', 'text', ['null' => false])
            ->addColumn('avaliacao', 'string', ['limit' => 50, 'null' => false])
            ->create();

        // Foreign keys
        $this->table('questoes')
            ->addForeignKey('questionario_id', 'questionarios', 'id', ['delete' => 'CASCADE'])
            ->update();
    }

    public function down(): void
    {
        $this->table('questoes')->dropForeignKey('questionario_id')->save();

        $tables = [
            'visitas',
            'configuracoes',
            'turmas',
            'respostas',
            'questoes',
            'questionarios',
            'avaliacoes',
            'inscricoes',
            'mural_estagios',
            'folhadeatividades',
            'estagiarios',
            'complementos',
            'alunos',
            'turnos',
            'professores',
            'inst_super',
            'supervisores',
            'instituicoes',
            'areas',
            'administradores',
            'users',
            'categorias'
        ];

        foreach ($tables as $table) {
            $this->table($table)->drop()->save();
        }
    }
}
