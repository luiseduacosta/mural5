<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MuralinscricoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MuralinscricoesTable Test Case
 */
class InscricoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MuralinscricoesTable
     */
    protected $Inscricoes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Inscricoes') ? [] : ['className' => InscricoesTable::class];
        $this->Inscricoes = $this->getTableLocator()->get('Inscricoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Inscricoes);

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
