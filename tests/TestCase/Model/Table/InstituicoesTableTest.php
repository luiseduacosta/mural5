<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstituicaoTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstituicaoTable Test Case
 */
class InstituicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InstituicoesTable
     */
    protected $Instituicoes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Instituicoes',
        'app.Areas',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Visitas',
        'app.Supervisores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Instituicoes') ? [] : ['className' => InstituicaoTable::class];
        $this->Instituicoes = $this->getTableLocator()->get('Instituicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Instituicoes);

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
