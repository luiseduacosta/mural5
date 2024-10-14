<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\EstudantesTable&\Cake\ORM\Association\BelongsTo $Alunos
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsTo $Supervisores
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsTo $Professores
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
class UsersTable extends Table
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
        $this->setAlias('Users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->belongsTo('Alunos', [
            'foreignKey' => 'aluno_id',
        ]);        
        $this->belongsTo('Supervisores', [
            'foreignKey' => 'supervisor_id',
        ]);
        $this->belongsTo('Professores', [
            'foreignKey' => 'professor_id',
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
            ->scalar('categoria_id')
            ->notEmptyString('categoria_id');

        $validator
            ->integer('registro')
            ->requirePresence('registro', 'create')
            ->notEmptyString('registro');

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
        $rules->add($rules->existsIn(['aluno_id'], 'Alunos'), ['errorField' => 'aluno_id']);
        $rules->add($rules->existsIn(['supervisor_id'], 'Supervisores'), ['errorField' => 'supervisor_id']);
        $rules->add($rules->existsIn(['professor_id'], 'Professores'), ['errorField' => 'professor_id']);

        return $rules;
    }
}
