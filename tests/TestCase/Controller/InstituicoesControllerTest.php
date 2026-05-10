<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\InstituicoesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\InstituicoesController Test Case
 *
 * @uses \App\Controller\InstituicoesController
 */
class InstituicoesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Instituicoes',
        'app.Areas',
        'app.Estagiarios',
        'app.Muralestagios',
        'app.Visitas',
        'app.Supervisores',
        'app.InstituicaoSupervisores',
        'app.Users',
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
        $this->get('/instituicoes');
        $this->assertResponseOk();
        $this->assertResponseContains('Hospital Universitário');
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/instituicoes/view/1');
        $this->assertResponseOk();
    }

    public function testAdd(): void
    {
        $this->loginAsAdmin();
        $this->get('/instituicoes/add');
        $this->assertResponseOk();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/instituicoes/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Hospital Universitário');
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/instituicoes/delete/1');
        $this->assertResponseSuccess();
    }
}
