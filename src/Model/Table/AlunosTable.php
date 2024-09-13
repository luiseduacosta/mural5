<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estudantes Model
 *
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\HasMany $Estagiarios
 * @property \App\Model\Table\MuralinscricoesTable&\Cake\ORM\Association\HasMany $Muralinscricoes
 * @property \App\Model\Table\UserestagiosTable&\Cake\ORM\Association\HasMany $Userestagios
 *
 * @method \App\Model\Entity\Estudante newEmptyEntity()
 * @method \App\Model\Entity\Estudante newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Estudante[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estudante get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estudante findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Estudante patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estudante[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estudante|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estudante saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estudante[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estudante[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estudante[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estudante[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AlunosTable extends Table
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

        $this->setTable('alunos');
        $this->setAlias('estudantes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->hasMany('Muralinscricoes', [
            'foreignKey' => 'alunonovo_id',
        ]);
       $this->hasMany('Userestagios', [
            'foreignKey' => 'alunonovo_id',
        ]);
        $this->hasMany('Estagiarios', [
            'foreignKey' => 'alunonovo_id',
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
            ->scalar('nome')
            ->maxLength('nome', 50)
            ->notEmptyString('nome');

        $validator
            ->integer('registro')
            ->notEmptyString('registro')
            ->add('registro', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->notEmptyString('codigo_telefone');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 9)
            ->allowEmptyString('telefone');

        $validator
            ->notEmptyString('codigo_celular');

        $validator
            ->scalar('celular')
            ->maxLength('celular', 10)
            ->allowEmptyString('celular');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 12)
            ->allowEmptyString('cpf');

        $validator
            ->scalar('identidade')
            ->maxLength('identidade', 15)
            ->allowEmptyString('identidade');

        $validator
            ->scalar('orgao')
            ->maxLength('orgao', 10)
            ->allowEmptyString('orgao');

        $validator
            ->date('nascimento')
            ->allowEmptyDate('nascimento');

        $validator
            ->scalar('endereco')
            ->maxLength('endereco', 50)
            ->allowEmptyString('endereco');

        $validator
            ->scalar('cep')
            ->maxLength('cep', 9)
            ->allowEmptyString('cep');

        $validator
            ->scalar('municipio')
            ->maxLength('municipio', 30)
            ->allowEmptyString('municipio');

        $validator
            ->scalar('bairro')
            ->maxLength('bairro', 30)
            ->allowEmptyString('bairro');

        $validator
            ->scalar('observacoes')
            ->maxLength('observacoes', 250)
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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['registro']), ['errorField' => 'registro']);

        return $rules;
    }
}
