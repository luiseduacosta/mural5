<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuestoesTable;
use Cake\TestSuite\TestCase;

class QuestoesTableTest extends TestCase
{
    protected $Questoes;

    protected array $fixtures = [
        'app.Questoes',
        'app.Questionarios',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Questoes') ? [] : ['className' => QuestoesTable::class];
        $this->Questoes = $this->getTableLocator()->get('Questoes', $config);
    }

    public function tearDown(): void
    {
        unset($this->Questoes);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('questoes', $this->Questoes->getTable());
        $this->assertSame('Questoes', $this->Questoes->getAlias());
        $this->assertSame('type', $this->Questoes->getDisplayField());
        $this->assertSame('id', $this->Questoes->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Questoes->getValidator();

        $errors = $validator->validate([
            'questionario_id' => 1,
            'text' => 'Test Question',
            'type' => 'text',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }

    public function testBuildRules(): void
    {
        $rules = $this->Questoes->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }
}
