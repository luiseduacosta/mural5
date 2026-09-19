<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MuralestagiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MuralestagiosTable Test Case
 */
class MuralestagiosTableTest extends TestCase
{
    protected $Muralestagios;

    protected array $fixtures = [
        'app.Muralestagios',
        'app.Instituicoes',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Muralestagios') ? [] : ['className' => MuralestagiosTable::class];
        $this->Muralestagios = $this->getTableLocator()->get('Muralestagios', $config);
    }

    public function tearDown(): void
    {
        unset($this->Muralestagios);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('mural_estagios', $this->Muralestagios->getTable());
        $this->assertSame('Muralestagios', $this->Muralestagios->getAlias());
        $this->assertSame('instituicao', $this->Muralestagios->getDisplayField());
        $this->assertSame('id', $this->Muralestagios->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Muralestagios->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => 'Hospital UFRJ',
            'convenio' => '1',
            'vagas' => 5,
            'final_de_semana' => '0',
            'local_inscricao' => '0',
            'email' => 'teste@mural.com.br',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'instituicao_id' => '',
            'instituicao' => 'Hospital UFRJ',
            'convenio' => '1',
            'vagas' => 5,
            'final_de_semana' => '0',
            'local_inscricao' => '0',
            'email' => 'teste@mural.com.br',
        ]);
        $this->assertArrayHasKey('instituicao_id', $errors, 'Empty instituicao_id should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => '',
            'convenio' => '1',
            'vagas' => 5,
            'final_de_semana' => '0',
            'local_inscricao' => '0',
            'email' => 'teste@mural.com.br',
        ]);
        $this->assertArrayHasKey('instituicao', $errors, 'Empty instituicao should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => 'Hospital UFRJ',
            'convenio' => '',
            'vagas' => 5,
            'final_de_semana' => '0',
            'local_inscricao' => '0',
            'email' => 'teste@mural.com.br',
        ]);
        $this->assertArrayHasKey('convenio', $errors, 'Empty convenio should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => 'Hospital UFRJ',
            'convenio' => 'X',
            'vagas' => 5,
            'final_de_semana' => '0',
            'local_inscricao' => '0',
            'email' => 'teste@mural.com.br',
        ]);
        $this->assertArrayHasKey('convenio', $errors, 'Invalid convenio should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => 'Hospital UFRJ',
            'convenio' => '1',
            'vagas' => '',
            'final_de_semana' => '0',
            'local_inscricao' => '0',
            'email' => 'teste@mural.com.br',
        ]);
        $this->assertArrayHasKey('vagas', $errors, 'Empty vagas should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => 'Hospital UFRJ',
            'convenio' => '1',
            'vagas' => 5,
            'final_de_semana' => '',
            'local_inscricao' => '0',
            'email' => 'teste@mural.com.br',
        ]);
        $this->assertArrayHasKey('final_de_semana', $errors, 'Empty final_de_semana should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => 'Hospital UFRJ',
            'convenio' => '1',
            'vagas' => 5,
            'final_de_semana' => '0',
            'local_inscricao' => '',
            'email' => 'teste@mural.com.br',
        ]);
        $this->assertArrayHasKey('local_inscricao', $errors, 'Empty local_inscricao should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => 'Hospital UFRJ',
            'convenio' => '1',
            'vagas' => 5,
            'final_de_semana' => '0',
            'local_inscricao' => '0',
            'email' => '',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Empty email should fail');

        $errors = $validator->validate([
            'instituicao_id' => 1,
            'instituicao' => 'Hospital UFRJ',
            'convenio' => '1',
            'vagas' => 5,
            'final_de_semana' => '0',
            'local_inscricao' => '0',
            'email' => 'invalid-email',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Invalid email should fail');
    }

    public function testBuildRules(): void
    {
        $rules = $this->Muralestagios->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }

    public function testAssociations(): void
    {
        $this->assertTrue($this->Muralestagios->hasAssociation('Inscricoes'));
        $this->assertTrue($this->Muralestagios->hasAssociation('Instituicoes'));
    }
}
