<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuestionariosTable;
use Cake\TestSuite\TestCase;

class QuestionariosTableTest extends TestCase
{
    protected $Questionarios;

    protected array $fixtures = [
        'app.Questionarios',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Questionarios') ? [] : ['className' => QuestionariosTable::class];
        $this->Questionarios = $this->getTableLocator()->get('Questionarios', $config);
    }

    public function tearDown(): void
    {
        unset($this->Questionarios);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('questionarios', $this->Questionarios->getTable());
        $this->assertSame('title', $this->Questionarios->getDisplayField());
        $this->assertSame('id', $this->Questionarios->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Questionarios->getValidator();

        $errors = $validator->validate([
            'title' => 'Test Questionnaire',
            'description' => 'Test Description',
            'is_active' => true,
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }
}
