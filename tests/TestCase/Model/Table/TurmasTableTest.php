<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TurmasTable;
use Cake\TestSuite\TestCase;

class TurmasTableTest extends TestCase
{
    protected $Turmas;

    protected array $fixtures = [
        'app.Turmas',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Turmas') ? [] : ['className' => TurmasTable::class];
        $this->Turmas = $this->getTableLocator()->get('Turmas', $config);
    }

    public function tearDown(): void
    {
        unset($this->Turmas);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('turmas', $this->Turmas->getTable());
        $this->assertSame('Turmas', $this->Turmas->getAlias());
        $this->assertSame('turma', $this->Turmas->getDisplayField());
        $this->assertSame('id', $this->Turmas->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Turmas->getValidator();

        $errors = $validator->validate([
            'turma' => 'Test Turma',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }
}
