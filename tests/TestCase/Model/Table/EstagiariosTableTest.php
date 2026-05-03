<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstagiariosTable;
use Cake\TestSuite\TestCase;

class EstagiariosTableTest extends TestCase
{
    protected $Estagiarios;

    protected array $fixtures = [
        'app.estagiarios',
        'app.alunos',
        'app.instituicoes',
        'app.supervisores',
        'app.professores',
        'app.complementos',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Estagiarios') ? [] : ['className' => EstagiariosTable::class];
        $this->Estagiarios = $this->getTableLocator()->get('Estagiarios', $config);
    }

    public function tearDown(): void
    {
        unset($this->Estagiarios);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('estagiarios', $this->Estagiarios->getTable());
        $this->assertSame('Estagiarios', $this->Estagiarios->getAlias());
        $this->assertSame('registro', $this->Estagiarios->getDisplayField());
        $this->assertSame('id', $this->Estagiarios->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Estagiarios->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'registro' => 12345,
            'nivel' => '1',
            'instituicao_id' => 1,
            'periodo' => '2024-1',
            'complemento_id' => 1,
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'registro' => '',
            'nivel' => '1',
            'instituicao_id' => 1,
            'periodo' => '2024-1',
            'complemento_id' => 1,
        ]);
        $this->assertArrayHasKey('registro', $errors, 'Empty registro should fail');

        $errors = $validator->validate([
            'registro' => 12345,
            'nivel' => 'X',
            'instituicao_id' => 1,
            'periodo' => '2024-1',
            'complemento_id' => 1,
        ]);
        $this->assertArrayHasKey('nivel', $errors, 'Invalid nivel should fail');

        foreach (['1', '2', '3', '4', '9'] as $nivel) {
            $errors = $validator->validate([
                'registro' => 12345,
                'nivel' => $nivel,
                'instituicao_id' => 1,
                'periodo' => '2024-1',
                'complemento_id' => 1,
            ]);
            $this->assertArrayNotHasKey('nivel', $errors, "Nivel '$nivel' should be valid");
        }
    }

    public function testBuildRules(): void
    {
        $rules = $this->Estagiarios->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }

    public function testAssociations(): void
    {
        $this->assertTrue($this->Estagiarios->hasAssociation('Alunos'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Professores'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Supervisores'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Instituicoes'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Folhadeatividades'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Complementos'));
    }
}