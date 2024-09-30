<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Instituicaoestagios Model
 *
 * @property \App\Model\Table\AreainstituicoesTable&\Cake\ORM\Association\BelongsTo $Areainstituicoes
 * @property \App\Model\Table\AreaestagiosTable&\Cake\ORM\Association\BelongsTo $Areaestagios
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\HasMany $Estagiarios
 * @property \App\Model\Table\MuralestagiosTable&\Cake\ORM\Association\HasMany $Muralestagios
 * @property \App\Model\Table\VisitasTable&\Cake\ORM\Association\HasMany $Visitas
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsToMany $Supervisores
 *
 * @method \App\Model\Entity\Instituicaoestagio newEmptyEntity()
 * @method \App\Model\Entity\Instituicaoestagio newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Instituicaoestagio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Instituicaoestagio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Instituicaoestagio findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Instituicaoestagio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Instituicaoestagio[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Instituicaoestagio|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Instituicaoestagio saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Instituicaoestagio[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Instituicaoestagio[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Instituicaoestagio[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Instituicaoestagio[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class InstituicaoestagiosTable extends Table
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

        $this->setTable('estagio');
        $this->setAlias('Instituicaoestagios');
        $this->setDisplayField('instituicao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Areainstituicoes', [
            'foreignKey' => 'area_instituicoes_id',
        ]);
        $this->belongsTo('Areaestagios', [
            'foreignKey' => 'area',
        ]);        
        $this->hasMany('Estagiarios', [
            'foreignKey' => 'id_instituicao',
        ]);
        $this->hasMany('Muralestagios', [
            'foreignKey' => 'id_estagio',
        ]);
        $this->hasMany('Visitas', [
            'foreignKey' => 'estagio_id',
        ]);
        $this->belongsToMany('Supervisores', [
            'foreignKey' => 'id_instituicao',
            'targetForeignKey' => 'id_supervisor',
            'joinTable' => 'inst_super',
        ]);
    }
    
    public function beforeFind($event, $query, $options, $primary) {

        $query->order(['instituicao' => 'ASC']);
        return $query;
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
            ->scalar('instituicao')
            ->maxLength('instituicao', 120)
            ->notEmptyString('instituicao');

        $validator
            ->allowEmptyString('area');

        $validator
            ->scalar('natureza')
            ->maxLength('natureza', 50)
            ->allowEmptyString('natureza');

        $validator
            ->scalar('cnpj')
            ->maxLength('cnpj', 18)
            ->requirePresence('cnpj', 'create')
            ->notEmptyString('cnpj');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('url')
            ->maxLength('url', 100)
            ->allowEmptyString('url');

        $validator
            ->scalar('endereco')
            ->maxLength('endereco', 105)
            ->notEmptyString('endereco');

        $validator
            ->scalar('bairro')
            ->maxLength('bairro', 30)
            ->requirePresence('bairro', 'create')
            ->notEmptyString('bairro');

        $validator
            ->scalar('municipio')
            ->maxLength('municipio', 30)
            ->requirePresence('municipio', 'create')
            ->notEmptyString('municipio');

        $validator
            ->scalar('cep')
            ->maxLength('cep', 9)
            ->notEmptyString('cep');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 50)
            ->notEmptyString('telefone');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 20)
            ->allowEmptyString('fax');

        $validator
            ->scalar('beneficio')
            ->maxLength('beneficio', 50)
            ->allowEmptyString('beneficio');

        $validator
            ->scalar('fim_de_semana')
            ->maxLength('fim_de_semana', 1)
            ->allowEmptyString('fim_de_semana');

        $validator
            ->scalar('localInscricao')
            ->notEmptyString('localInscricao');

        $validator
            ->integer('convenio')
            ->requirePresence('convenio', 'create')
            ->allowEmptyString('convenio');

        $validator
            ->date('expira')
            ->allowEmptyDate('expira');

        $validator
            ->scalar('seguro')
            ->maxLength('seguro', 1)
            ->requirePresence('seguro', 'create')
            ->notEmptyString('seguro');

        $validator
            ->scalar('avaliacao')
            ->notEmptyString('avaliacao');

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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['area'], 'Areaestagios'), ['errorField' => 'area']);

        return $rules;
    }
}
