<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class AlunosFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nome' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'nomesocial' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ingresso' => ['type' => 'string', 'length' => 6, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'turno_id' => ['type' => 'string', 'length' => 7, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'registro' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'codigo_telefone' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '21', 'comment' => '', 'precision' => null],
        'telefone' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'codigo_celular' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '21', 'comment' => '', 'precision' => null],
        'celular' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'cpf' => ['type' => 'string', 'length' => 14, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'identidade' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'orgao' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'nascimento' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'endereco' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'cep' => ['type' => 'string', 'length' => 9, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'municipio' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'bairro' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'observacoes' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'registro' => ['type' => 'unique', 'columns' => ['registro'], 'length' => []],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nome' => 'Test Student',
                'nomesocial' => null,
                'ingresso' => '2025-1',
                'turno_id' => 1,
                'registro' => 123456789,
                'codigo_telefone' => 21,
                'telefone' => '22334455',
                'codigo_celular' => 21,
                'celular' => '987654321',
                'email' => 'test@estudante.com',
                'cpf' => '123.456.789-00',
                'identidade' => '123456789',
                'orgao' => 'DETRAN',
                'nascimento' => '2000-01-15',
                'endereco' => 'Rua Teste, 123',
                'cep' => '21999-000',
                'municipio' => 'Rio de Janeiro',
                'bairro' => 'Centro',
                'observacoes' => 'Test student',
                'user_id' => 2,
            ],
        ];
        parent::init();
    }
}