<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

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
        'user_id' => true,
        'user' => true,
        'estagiarios' => true,
    ];
}
