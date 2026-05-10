<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfessoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfessoresTable Test Case
 */
class ProfessoresTableTest extends TestCase
{
    protected $Professores;

    protected array $fixtures = [
        'app.Professores',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Users',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Professores') ? [] : ['className' => ProfessoresTable::class];
        $this->Professores = $this->getTableLocator()->get('Professores', $config);
    }

    public function tearDown(): void
    {
        unset($this->Professores);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('professores', $this->Professores->getTable());
        $this->assertSame('Professores', $this->Professores->getAlias());
        $this->assertSame('nome', $this->Professores->getDisplayField());
        $this->assertSame('id', $this->Professores->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Professores->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => 1234567,
            'email' => 'professor@test.com',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'nome' => '',
            'siape' => 1234567,
        ]);
        $this->assertArrayHasKey('nome', $errors, 'Empty nome should fail');

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => '',
        ]);
        $this->assertArrayHasKey('siape', $errors, 'Empty siape should fail');

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => 1234567,
            'email' => 'invalid-email',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Invalid email should fail');
    }

    public function testAssociations(): void
    {
        $this->assertTrue($this->Professores->hasAssociation('Users'));
        $this->assertTrue($this->Professores->hasAssociation('Estagiarios'));
    }
}
