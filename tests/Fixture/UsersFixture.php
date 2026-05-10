<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nome' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'email' => ['type' => 'char', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'password' => ['type' => 'char', 'length' => 80, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'categoria' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => '2', 'comment' => '1=Admin, 2=Aluno, 3=Professor, 4=Supervisor', 'precision' => null],
        'role' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => 'aluno', 'comment' => '', 'precision' => null],
        'identificacao' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'DRE/Siape/CRESS', 'precision' => null],
        'entidade_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'aluno_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'supervisor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'professor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ativo' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'criado_em' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'atualizado_em' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nome' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => '$2y$10$8x/XdBG1gVAFKb5.B8c5heGFFxpSpZH5HJZrczICtMHDplSQujfZm',
                'categoria' => '1',
                'role' => 'admin',
                'identificacao' => 1,
                'aluno_id' => null,
                'supervisor_id' => null,
                'professor_id' => null,
                'ativo' => 1,
            ],
            [
                'id' => 2,
                'nome' => 'Aluno Test',
                'email' => 'aluno@test.com',
                'password' => '$2y$10$8x/XdBG1gVAFKb5.B8c5heGFFxpSpZH5HJZrczICtMHDplSQujfZm',
                'categoria' => '2',
                'role' => 'aluno',
                'identificacao' => 123456789,
                'aluno_id' => 1,
                'supervisor_id' => null,
                'professor_id' => null,
                'ativo' => 1,
            ],
            [
                'id' => 3,
                'nome' => 'Professor Test',
                'email' => 'professor@test.com',
                'password' => '$2y$10$8x/XdBG1gVAFKb5.B8c5heGFFxpSpZH5HJZrczICtMHDplSQujfZm',
                'categoria' => '3',
                'role' => 'professor',
                'identificacao' => 1234567,
                'aluno_id' => null,
                'supervisor_id' => null,
                'professor_id' => 1,
                'ativo' => 1,
            ],
            [
                'id' => 4,
                'nome' => 'Supervisor Test',
                'email' => 'supervisor@test.com',
                'password' => '$2y$10$8x/XdBG1gVAFKb5.B8c5heGFFxpSpZH5HJZrczICtMHDplSQujfZm',
                'categoria' => '4',
                'role' => 'supervisor',
                'identificacao' => 12345,
                'aluno_id' => null,
                'supervisor_id' => 1,
                'professor_id' => null,
                'ativo' => 1,
            ],
        ];
        parent::init();
    }
}
