<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\RespostasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RespostasController Test Case
 *
 * @uses \App\Controller\RespostasController
 */
class RespostasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Respostas',
        'app.Questionarios',
        'app.Questoes',
        'app.Estagiarios',
        'app.Alunos',
        'app.Supervisores',
        'app.Professores',
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

    public function testIndexAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/respostas');
        $this->assertResponseSuccess();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/respostas/view/1');
        $this->assertResponseSuccess();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/respostas/edit/1');
        $this->assertResponseSuccess();
    }
}
