<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AlunosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AlunosController Test Case
 *
 * @uses \App\Controller\AlunosController
 */
class AlunosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Alunos',
        'app.Estagiarios',
        'app.Inscricoes',
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
        $this->get('/alunos');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testIndexAsAluno(): void
    {
        $this->loginAsAluno();
        $this->get('/alunos');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/alunos/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testViewAsSelf(): void
    {
        $this->loginAsAluno();
        $this->get('/alunos/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Test Student');
    }

    public function testAdd(): void
    {
        $this->loginAsAdmin();
        $this->get('/alunos/add');
        $this->assertResponseOk();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/alunos/edit/1');
        $this->assertResponseOk();
    }

    public function testEditAsSelf(): void
    {
        $this->loginAsAluno();
        $this->get('/alunos/edit/1');
        $this->assertResponseOk();
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/alunos/delete/1');
        $this->assertResponseSuccess();
    }
}
