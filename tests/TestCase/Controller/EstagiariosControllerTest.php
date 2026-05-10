<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\EstagiariosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\EstagiariosController Test Case
 *
 * @uses \App\Controller\EstagiariosController
 */
class EstagiariosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Estagiarios',
        'app.Alunos',
        'app.Instituicoes',
        'app.Supervisores',
        'app.Professores',
        'app.Configuracoes',
        'app.Users',
        'app.Administradores',
    ];

    protected function loginAsAdmin(): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(1);
        $this->session(['Auth' => $user]);
    }

    protected function loginAsAluno(): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(2);
        $this->session(['Auth' => $user]);
    }

    public function testIndexAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios?periodo=2025-1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testIndexAsAluno(): void
    {
        $this->loginAsAluno();
        $this->get('/estagiarios?periodo=2025-1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testViewAsAluno(): void
    {
        $this->loginAsAluno();
        $this->get('/estagiarios/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testAddAsAdminWithAlunoId(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios/add?aluno_id=1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Editar Estagiário(a)');
    }

    public function testEditAsAluno(): void
    {
        $this->loginAsAluno();
        $this->get('/estagiarios/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/estagiarios/delete/1');
        $this->assertResponseSuccess();
    }
}
