<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\FolhadeatividadesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\FolhadeatividadesController Test Case
 *
 * @uses \App\Controller\FolhadeatividadesController
 */
class FolhadeatividadesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Folhadeatividades',
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

    public function testIndexRedirectsWithoutEstagiario(): void
    {
        $this->loginAsAdmin();
        $this->get('/folhadeatividades');
        $this->assertResponseSuccess();
    }

    public function testIndexAsAdminWithEstagiario(): void
    {
        $this->loginAsAdmin();
        $this->get('/folhadeatividades?estagiario_id=1');
        $this->assertResponseSuccess();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/folhadeatividades/view/1');
        $this->assertResponseSuccess();
    }

    public function testAddRedirectsWithoutEstagiario(): void
    {
        $this->loginAsAdmin();
        $this->get('/folhadeatividades/add?estagiario_id=1');
        $this->assertResponseSuccess();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/folhadeatividades/edit/1');
        $this->assertResponseSuccess();
    }
}
