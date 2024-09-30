<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MuralinscricoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MuralinscricoesTable Test Case
 */
class MuralinscricoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MuralinscricoesTable
     */
    protected $Muralinscricoes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Muralinscricoes',
        'app.Alunos',
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
        $config = $this->getTableLocator()->exists('Muralinscricoes') ? [] : ['className' => MuralinscricoesTable::class];
        $this->Muralinscricoes = $this->getTableLocator()->get('Muralinscricoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Muralinscricoes);

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
