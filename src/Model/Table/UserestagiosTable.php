<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Userestagios Model
 *
 * @property \App\Model\Table\EstudantesTable&\Cake\ORM\Association\BelongsTo $Estudantes
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsTo $Supervisores
 * @property \App\Model\Table\DocentesTable&\Cake\ORM\Association\BelongsTo $Docentes
 *
 * @method \App\Model\Entity\Userestagio newEmptyEntity()
 * @method \App\Model\Entity\Userestagio newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Userestagio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Userestagio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Userestagio findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Userestagio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Userestagio[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Userestagio|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Userestagio saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Userestagio[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Userestagio[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Userestagio[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Userestagio[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UserestagiosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setAlias('Userestagios');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->belongsTo('Estudantes', [
            'foreignKey' => 'estudante_id',
        ]);
        
        $this->belongsTo('Supervisores', [
            'foreignKey' => 'supervisor_id',
        ]);
        $this->belongsTo('Docentes', [
            'foreignKey' => 'docente_id',
        ]);
        
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->email('email')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 50)
            ->notEmptyString('password');

        $validator
            ->scalar('categoria')
            ->notEmptyString('categoria');

        $validator
            ->integer('numero')
            ->requirePresence('numero', 'create')
            ->notEmptyString('numero');

        $validator
            /* ->dateTime('timestamp') */
            ->notEmptyDateTime('timestamp');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['estudante_id'], 'Estudantes'), ['errorField' => 'estudante_id']);
        $rules->add($rules->existsIn(['supervisor_id'], 'Supervisores'), ['errorField' => 'supervisor_id']);
        $rules->add($rules->existsIn(['docente_id'], 'Docentes'), ['errorField' => 'docente_id']);

        return $rules;
    }
}
