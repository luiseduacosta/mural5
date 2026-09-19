<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class AreasFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'area' => ['type' => 'string', 'length' => 90, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'area' => 'Saúde',
            ],
            [
                'id' => 2,
                'area' => 'Educação',
            ],
            [
                'id' => 3,
                'area' => 'Assistência Social',
            ],
        ];
        parent::init();
    }
}
