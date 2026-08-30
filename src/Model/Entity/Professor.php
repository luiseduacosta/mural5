<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Professor Entity
 *
 * @property int $id
 * @property string $nome
 * @property string|null $cpf
 * @property int $siape
 * @property int|null $cress
 * @property int|null $regiao
 * @property string $codigo_telefone
 * @property string|null $telefone
 * @property string $codigo_celular
 * @property string|null $celular
 * @property string|null $email
 * @property string|null $curriculolattes
 * @property \Cake\I18n\Date|null $atualizacaolattes
 * @property \Cake\I18n\Date|null $dataingresso
 * @property string|null $departamento
 * @property \Cake\I18n\Date|null $dataegresso
 * @property string|null $motivoegresso
 * @property string|null $observacoes
 * @property string $status
 * @property int|null $user_id
 * @property int|null $estagiarios_count
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
        'estagiarios_count' => true,
        'status' => true,
        'user_id' => true,
        'user' => true,
        'estagiarios' => true,
    ];
}
