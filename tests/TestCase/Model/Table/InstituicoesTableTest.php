<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstituicoesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstituicoesTable Test Case
 */
class InstituicoesTableTest extends TestCase
{
    protected $Instituicoes;

    protected array $fixtures = [
        'app.Instituicoes',
        'app.Areas',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Visitas',
        'app.Supervisores',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Instituicoes') ? [] : ['className' => InstituicoesTable::class];
        $this->Instituicoes = $this->getTableLocator()->get('Instituicoes', $config);
    }

    public function tearDown(): void
    {
        unset($this->Instituicoes);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('instituicoes', $this->Instituicoes->getTable());
        $this->assertSame('Instituicoes', $this->Instituicoes->getAlias());
        $this->assertSame('instituicao', $this->Instituicoes->getDisplayField());
        $this->assertSame('id', $this->Instituicoes->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Instituicoes->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'instituicao' => 'Hospital Universitário',
            'area_id' => 1,
            'natureza' => 'Pública',
            'cnpj' => '12.345.678/0001-90',
            'email' => 'contato@hu.ufrj.br',
            'url' => 'https://hu.ufrj.br',
            'endereco' => 'Av. Brigadeiro Trompowski s/n',
            'bairro' => 'Cidade Universitária',
            'municipio' => 'Rio de Janeiro',
            'cep' => '21941-590',
            'telefone' => '(21) 3938-1000',
            'beneficio' => 'VT',
            'fim_de_semana' => '0',
            'convenio' => 1,
            'expira' => '2026-12-31',
            'seguro' => '1',
            'observacoes' => 'Convênio ativo',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'instituicao' => '',
            'area_id' => 1,
        ]);
        $this->assertArrayHasKey('instituicao', $errors, 'Empty instituicao should fail');

        $errors = $validator->validate([
            'instituicao' => 'Hospital Universitário',
            'cnpj' => 'invalid-cnpj',
        ]);
        $this->assertArrayHasKey('cnpj', $errors, 'Invalid CNPJ should fail');

        $errors = $validator->validate([
            'instituicao' => 'Hospital Universitário',
            'cep' => 'invalid-cep',
        ]);
        $this->assertArrayHasKey('cep', $errors, 'Invalid CEP should fail');

        $errors = $validator->validate([
            'instituicao' => 'Hospital Universitário',
            'email' => 'invalid-email',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Invalid email should fail');

        $errors = $validator->validate([
            'instituicao' => 'Hospital Universitário',
            'fim_de_semana' => 'X',
        ]);
        $this->assertArrayHasKey('fim_de_semana', $errors, 'Invalid fim_de_semana should fail');

        $errors = $validator->validate([
            'instituicao' => 'Hospital Universitário',
            'seguro' => 'X',
        ]);
        $this->assertArrayHasKey('seguro', $errors, 'Invalid seguro should fail');
    }

    public function testBuildRules(): void
    {
        $rules = $this->Instituicoes->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }

    public function testAssociations(): void
    {
        $this->assertTrue($this->Instituicoes->hasAssociation('Areas'));
        $this->assertTrue($this->Instituicoes->hasAssociation('Estagiarios'));
        $this->assertTrue($this->Instituicoes->hasAssociation('Muralestagios'));
        $this->assertTrue($this->Instituicoes->hasAssociation('Visitas'));
        $this->assertTrue($this->Instituicoes->hasAssociation('Supervisores'));
    }
}
