<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ProfessoresFixture extends TestFixture
{
    public string $table = 'professores';

    public array $fields = [
        'id' => ['type' => 'integer', 'autoIncrement' => true],
        'nome' => ['type' => 'string', 'length' => 50, 'null' => false],
        'cpf' => ['type' => 'string', 'length' => 14, 'null' => true],
        'siape' => ['type' => 'integer', 'length' => 8, 'null' => false, 'unsigned' => true],
        'cress' => ['type' => 'integer', 'length' => 10, 'null' => true, 'unsigned' => true],
        'regiao' => ['type' => 'integer', 'length' => 2, 'null' => true, 'unsigned' => true],
        'codigo_telefone' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => '21'],
        'telefone' => ['type' => 'string', 'length' => 15, 'null' => true],
        'codigo_celular' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => '21'],
        'celular' => ['type' => 'string', 'length' => 15, 'null' => true],
        'email' => ['type' => 'string', 'length' => 40, 'null' => true],
        'curriculolattes' => ['type' => 'string', 'length' => 50, 'null' => true],
        'atualizacaolattes' => ['type' => 'date', 'null' => true],
        'dataingresso' => ['type' => 'date', 'null' => true],
        'departamento' => ['type' => 'string', 'length' => 30, 'null' => true],
        'dataegresso' => ['type' => 'date', 'null' => true],
        'motivoegresso' => ['type' => 'string', 'length' => 100, 'null' => true],
        'status' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => 'ativo'],
        'observacoes' => ['type' => 'text', 'null' => true],
        'user_id' => ['type' => 'integer', 'null' => true],
        'estagiarios_count' => ['type' => 'integer', 'null' => true],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nome' => 'Professor Teste',
                'cpf' => '123.456.789-00',
                'siape' => 1234567,
                'cress' => 12345,
                'regiao' => 7,
                'codigo_telefone' => '21',
                'telefone' => '2125551234',
                'codigo_celular' => '21',
                'celular' => '21988887777',
                'email' => 'professor@test.com',
                'curriculolattes' => '1234567890123456',
                'atualizacaolattes' => '2026-01-15',
                'dataingresso' => '2010-03-01',
                'departamento' => 'Fundamentos',
                'status' => 'ativo',
                'observacoes' => 'Observação de teste',
                'user_id' => 3,
                'estagiarios_count' => 0,
            ],
        ];
        parent::init();
    }
}
