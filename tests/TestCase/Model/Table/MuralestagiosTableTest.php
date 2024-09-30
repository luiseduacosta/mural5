<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MuralestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MuralestagiosTable Test Case
 */
class MuralestagiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MuralestagiosTable
     */
    protected $Muralestagios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Muralestagios',
        'app.Instituicaoestagios',
        'app.Areaestagios',
        'app.Professores',
        'app.Muralinscricoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Muralestagios') ? [] : ['className' => MuralestagiosTable::class];
        $this->Muralestagios = $this->getTableLocator()->get('Muralestagios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Muralestagios);

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
