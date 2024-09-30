<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstituicaoestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstituicaoestagiosTable Test Case
 */
class InstituicaoestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InstituicaoestagiosTable
     */
    protected $Instituicaoestagios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Instituicaoestagios',
        'app.Areainstituicoes',
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
        $config = $this->getTableLocator()->exists('Instituicaoestagios') ? [] : ['className' => InstituicaoestagiosTable::class];
        $this->Instituicaoestagios = $this->getTableLocator()->get('Instituicaoestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Instituicaoestagios);

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
