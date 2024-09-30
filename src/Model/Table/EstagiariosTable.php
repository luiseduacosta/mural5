<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estagiarios Model
 *
 * @property \App\Model\Table\AlunosTable&\Cake\ORM\Association\BelongsTo $Alunos
 * @property \App\Model\Table\EstudantesTable&\Cake\ORM\Association\BelongsTo $Estudantes
 * @property \App\Model\Table\InstituicaoestagiosTable&\Cake\ORM\Association\BelongsTo $Instituicaoestagios
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsTo $Supervisores
 * @property \App\Model\Table\DocentesTable&\Cake\ORM\Association\BelongsTo $Docentes
 * @property \App\Model\Table\AreaestagiosTable&\Cake\ORM\Association\BelongsTo $Areaestagios
 * @property \App\Model\Table\AvaliacoesTable&\Cake\ORM\Association\HasOne $Avaliacoes
 * @property \App\Model\Table\FolhadeatividadesTable&\Cake\ORM\Association\HasOne $Folhadeatividades
 *
 * @method \App\Model\Entity\Estagiario newEmptyEntity()
 * @method \App\Model\Entity\Estagiario newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estagiario findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Estagiario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EstagiariosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('estagiarios');
        $this->setAlias('Estagiarios');
        $this->setDisplayField('registro');
        $this->setPrimaryKey('id');

        $this->belongsTo('Alunos', [
            'foreignKey' => 'id_aluno',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Estudantes', [
            'foreignKey' => 'alunonovo_id',
        ]);
        $this->belongsTo('Instituicaoestagios', [
            'foreignKey' => 'id_instituicao',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Supervisores', [
            'foreignKey' => 'id_supervisor',
        ]);
        $this->belongsTo('Docentes', [
            'foreignKey' => 'id_professor',
        ]);
        $this->belongsTo('Areaestagios', [
            'foreignKey' => 'id_area',
        ]);
        $this->belongsTo('Complementos', [
            'foreignKey' => 'complemento_id',
        ]);
        $this->hasOne('Avaliacoes', [
            'foreignKey' => 'estagiario_id',
        ]);
        $this->hasOne('Folhadeatividades', [
            'foreignKey' => 'estagiario_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
                ->integer('id')
                ->allowEmptyString('id', null, 'create');

        $validator
                ->integer('registro')
                ->notEmptyString('registro');

        $validator
                ->scalar('ajuste2020')
                ->maxLength('ajuste2020', 1)
                ->notEmptyString('ajuste2020');

        $validator
                ->scalar('turno')
                ->maxLength('turno', 1)
                ->notEmptyString('turno');

        $validator
                ->scalar('nivel')
                ->maxLength('nivel', 1)
                ->notEmptyString('nivel');

        $validator
                ->notEmptyString('tc');

        $validator
                ->date('tc_solicitacao')
                ->allowEmptyDate('tc_solicitacao');

        $validator
                ->notEmptyString('id_instituicao', 'Selecione uma instituicao');

        $validator
                ->allowEmptyString('id_supervisor');

        $validator
                ->scalar('periodo')
                ->maxLength('periodo', 6)
                ->notEmptyString('periodo');

        $validator
                ->decimal('nota')
                ->allowEmptyString('nota');

        $validator
                ->allowEmptyString('ch');

        $validator
                ->scalar('observacoes')
                ->maxLength('observacoes', 255)
                ->allowEmptyString('observacoes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn(['id_aluno'], 'Alunos'), ['errorField' => 'id_aluno']);
        $rules->add($rules->existsIn(['alunonovo_id'], 'Estudantes'), ['errorField' => 'alunonovo_id']);
        $rules->add($rules->existsIn(['id_instituicao'], 'Instituicaoestagios'), ['errorField' => 'id_instituicao']);
        // $rules->add($rules->existsIn(['id_supervisor'], 'Supervisores'), ['errorField' => 'id_supervisor']);
        $rules->add($rules->existsIn(['id_professor'], 'Docentes'), ['errorField' => 'id_professor']);
        $rules->add($rules->existsIn(['id_area'], 'Areaestagios'), ['errorField' => 'id_area']);

        return $rules;
    }
}
