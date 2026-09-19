<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VisitasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VisitasTable Test Case
 */
class VisitasTableTest extends TestCase
{
    protected $Visitas;

    protected array $fixtures = [
        'app.Visitas',
        'app.Instituicoes',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Visitas') ? [] : ['className' => VisitasTable::class];
        $this->Visitas = $this->getTableLocator()->get('Visitas', $config);
    }

    public function tearDown(): void
    {
        unset($this->Visitas);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('visitas', $this->Visitas->getTable());
        $this->assertSame('Visitas', $this->Visitas->getAlias());
        $this->assertSame('instituicao_id', $this->Visitas->getDisplayField());
        $this->assertSame('id', $this->Visitas->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Visitas->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'data' => '2020-08-10',
            'motivo' => 'Lorem ipsum dolor sit amet',
            'responsavel' => 'Lorem ipsum dolor sit amet',
            'avaliacao' => 'Lorem ipsum dolor sit amet',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'data' => '',
            'motivo' => 'Lorem ipsum dolor sit amet',
            'responsavel' => 'Lorem ipsum dolor sit amet',
            'avaliacao' => 'Lorem ipsum dolor sit amet',
        ]);
        $this->assertArrayHasKey('data', $errors, 'Empty data should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'data' => '2020-08-10',
            'motivo' => '',
            'responsavel' => 'Lorem ipsum dolor sit amet',
            'avaliacao' => 'Lorem ipsum dolor sit amet',
        ]);
        $this->assertArrayHasKey('motivo', $errors, 'Empty motivo should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'data' => '2020-08-10',
            'motivo' => 'Lorem ipsum dolor sit amet',
            'responsavel' => '',
            'avaliacao' => 'Lorem ipsum dolor sit amet',
        ]);
        $this->assertArrayHasKey('responsavel', $errors, 'Empty responsavel should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'data' => '2020-08-10',
            'motivo' => 'Lorem ipsum dolor sit amet',
            'responsavel' => 'Lorem ipsum dolor sit amet',
            'avaliacao' => '',
        ]);
        $this->assertArrayHasKey('avaliacao', $errors, 'Empty avaliacao should fail');
    }

    public function testBuildRules(): void
    {
        $rules = $this->Visitas->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }

    public function testAssociations(): void
    {
        $this->assertTrue($this->Visitas->hasAssociation('Instituicoes'));
    }
}
