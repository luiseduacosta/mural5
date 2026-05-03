<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlunosTable;
use Cake\TestSuite\TestCase;

class AlunosTableTest extends TestCase
{
    protected $Alunos;

    protected array $fixtures = [
        'app.alunos',
        'app.turnos',
        'app.users',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Alunos') ? [] : ['className' => AlunosTable::class];
        $this->Alunos = $this->getTableLocator()->get('Alunos', $config);
    }

    public function tearDown(): void
    {
        unset($this->Alunos);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('alunos', $this->Alunos->getTable());
        $this->assertSame('Alunos', $this->Alunos->getAlias());
        $this->assertSame('nome', $this->Alunos->getDisplayField());
        $this->assertSame('id', $this->Alunos->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Alunos->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'nome' => 'John Doe',
            'registro' => 12345,
            'cpf' => '123.456.789-00',
            'nascimento' => '2000-01-15',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'nome' => '',
            'registro' => 12345,
        ]);
        $this->assertArrayHasKey('nome', $errors, 'Empty nome should fail');

        $errors = $validator->validate([
            'nome' => 'John Doe',
            'registro' => '',
        ]);
        $this->assertArrayHasKey('registro', $errors, 'Empty registro should fail');

        $errors = $validator->validate([
            'nome' => 'John Doe',
            'registro' => 12345,
            'email' => 'invalid-email',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Invalid email should fail');
    }

    public function testBuildRules(): void
    {
        $rules = $this->Alunos->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }
}