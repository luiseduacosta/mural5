<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RespostasTable;
use Cake\TestSuite\TestCase;

class RespostasTableTest extends TestCase
{
    protected $Respostas;

    protected array $fixtures = [
        'app.Respostas',
        'app.Questionarios',
        'app.Estagiarios',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Respostas') ? [] : ['className' => RespostasTable::class];
        $this->Respostas = $this->getTableLocator()->get('Respostas', $config);
    }

    public function tearDown(): void
    {
        unset($this->Respostas);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('respostas', $this->Respostas->getTable());
        $this->assertSame('id', $this->Respostas->getDisplayField());
        $this->assertSame('id', $this->Respostas->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Respostas->getValidator();

        $errors = $validator->validate([
            'questionario_id' => 1,
            'estagiario_id' => 1,
            'response' => 'Test Response',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }

    public function testBuildRules(): void
    {
        $rules = $this->Respostas->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }
}
