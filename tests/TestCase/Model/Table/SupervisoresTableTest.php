<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SupervisoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SupervisoresTable Test Case
 */
class SupervisoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SupervisoresTable
     */
    protected $Supervisores;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Supervisores',
        'app.Estagiarios',
        'app.Users',
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
        $config = $this->getTableLocator()->exists('Supervisores') ? [] : ['className' => SupervisoresTable::class];
        $this->Supervisores = $this->getTableLocator()->get('Supervisores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Supervisores);

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
