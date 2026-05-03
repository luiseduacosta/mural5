<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Supervisor Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string $endereco
 * @property string $bairro
 * @property string $municipio
 * @property string $cep
 * @property string $codigo_telefone
 * @property string $telefone
 * @property string $codigo_celular
 * @property string $celular
 * @property string $email
 * @property string $escola
 * @property int $ano_formatura
 * @property string $cress
 * @property string $regiao
 * @property string $cargo
 * @property string|null $observacoes
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 */
class Supervisor extends Entity
{
    protected array $_accessible = [
        'nome' => true,
        'cpf' => true,
        'endereco' => true,
        'bairro' => true,
        'municipio' => true,
        'cep' => true,
        'codigo_telefone' => true,
        'telefone' => true,
        'codigo_celular' => true,
        'celular' => true,
        'email' => true,
        'escola' => true,
        'ano_formatura' => true,
        'cress' => true,
        'regiao' => true,
        'cargo' => true,
        'observacoes' => true,
        'user_id' => true,
        'estagiario_count' => true,
        'estagiarios' => true,
        'instituicoes' => true,
    ];
}
