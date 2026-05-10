<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MuralestagiosFixture
 */
class MuralestagiosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'instituicao_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'instituicao' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'convenio' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'vagas' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'beneficios' => ['type' => 'string', 'length' => 70, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'final_de_semana' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'carga_horaria' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'requisitos' => ['type' => 'string', 'length' => 455, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'horario' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'data_selecao' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'data_inscricao' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'horario_selecao' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'local_selecao' => ['type' => 'string', 'length' => 70, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'forma_selecao' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'contato' => ['type' => 'string', 'length' => 70, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'outras' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'periodo' => ['type' => 'string', 'length' => 6, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'local_inscricao' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 70, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'latin1_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'instituicao_id' => 1,
                'instituicao' => 'Lorem ipsum dolor sit amet',
                'convenio' => '1',
                'vagas' => 1,
                'beneficios' => 'VT + VR',
                'final_de_semana' => '0',
                'carga_horaria' => 20,
                'requisitos' => 'Lorem ipsum dolor sit amet',
                'horario' => 'M',
                'data_selecao' => '2020-08-10',
                'data_inscricao' => '2020-08-10',
                'horario_selecao' => '14:00',
                'local_selecao' => 'Sala 101',
                'forma_selecao' => '1',
                'contato' => 'Prof. João Silva',
                'outras' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'periodo' => '2020-2',
                'local_inscricao' => '0',
                'email' => 'teste@mural.com.br',
            ],
        ];
        parent::init();
    }
}
