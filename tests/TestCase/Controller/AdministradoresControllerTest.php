<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AdministradoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AdministradoresController Test Case
 *
 * @uses \App\Controller\AdministradoresController
 */
class AdministradoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Administradores',
        'app.Users',
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
        $this->get('/administradores');
        $this->assertResponseSuccess();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/administradores/view/1');
        $this->assertResponseSuccess();
    }

    public function testAddAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/administradores/add');
        $this->assertResponseSuccess();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/administradores/edit/1');
        $this->assertResponseSuccess();
    }
}
