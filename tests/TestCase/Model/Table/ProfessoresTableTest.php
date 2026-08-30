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
            'siape' => '1234567',
            'email' => 'professor@test.com',
            'status' => 'ativo',
            'estagiarios_count' => 5,
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'status' => 'too-long-status-string',
        ]);
        $this->assertArrayHasKey('status', $errors, 'Status exceeding maxLength should fail');

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'estagiarios_count' => 'invalid-integer',
        ]);
        $this->assertArrayHasKey('estagiarios_count', $errors, 'Non-integer estagiarios_count should fail');

        $errors = $validator->validate([
            'nome' => '',
            'siape' => '1234567',
        ]);
        $this->assertArrayHasKey('nome', $errors, 'Empty nome should fail');

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => '',
        ]);
        $this->assertArrayHasKey('siape', $errors, 'Empty siape should fail');

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'email' => 'invalid-email',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Invalid email should fail');
    }

    public function testValidationNomeMaxLength(): void
    {
        $validator = $this->Professores->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'nome' => str_repeat('A', 51),
            'siape' => '1234567',
        ]);
        $this->assertArrayHasKey('nome', $errors, 'Nome exceeding 50 chars should fail');

        $errors = $validator->validate([
            'nome' => str_repeat('A', 50),
            'siape' => '1234567',
        ]);
        $this->assertArrayNotHasKey('nome', $errors ?? [], 'Nome at exactly 50 chars should pass');
    }

    public function testValidationStatusInList(): void
    {
        $validator = $this->Professores->validationDefault(new \Cake\Validation\Validator());

        foreach ([ProfessoresTable::STATUS_ATIVO, ProfessoresTable::STATUS_APOSENTADO, ProfessoresTable::STATUS_INATIVO] as $status) {
            $errors = $validator->validate([
                'nome' => 'Professor Teste',
                'siape' => '1234567',
                'status' => $status,
            ]);
            $this->assertArrayNotHasKey('status', $errors ?? [], "Status {$status} should pass");
        }

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'status' => 'desconhecido',
        ]);
        $this->assertArrayHasKey('status', $errors, 'Status outside the allowed list should fail');
    }

    public function testBeforeMarshalNormalizesStatusAliases(): void
    {
        $entity = $this->Professores->newEntity([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'status' => 'active',
        ]);
        $this->assertSame(ProfessoresTable::STATUS_ATIVO, $entity->status);

        $entity = $this->Professores->newEntity([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'status' => 'retired',
        ]);
        $this->assertSame(ProfessoresTable::STATUS_APOSENTADO, $entity->status);

        $entity = $this->Professores->newEntity([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'status' => 'inactive',
        ]);
        $this->assertSame(ProfessoresTable::STATUS_INATIVO, $entity->status);
    }

    public function testBeforeMarshalDropsEmptyStatus(): void
    {
        $entity = $this->Professores->newEntity([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'status' => '',
        ]);
        $this->assertFalse($entity->has('status'), 'Empty status should be dropped so the DB default applies');
    }

    public function testValidationCurriculoLattesMaxLength(): void
    {
        $validator = $this->Professores->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'curriculolattes' => str_repeat('x', 51),
        ]);
        $this->assertArrayHasKey('curriculolattes', $errors, 'Curriculolattes exceeding 50 chars should fail');
    }

    public function testValidationAtualizacaoLattesDate(): void
    {
        $validator = $this->Professores->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'nome' => 'Professor Teste',
            'siape' => '1234567',
            'atualizacaolattes' => 'not-a-date',
        ]);
        $this->assertArrayHasKey('atualizacaolattes', $errors, 'Invalid date for atualizacaolattes should fail');
    }

    public function testAssociations(): void
    {
        $this->assertTrue($this->Professores->hasAssociation('Users'));
        $this->assertTrue($this->Professores->hasAssociation('Estagiarios'));
    }
}
