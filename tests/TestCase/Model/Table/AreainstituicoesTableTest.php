<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreainstituicoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreainstituicoesTable Test Case
 */
class AreainstituicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreainstituicoesTable
     */
    protected $Areas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Areas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Areas') ? [] : ['className' => AreainstituicoesTable::class];
        $this->Areas = $this->getTableLocator()->get('Areas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Areas);

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
