<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SupervisoresTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('supervisores');
        $this->setAlias('Supervisores');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->hasMany('Estagiarios', [
            'foreignKey' => 'supervisor_id',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsToMany('Instituicoes', [
            'foreignKey' => 'supervisor_id',
            'targetForeignKey' => 'instituicao_id',
            'joinTable' => 'inst_super',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('nome')
            ->maxLength('nome', 70)
            ->notEmptyString('nome');

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 14)
            ->regex('cpf', '/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$/', 'CPF inválido')
            ->allowEmptyString('cpf');

        $validator
            ->scalar('endereco')
            ->maxLength('endereco', 100)
            ->allowEmptyString('endereco');

        $validator
            ->scalar('bairro')
            ->maxLength('bairro', 30)
            ->allowEmptyString('bairro');

        $validator
            ->scalar('municipio')
            ->maxLength('municipio', 30)
            ->allowEmptyString('municipio');

        $validator
            ->scalar('cep')
            ->maxLength('cep', 9)
            ->regex('cep', '/^[0-9]{5}-[0-9]{3}$/', 'CEP inválido')
            ->allowEmptyString('cep');

        $validator
            ->scalar('codigo_telefone')
            ->maxLength('codigo_telefone', 2)
            ->allowEmptyString('codigo_telefone');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 15)
            ->allowEmptyString('telefone');

        $validator
            ->scalar('codigo_celular')
            ->maxLength('codigo_celular', 2)
            ->allowEmptyString('codigo_celular');

        $validator
            ->scalar('celular')
            ->maxLength('celular', 15)
            ->allowEmptyString('celular');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('escola')
            ->maxLength('escola', 70)
            ->allowEmptyString('escola');

        $validator
            ->scalar('ano_formatura')
            ->maxLength('ano_formatura', 4)
            ->allowEmptyString('ano_formatura');

        $validator
            ->integer('cress')
            ->notEmptyString('cress', null, 'create');

        $validator
            ->integer('regiao')
            ->maxLength('regiao', 2)
            ->notEmptyString('regiao', null, 'create');

        $validator
            ->scalar('cargo')
            ->maxLength('cargo', 25)
            ->allowEmptyString('cargo');

        $validator
            ->scalar('observacoes')
            ->allowEmptyString('observacoes');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        return $validator;
    }
}
