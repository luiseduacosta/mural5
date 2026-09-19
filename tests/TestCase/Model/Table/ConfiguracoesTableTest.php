<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConfiguracoesTable;
use Cake\TestSuite\TestCase;

class ConfiguracoesTableTest extends TestCase
{
    protected $Configuracoes;

    protected array $fixtures = [
        'app.Configuracoes',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Configuracoes') ? [] : ['className' => ConfiguracoesTable::class];
        $this->Configuracoes = $this->getTableLocator()->get('Configuracoes', $config);
    }

    public function tearDown(): void
    {
        unset($this->Configuracoes);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('configuracoes', $this->Configuracoes->getTable());
        $this->assertSame('Configuracoes', $this->Configuracoes->getAlias());
        $this->assertSame('mural_periodo_atual', $this->Configuracoes->getDisplayField());
        $this->assertSame('id', $this->Configuracoes->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Configuracoes->getValidator();
        $errors = $validator->validate([]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }
}
