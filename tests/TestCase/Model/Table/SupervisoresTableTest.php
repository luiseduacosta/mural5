<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SupervisoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SupervisoresTable Test Case
 */
class SupervisoresTableTest extends TestCase
{
    protected $Supervisores;

    protected array $fixtures = [
        'app.Supervisores',
        'app.Estagiarios',
        'app.Users',
        'app.Instituicoes',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Supervisores') ? [] : ['className' => SupervisoresTable::class];
        $this->Supervisores = $this->getTableLocator()->get('Supervisores', $config);
    }

    public function tearDown(): void
    {
        unset($this->Supervisores);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('supervisores', $this->Supervisores->getTable());
        $this->assertSame('Supervisores', $this->Supervisores->getAlias());
        $this->assertSame('nome', $this->Supervisores->getDisplayField());
        $this->assertSame('id', $this->Supervisores->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Supervisores->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'nome' => 'Supervisor Teste',
            'cress' => 12345,
            'regiao' => 7,
            'email' => 'supervisor@test.com',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'nome' => '',
            'cress' => 12345,
            'regiao' => 7,
        ]);
        $this->assertArrayHasKey('nome', $errors, 'Empty nome should fail');

        $errors = $validator->validate([
            'nome' => 'Supervisor Teste',
            'cress' => '',
            'regiao' => 7,
        ]);
        $this->assertArrayHasKey('cress', $errors, 'Empty cress should fail');

        $errors = $validator->validate([
            'nome' => 'Supervisor Teste',
            'cress' => 12345,
            'regiao' => '',
        ]);
        $this->assertArrayHasKey('regiao', $errors, 'Empty regiao should fail');

        $errors = $validator->validate([
            'nome' => 'Supervisor Teste',
            'cress' => 12345,
            'regiao' => 7,
            'email' => 'invalid-email',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Invalid email should fail');

        $errors = $validator->validate([
            'nome' => 'Supervisor Teste',
            'cress' => 12345,
            'regiao' => 7,
            'cpf' => 'invalid-cpf',
        ]);
        $this->assertArrayHasKey('cpf', $errors, 'Invalid CPF should fail');

        $errors = $validator->validate([
            'nome' => 'Supervisor Teste',
            'cress' => 12345,
            'regiao' => 7,
            'cep' => 'invalid-cep',
        ]);
        $this->assertArrayHasKey('cep', $errors, 'Invalid CEP should fail');
    }

    public function testAssociations(): void
    {
        $this->assertTrue($this->Supervisores->hasAssociation('Estagiarios'));
        $this->assertTrue($this->Supervisores->hasAssociation('Users'));
        $this->assertTrue($this->Supervisores->hasAssociation('Instituicoes'));
    }
}
