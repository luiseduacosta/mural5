<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use App\Model\Entity\Professor;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use function is_string;

class ProfessoresTable extends Table
{
    public const STATUS_ATIVO = 'ativo';
    public const STATUS_APOSENTADO = 'aposentado';
    public const STATUS_INATIVO = 'inativo';

    private const STATUS_NORMALIZATION_MAP = [
        'active' => self::STATUS_ATIVO,
        'activo' => self::STATUS_ATIVO,
        'retired' => self::STATUS_APOSENTADO,
        'inactive' => self::STATUS_INATIVO,
        'inactivo' => self::STATUS_INATIVO,
    ];

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('professores');
        $this->setAlias('Professores');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Estagiarios', [
            'foreignKey' => 'professor_id',
        ]);
    }

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
            ->scalar('cpf')
            ->maxLength('cpf', 14)
            ->allowEmptyString('cpf');

        $validator
            ->integer('siape')
            ->notEmptyString('siape');

        $validator
            ->integer('cress')
            ->allowEmptyString('cress');

        $validator
            ->integer('regiao')
            ->allowEmptyString('regiao');

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
            ->maxLength('email', 40)
            ->allowEmptyString('email');

        $validator
            ->scalar('curriculolattes')
            ->maxLength('curriculolattes', 50)
            ->allowEmptyString('curriculolattes');

        $validator
            ->date('atualizacaolattes')
            ->allowEmptyDate('atualizacaolattes');

        $validator
            ->date('dataingresso')
            ->allowEmptyDate('dataingresso');

        $validator
            ->scalar('departamento')
            ->maxLength('departamento', 30)
            ->allowEmptyString('departamento');

        $validator
            ->date('dataegresso')
            ->allowEmptyDate('dataegresso');

        $validator
            ->scalar('motivoegresso')
            ->maxLength('motivoegresso', 100)
            ->allowEmptyString('motivoegresso');

        $validator
            ->scalar('observacoes')
            ->allowEmptyString('observacoes');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->inList('status', [
                self::STATUS_ATIVO,
                self::STATUS_APOSENTADO,
                self::STATUS_INATIVO,
            ], 'Status deve ser um de: ativo, aposentado, inativo.')
            ->allowEmptyString('status');

        $validator
            ->integer('estagiarios_count')
            ->allowEmptyString('estagiarios_count');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), [
            'errorField' => 'user_id',
        ]);

        return $rules;
    }

    /**
     * Normaliza apelidos de status ("active" -> "ativo"...) antes da validação.
     * Um status vazio é removido para manter o valor atual (ou o padrão "ativo").
     */
    public function beforeMarshal(EventInterface $_event, ArrayObject $data, ArrayObject $_options): void
    {
        unset($_event, $_options);

        $status = $data['status'] ?? null;
        if ($status === '') {
            unset($data['status']);

            return;
        }
        if (!is_string($status)) {
            return;
        }

        $data['status'] = self::STATUS_NORMALIZATION_MAP[$status] ?? $status;
    }

    /**
     * Creates a new Professor.
     */
    public function createProfessor(array $data): ?Professor
    {
        $professor = $this->newEmptyEntity();
        return $this->save($this->patchEntity($professor, $data));
    }
}
