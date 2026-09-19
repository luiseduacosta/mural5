<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class CategoriasFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'categoria' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'categoria' => 'Administrador',
            ],
            [
                'id' => 2,
                'categoria' => 'Aluno',
            ],
            [
                'id' => 3,
                'categoria' => 'Professor',
            ],
            [
                'id' => 4,
                'categoria' => 'Supervisor',
            ],
        ];
        parent::init();
    }
}
