<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstagiariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstagiariosTable Test Case
 */
class EstagiariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstagiariosTable
     */
    protected $Estagiarios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Estagiarios',
        'app.Alunos',
        'app.Instituicoes',
        'app.Supervisores',
        'app.Professores',
        'app.Turmaestagios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Estagiarios') ? [] : ['className' => EstagiariosTable::class];
        $this->Estagiarios = $this->getTableLocator()->get('Estagiarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Estagiarios);

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
