<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\SupervisoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\SupervisoresController Test Case
 *
 * @uses \App\Controller\SupervisoresController
 */
class SupervisoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Supervisores',
        'app.Estagiarios',
        'app.Users',
        'app.Instituicoes',
        'app.Administradores',
        'app.Configuracoes',
        'app.Alunos',
        'app.Professores',
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
        $this->get('/supervisores');
        $this->assertResponseOk();
        $this->assertResponseContains('Supervisor Teste');
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/supervisores/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Supervisor Teste');
    }

    public function testAdd(): void
    {
        $this->loginAsAdmin();
        $this->get('/supervisores/add');
        $this->assertResponseOk();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/supervisores/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Supervisor Teste');
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/supervisores/delete/1');
        $this->assertResponseSuccess();
    }
}
