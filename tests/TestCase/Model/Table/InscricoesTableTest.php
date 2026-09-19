<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InscricoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InscricoesTable Test Case
 */
class InscricoesTableTest extends TestCase
{
    protected $Inscricoes;

    protected array $fixtures = [
        'app.Inscricoes',
        'app.Alunos',
        'app.Muralestagios',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Inscricoes') ? [] : ['className' => InscricoesTable::class];
        $this->Inscricoes = $this->getTableLocator()->get('Inscricoes', $config);
    }

    public function tearDown(): void
    {
        unset($this->Inscricoes);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('inscricoes', $this->Inscricoes->getTable());
        $this->assertSame('Inscricoes', $this->Inscricoes->getAlias());
        $this->assertSame('registro', $this->Inscricoes->getDisplayField());
        $this->assertSame('id', $this->Inscricoes->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Inscricoes->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'registro' => 123456789,
            'aluno_id' => 1,
            'muralestagio_id' => 1,
            'data' => '2026-03-15',
            'periodo' => '2026-1',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'registro' => '',
            'aluno_id' => 1,
            'muralestagio_id' => 1,
            'data' => '2026-03-15',
            'periodo' => '2026-1',
        ]);
        $this->assertArrayHasKey('registro', $errors, 'Empty registro should fail');

        $errors = $validator->validate([
            'registro' => 123456789,
            'aluno_id' => '',
            'muralestagio_id' => 1,
            'data' => '2026-03-15',
            'periodo' => '2026-1',
        ]);
        $this->assertArrayHasKey('aluno_id', $errors, 'Empty aluno_id should fail');

        $errors = $validator->validate([
            'registro' => 123456789,
            'aluno_id' => 1,
            'muralestagio_id' => '',
            'data' => '2026-03-15',
            'periodo' => '2026-1',
        ]);
        $this->assertArrayHasKey('muralestagio_id', $errors, 'Empty muralestagio_id should fail');

        $errors = $validator->validate([
            'registro' => 123456789,
            'aluno_id' => 1,
            'muralestagio_id' => 1,
            'data' => '',
            'periodo' => '2026-1',
        ]);
        $this->assertArrayHasKey('data', $errors, 'Empty data should fail');

        $errors = $validator->validate([
            'registro' => 123456789,
            'aluno_id' => 1,
            'muralestagio_id' => 1,
            'data' => '2026-03-15',
            'periodo' => '',
        ]);
        $this->assertArrayHasKey('periodo', $errors, 'Empty periodo should fail');

        $errors = $validator->validate([
            'registro' => 123456789,
            'aluno_id' => 1,
            'muralestagio_id' => 1,
            'data' => '2026-03-15',
            'periodo' => '2026-1',
        ]);
        $this->assertEmpty($errors, 'Periodo should pass: ' . print_r($errors, true));
    }

    public function testBuildRules(): void
    {
        $rules = $this->Inscricoes->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }

    public function testAssociations(): void
    {
        $this->assertTrue($this->Inscricoes->hasAssociation('Alunos'));
        $this->assertTrue($this->Inscricoes->hasAssociation('Muralestagios'));
    }
}
