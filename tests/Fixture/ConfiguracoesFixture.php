<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ConfiguracoesFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'instituicao' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => 'ESS/UFRJ', 'comment' => '', 'precision' => null],
        'mural_periodo_atual' => ['type' => 'char', 'length' => 6, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'curso_turma_atual' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'curso_abertura_inscricoes' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'curso_encerramento_inscricoes' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'termo_compromisso_periodo' => ['type' => 'char', 'length' => 6, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'termo_compromisso_inicio' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'termo_compromisso_final' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'periodo_calendario_academico' => ['type' => 'char', 'length' => 6, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'instituicao' => 'ESS/UFRJ',
                'mural_periodo_atual' => '2026-1',
                'curso_turma_atual' => 1,
                'curso_abertura_inscricoes' => '2026-02-01',
                'curso_encerramento_inscricoes' => '2026-02-28',
                'termo_compromisso_periodo' => '2026-1',
                'termo_compromisso_inicio' => '2026-03-01',
                'termo_compromisso_final' => '2026-07-31',
                'periodo_calendario_academico' => '2026-1',
            ],
        ];
        parent::init();
    }
}
