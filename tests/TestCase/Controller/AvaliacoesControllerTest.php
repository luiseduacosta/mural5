<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AvaliacoesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AvaliacoesController Test Case
 *
 * @uses \App\Controller\AvaliacoesController
 */
class AvaliacoesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Avaliacoes',
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

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/avaliacoes/view/1');
        $this->assertResponseSuccess();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/avaliacoes/edit/1');
        $this->assertResponseSuccess();
    }
}
