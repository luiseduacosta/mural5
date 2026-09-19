<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AvaliacoesFixture
 */
class AvaliacoesFixture extends TestFixture
{
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
                'estagiario_id' => 1,
                'avaliacao1' => '',
                'avaliacao2' => '',
                'avaliacao3' => '',
                'avaliacao4' => '',
                'avaliacao5' => '',
                'avaliacao6' => '',
                'avaliacao7' => '',
                'avaliacao8' => '',
                'avaliacao9' => '',
                'avaliacao9_1' => 'Lorem ipsum dolor sit amet',
                'avaliacao10' => '',
                'avaliacao10_1' => 'Lorem ipsum dolor sit amet',
                'avaliacao11' => '',
                'avaliacao11_1' => 'Lorem ipsum dolor sit amet',
                'avaliacao12' => '',
                'avaliacao12_1' => 'Lorem ipsum dolor sit amet',
                'avaliacao13' => '',
                'avaliacao13_1' => 'Lorem ipsum dolor sit amet',
                'avaliacao14' => 'Lorem ipsum dolor sit amet',
                'observacoes' => 'Lorem ipsum dolor sit amet',
                'TIMESTAMP' => 1778438008,
            ],
        ];
        parent::init();
    }
}
