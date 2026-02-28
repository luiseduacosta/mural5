<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlunosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlunosTable Test Case
 */
class AlunosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AlunosTable
     */
    protected $Alunos;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Alunos') ? [] : ['className' => AlunosTable::class];
        $this->Alunos = $this->getTableLocator()->get('Alunos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Alunos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $validator = $this->Alunos->validationDefault(new \Cake\Validation\Validator());

        // Test valid data passes
        $errors = $validator->validate([
            'nome' => 'John Doe',
            'registro' => 12345,
            'codigo_telefone' => '021',
            'codigo_celular' => '021',
        ]);
        $this->assertEmpty($errors);

        // Test empty nome fails
        $errors = $validator->validate([
            'nome' => '',
            'registro' => 12345,
            'codigo_telefone' => '021',
        ]);
        $this->assertArrayHasKey('nome', $errors);

        // Test empty registro fails
        $errors = $validator->validate([
            'nome' => 'John Doe',
            'registro' => '',
            'codigo_telefone' => '021',
        ]);
        $this->assertArrayHasKey('registro', $errors);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $rules = $this->Alunos->buildRules(new \Cake\ORM\RulesChecker());

        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->assertSame('alunos', $this->Alunos->getTable());
        $this->assertSame('Alunos', $this->Alunos->getAlias());
        $this->assertSame('nome', $this->Alunos->getDisplayField());
        $this->assertSame('id', $this->Alunos->getPrimaryKey());
    }
}
