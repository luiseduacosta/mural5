<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreainstituicoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreainstituicoesTable Test Case
 */
class AreasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreainstituicoesTable
     */
    protected $Areas;

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
        $config = $this->getTableLocator()->exists('Areainstituicoes') ? [] : ['className' => AreainstituicoesTable::class];
        $this->Areas = $this->getTableLocator()->get('Areainstituicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Areas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $validator = $this->Areas->validationDefault(new \Cake\Validation\Validator());

        // Test valid data passes
        $errors = $validator->validate([
            'area' => 'Computer Science',
        ]);
        $this->assertEmpty($errors);

        // Test empty area fails
        $errors = $validator->validate([
            'area' => '',
        ]);
        $this->assertArrayHasKey('area', $errors);

        // Test area too long
        $longArea = str_repeat('a', 91);
        $errors = $validator->validate([
            'area' => $longArea,
        ]);
        $this->assertArrayHasKey('area', $errors);
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->assertSame('area_instituicoes', $this->Areas->getTable());
        $this->assertSame('Areainstituicoes', $this->Areas->getAlias());
        $this->assertSame('area', $this->Areas->getDisplayField());
        $this->assertSame('id', $this->Areas->getPrimaryKey());
    }
}
