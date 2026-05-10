<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class SupervisoresFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nome' => ['type' => 'string', 'length' => 70, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'cpf' => ['type' => 'string', 'length' => 14, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'endereco' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'bairro' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'municipio' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'cep' => ['type' => 'string', 'length' => 9, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'codigo_telefone' => ['type' => 'string', 'length' => 2, 'null' => true, 'default' => '21', 'comment' => '', 'precision' => null],
        'telefone' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'codigo_celular' => ['type' => 'string', 'length' => 2, 'null' => true, 'default' => '21', 'comment' => '', 'precision' => null],
        'celular' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'escola' => ['type' => 'string', 'length' => 70, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ano_formatura' => ['type' => 'string', 'length' => 4, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'cress' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'regiao' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '7', 'comment' => '', 'precision' => null],
        'cargo' => ['type' => 'string', 'length' => 25, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'observacoes' => ['type' => 'text', 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nome' => 'Supervisor Teste',
                'cpf' => '123.456.789-00',
                'email' => 'supervisor@test.com',
                'cress' => 12345,
                'regiao' => 7,
                'user_id' => 4,
            ],
        ];
        parent::init();
    }
}
