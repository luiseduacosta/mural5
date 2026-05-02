<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Professor Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string $siape
 * @property string $cress
 * @property string $regiao
 * @property string $codigo_telefone
 * @property string $telefone
 * @property string $codigo_celular
 * @property string $celular
 * @property string $email
 * @property string|null $curriculolattes
 * @property \Cake\I18n\FrozenDate|null $atualizacaolattes
 * @property \Cake\I18n\FrozenDate|null $dataingresso
 * @property string|null $departamento
 * @property \Cake\I18n\FrozenDate|null $dataegresso
 * @property string|null $motivoegresso
 * @property string|null $observacoes
 * @property int|null $user_id
 * @property int|null $estagiario_count
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 */
class Professor extends Entity
{
    protected array $_accessible = [
        'nome' => true,
        'cpf' => true,
        'siape' => true,
        'cress' => true,
        'regiao' => true,
        'codigo_telefone' => true,
        'telefone' => true,
        'codigo_celular' => true,
        'celular' => true,
        'email' => true,
        'curriculolattes' => true,
        'atualizacaolattes' => true,
        'dataingresso' => true,
        'departamento' => true,
        'dataegresso' => true,
        'motivoegresso' => true,
        'observacoes' => true,
        'estagiario_count' => true,
        'user_id' => true,
        'user' => true,
        'estagiarios' => true,
    ];
}
