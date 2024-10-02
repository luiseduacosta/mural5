<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TurmaestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TurmaestagiosTable Test Case
 */
class TurmaestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TurmaestagiosTable
     */
    protected $Turmaestagios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Turmaestagios',
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
        $config = $this->getTableLocator()->exists('Turmaestagios') ? [] : ['className' => TurmaestagiosTable::class];
        $this->Turmaestagios = $this->getTableLocator()->get('Turmaestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Turmaestagios);

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
