<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

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
        'estagiarios' => true,
        'instituicoes' => true,
    ];
}
