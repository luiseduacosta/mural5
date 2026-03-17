<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstagiariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstagiariosTable Test Case
 */
class EstagiariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstagiariosTable
     */
    protected $Estagiarios;

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
        $config = $this->getTableLocator()->exists('Estagiarios') ? [] : ['className' => EstagiariosTable::class];
        $this->Estagiarios = $this->getTableLocator()->get('Estagiarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Estagiarios);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->assertSame('estagiarios', $this->Estagiarios->getTable());
        $this->assertSame('Estagiarios', $this->Estagiarios->getAlias());
        $this->assertSame('id', $this->Estagiarios->getDisplayField());
        $this->assertSame('id', $this->Estagiarios->getPrimaryKey());
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $validator = $this->Estagiarios->validationDefault(new \Cake\Validation\Validator());

        // Test valid data passes
        $errors = $validator->validate([
            'registro' => 12345,
            'turno' => 'D',
            'nivel' => '1',
            'tc' => '1',
            'instituicao_id' => 1,
            'periodo' => '2024.1',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass validation: ' . print_r($errors, true));

        // Test empty registro fails
        $errors = $validator->validate([
            'registro' => '',
            'turno' => 'D',
            'nivel' => '1',
            'tc' => '1',
            'instituicao_id' => 1,
            'periodo' => '2024.1',
        ]);
        $this->assertArrayHasKey('registro', $errors, 'Empty registro should fail');

        // Test invalid turno
        $errors = $validator->validate([
            'registro' => 12345,
            'turno' => 'X',
            'nivel' => '1',
            'tc' => '1',
            'instituicao_id' => 1,
            'periodo' => '2024.1',
        ]);
        $this->assertArrayHasKey('turno', $errors, 'Invalid turno should fail');

        // Test valid turno values
        foreach (['D', 'N', 'I'] as $turno) {
            $errors = $validator->validate([
                'registro' => 12345,
                'turno' => $turno,
                'nivel' => '1',
                'tc' => '1',
                'instituicao_id' => 1,
                'periodo' => '2024.1',
            ]);
            $this->assertArrayNotHasKey('turno', $errors, "Turno '$turno' should be valid");
        }

        // Test invalid nivel
        $errors = $validator->validate([
            'registro' => 12345,
            'turno' => 'D',
            'nivel' => '5',
            'tc' => '1',
            'instituicao_id' => 1,
            'periodo' => '2024.1',
        ]);
        $this->assertArrayHasKey('nivel', $errors, 'Invalid nivel should fail');

        // Test valid nivel values
        foreach (['1', '2', '3', '4', '9'] as $nivel) {
            $errors = $validator->validate([
                'registro' => 12345,
                'turno' => 'D',
                'nivel' => $nivel,
                'tc' => '1',
                'instituicao_id' => 1,
                'periodo' => '2024.1',
            ]);
            $this->assertArrayNotHasKey('nivel', $errors, "Nivel '$nivel' should be valid");
        }

        // Test invalid tc
        $errors = $validator->validate([
            'registro' => 12345,
            'turno' => 'D',
            'nivel' => '1',
            'tc' => '2',
            'instituicao_id' => 1,
            'periodo' => '2024.1',
        ]);
        $this->assertArrayHasKey('tc', $errors, 'Invalid tc should fail');

        // Test valid tc values
        foreach (['0', '1'] as $tc) {
            $errors = $validator->validate([
                'registro' => 12345,
                'turno' => 'D',
                'nivel' => '1',
                'tc' => $tc,
                'instituicao_id' => 1,
                'periodo' => '2024.1',
            ]);
            $this->assertArrayNotHasKey('tc', $errors, "TC '$tc' should be valid");
        }

        // Test empty periodo fails
        $errors = $validator->validate([
            'registro' => 12345,
            'turno' => 'D',
            'nivel' => '1',
            'tc' => '1',
            'instituicao_id' => 1,
            'periodo' => '',
        ]);
        $this->assertArrayHasKey('periodo', $errors, 'Empty periodo should fail');

        // Test periodo too long
        $errors = $validator->validate([
            'registro' => 12345,
            'turno' => 'D',
            'nivel' => '1',
            'tc' => '1',
            'instituicao_id' => 1,
            'periodo' => '1234567',
        ]);
        $this->assertArrayHasKey('periodo', $errors, 'Periodo too long should fail');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $rules = $this->Estagiarios->buildRules(new \Cake\ORM\RulesChecker());

        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }

    /**
     * Test associations
     *
     * @return void
     */
    public function testAssociations(): void
    {
        $this->assertTrue($this->Estagiarios->hasAssociation('Alunos'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Professores'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Turmaestagios'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Supervisores'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Instituicoes'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Avaliacoes'));
        $this->assertTrue($this->Estagiarios->hasAssociation('Folhadeatividades'));
    }
}
