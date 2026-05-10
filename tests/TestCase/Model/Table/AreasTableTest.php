<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreasTable Test Case
 */
class AreasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreasTable
     */
    protected $Areas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Areas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Areas') ? [] : ['className' => AreasTable::class];
        $this->Areas = $this->getTableLocator()->get('Areas', $config);
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
        $validator = $this->Areas->getValidator();

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
        $this->assertSame('areas', $this->Areas->getTable());
        $this->assertSame('Areas', $this->Areas->getAlias());
        $this->assertSame('area', $this->Areas->getDisplayField());
        $this->assertSame('id', $this->Areas->getPrimaryKey());
    }
}
