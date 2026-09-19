<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdministradoresTable;
use Cake\TestSuite\TestCase;

class AdministradoresTableTest extends TestCase
{
    protected $Administradores;

    protected array $fixtures = [
        'app.Administradores',
        'app.Users',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Administradores') ? [] : ['className' => AdministradoresTable::class];
        $this->Administradores = $this->getTableLocator()->get('Administradores', $config);
    }

    public function tearDown(): void
    {
        unset($this->Administradores);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('administradores', $this->Administradores->getTable());
        $this->assertSame('Administradores', $this->Administradores->getAlias());
        $this->assertSame('nome', $this->Administradores->getDisplayField());
        $this->assertSame('id', $this->Administradores->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Administradores->getValidator();

        $errors = $validator->validate([
            'nome' => 'Test Admin',
            'user_id' => 1,
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }
}
