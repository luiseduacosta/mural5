<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreaestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreaestagiosTable Test Case
 */
class AreaestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreaestagiosTable
     */
    protected $Areaestagios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Areaestagios',
        'app.Estagiarios',
        'app.Muralestagios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Areaestagios') ? [] : ['className' => AreaestagiosTable::class];
        $this->Areaestagios = $this->getTableLocator()->get('Areaestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Areaestagios);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
