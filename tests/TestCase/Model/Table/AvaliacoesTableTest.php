<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AvaliacoesTable;
use Cake\TestSuite\TestCase;

class AvaliacoesTableTest extends TestCase
{
    protected $Avaliacoes;

    protected array $fixtures = [
        'app.Avaliacoes',
        'app.Estagiarios',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Avaliacoes') ? [] : ['className' => AvaliacoesTable::class];
        $this->Avaliacoes = $this->getTableLocator()->get('Avaliacoes', $config);
    }

    public function tearDown(): void
    {
        unset($this->Avaliacoes);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('avaliacoes', $this->Avaliacoes->getTable());
        $this->assertSame('Avaliacoes', $this->Avaliacoes->getAlias());
        $this->assertSame('estagiario_id', $this->Avaliacoes->getDisplayField());
        $this->assertSame('id', $this->Avaliacoes->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Avaliacoes->getValidator();

        $errors = $validator->validate([
            'avaliacao1' => 'A',
            'avaliacao2' => 'B',
            'avaliacao3' => 'C',
            'avaliacao4' => 'D',
            'avaliacao5' => 'E',
            'avaliacao6' => 'F',
            'avaliacao7' => 'G',
            'avaliacao8' => 'H',
            'avaliacao9' => 'I',
            'avaliacao10' => 'J',
            'avaliacao11' => 'K',
            'avaliacao12' => 'L',
            'avaliacao13' => 'M',
            'criado_em' => '2026-01-01 09:00:00',
            'atualizado_em' => '2026-01-02 10:00:00',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));
    }

    public function testBuildRules(): void
    {
        $rules = $this->Avaliacoes->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }
}
