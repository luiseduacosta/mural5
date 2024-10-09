<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VisitasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VisitasTable Test Case
 */
class VisitasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VisitasTable
     */
    protected $Visitas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Visitas',
        'app.Instituicoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Visitas') ? [] : ['className' => VisitasTable::class];
        $this->Visitas = $this->getTableLocator()->get('Visitas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Visitas);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
