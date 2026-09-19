<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ConfiguracoesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ConfiguracoesController Test Case
 *
 * @uses \App\Controller\ConfiguracoesController
 */
class ConfiguracoesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
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

    public function testIndexAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/configuracoes');
        $this->assertResponseSuccess();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/configuracoes/view/1');
        $this->assertResponseSuccess();
    }

    public function testAddAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/configuracoes/add');
        $this->assertResponseSuccess();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/configuracoes/edit/1');
        $this->assertResponseSuccess();
    }
}
