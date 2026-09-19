<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FolhadeatividadesFixture
 */
class FolhadeatividadesFixture extends TestFixture
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
                'dia' => '2026-05-10',
                'inicio' => '15:34:04',
                'final' => '16:34:04',
                'atividade' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
