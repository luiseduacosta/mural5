<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TurnosTable;
use Cake\TestSuite\TestCase;

class TurnosTableTest extends TestCase
{
    protected $Turnos;

    protected array $fixtures = [
        'app.Turnos',
        'app.Alunos',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Turnos') ? [] : ['className' => TurnosTable::class];
        $this->Turnos = $this->getTableLocator()->get('Turnos', $config);
    }

    public function tearDown(): void
    {
        unset($this->Turnos);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('turnos', $this->Turnos->getTable());
        $this->assertSame('Turnos', $this->Turnos->getAlias());
        $this->assertSame('turno', $this->Turnos->getDisplayField());
        $this->assertSame('id', $this->Turnos->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Turnos->getValidator();

        $errors = $validator->validate([
            'turno' => 'Manhã',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }
}
