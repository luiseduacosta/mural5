<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\VisitasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\VisitasController Test Case
 *
 * @uses \App\Controller\VisitasController
 */
class VisitasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Visitas',
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
        $this->get('/visitas');
        $this->assertResponseOk();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/visitas/view/1');
        $this->assertResponseOk();
    }

    public function testAdd(): void
    {
        $this->loginAsAdmin();
        $this->get('/visitas/add');
        $this->assertResponseOk();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/visitas/edit/1');
        $this->assertResponseOk();
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/visitas/delete/1');
        $this->assertResponseSuccess();
    }
}
