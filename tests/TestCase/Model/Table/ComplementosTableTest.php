<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComplementosTable;
use Cake\TestSuite\TestCase;

class ComplementosTableTest extends TestCase
{
    protected $Complementos;

    protected array $fixtures = [
        'app.Complementos',
        'app.Estagiarios',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Complementos') ? [] : ['className' => ComplementosTable::class];
        $this->Complementos = $this->getTableLocator()->get('Complementos', $config);
    }

    public function tearDown(): void
    {
        unset($this->Complementos);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('complementos', $this->Complementos->getTable());
        $this->assertSame('Complementos', $this->Complementos->getAlias());
        $this->assertSame('periodo_especial', $this->Complementos->getDisplayField());
        $this->assertSame('id', $this->Complementos->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Complementos->getValidator();
        $errors = $validator->validate([]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }
}
