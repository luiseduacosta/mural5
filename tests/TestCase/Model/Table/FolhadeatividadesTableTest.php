<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FolhadeatividadesTable;
use Cake\TestSuite\TestCase;

class FolhadeatividadesTableTest extends TestCase
{
    protected $Folhadeatividades;

    protected array $fixtures = [
        'app.Folhadeatividades',
        'app.Estagiarios',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Folhadeatividades') ? [] : ['className' => FolhadeatividadesTable::class];
        $this->Folhadeatividades = $this->getTableLocator()->get('Folhadeatividades', $config);
    }

    public function tearDown(): void
    {
        unset($this->Folhadeatividades);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('folhadeatividades', $this->Folhadeatividades->getTable());
        $this->assertSame('Folhadeatividades', $this->Folhadeatividades->getAlias());
        $this->assertSame('atividade', $this->Folhadeatividades->getDisplayField());
        $this->assertSame('id', $this->Folhadeatividades->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Folhadeatividades->getValidator();

        $errors = $validator->validate([
            'dia' => '2026-01-01',
            'inicio' => '09:00:00',
            'final' => '12:00:00',
            'atividade' => 'Test Activity',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'inicio' => '09:00:00',
            'final' => '12:00:00',
            'atividade' => 'Test Activity',
        ]);
        $this->assertArrayHasKey('dia', $errors, 'Empty dia should fail');
    }

    public function testBuildRules(): void
    {
        $rules = $this->Folhadeatividades->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }
}
