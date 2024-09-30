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
    protected $Areainstituicoes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Areainstituicoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Areainstituicoes') ? [] : ['className' => AreainstituicoesTable::class];
        $this->Areainstituicoes = $this->getTableLocator()->get('Areainstituicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Areainstituicoes);

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
