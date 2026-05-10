<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\InscricoesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\InscricoesController Test Case
 *
 * @uses \App\Controller\InscricoesController
 */
class InscricoesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Inscricoes',
        'app.Alunos',
        'app.Muralestagios',
        'app.Instituicoes',
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

    protected function loginAsAluno(): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(2);
        $this->session(['Auth' => $user]);
    }

    public function testIndexAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/inscricoes');
        $this->assertResponseOk();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/inscricoes/view/1');
        $this->assertResponseOk();
    }

    public function testAddRedirectsWithoutMuralestagioId(): void
    {
        $this->loginAsAdmin();
        $this->get('/inscricoes/add');
        $this->assertResponseCode(302);
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/inscricoes/edit/1');
        $this->assertResponseOk();
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/inscricoes/delete/1');
        $this->assertResponseSuccess();
    }
}
