<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoriasTable;
use Cake\TestSuite\TestCase;

class CategoriasTableTest extends TestCase
{
    protected $Categorias;

    protected array $fixtures = [
        'app.Categorias',
        'app.Users',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Categorias') ? [] : ['className' => CategoriasTable::class];
        $this->Categorias = $this->getTableLocator()->get('Categorias', $config);
    }

    public function tearDown(): void
    {
        unset($this->Categorias);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('categorias', $this->Categorias->getTable());
        $this->assertSame('Categorias', $this->Categorias->getAlias());
        $this->assertSame('categoria', $this->Categorias->getDisplayField());
        $this->assertSame('id', $this->Categorias->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Categorias->getValidator();

        $errors = $validator->validate([
            'categoria' => 'Test Category',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }
}
