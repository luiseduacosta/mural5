<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RespostasFixture
 */
class RespostasFixture extends TestFixture
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
                'questionario_id' => 1,
                'estagiario_id' => 1,
                'response' => json_encode(['avaliacao1' => 'Test']),
                'created' => '2026-05-10 15:34:53',
                'modified' => '2026-05-10 15:34:53',
            ],
        ];
        parent::init();
    }
}
