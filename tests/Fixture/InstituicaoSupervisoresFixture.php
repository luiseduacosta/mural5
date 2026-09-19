<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class InstituicaoSupervisoresFixture extends TestFixture
{
    /**
     * @var string
     */
    public string $table = 'inst_super';

    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'instituicao_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'supervisor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'instituicao_id' => 1,
                'supervisor_id' => 1,
            ],
            [
                'id' => 2,
                'instituicao_id' => 1,
                'supervisor_id' => 2,
            ],
            [
                'id' => 3,
                'instituicao_id' => 2,
                'supervisor_id' => 1,
            ],
        ];
        parent::init();
    }
}
