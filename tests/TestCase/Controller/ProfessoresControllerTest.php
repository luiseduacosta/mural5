<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProfessoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProfessoresController Test Case
 *
 * @uses \App\Controller\ProfessoresController
 */
class ProfessoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Professores',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Users',
        'app.Administradores',
        'app.Configuracoes',
    ];

    protected function loginAsAdmin(): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(1);
        $this->session(['Auth' => $user]);
    }

    public function testIndexAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/professores');
        $this->assertResponseOk();
        $this->assertResponseContains('Professor Teste');
        $this->assertResponseContains('Status');
        $this->assertResponseContains('Estagiários');
    }

    public function testAdd(): void
    {
        $this->loginAsAdmin();
        $this->get('/professores/add');
        $this->assertResponseOk();
        $this->assertResponseContains('name="status"');
        $this->assertResponseContains('name="estagiarios_count"');
        $this->assertResponseContains('name="curriculolattes"');
        $this->assertResponseContains('name="atualizacaolattes"');
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/professores/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Professor Teste');
        $this->assertResponseContains('name="status"');
        $this->assertResponseContains('name="estagiarios_count"');
        $this->assertResponseContains('name="curriculolattes"');
        $this->assertResponseContains('name="atualizacaolattes"');
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/professores/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Professor Teste');
        $this->assertResponseContains('Status');
        $this->assertResponseContains('Quantidade de Estagiários');
        $this->assertResponseContains('1234567890123456');
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/professores/delete/1');
        $this->assertResponseSuccess();
    }
}
