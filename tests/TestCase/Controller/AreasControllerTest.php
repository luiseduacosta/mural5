<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AreasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AreasController Test Case
 *
 * @uses \App\Controller\AreasController
 */
class AreasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Areas',
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
        $this->get('/areas');
        $this->assertResponseOk();
        $this->assertResponseContains('Saúde');
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Saúde');
    }

    public function testAdd(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/add');
        $this->assertResponseOk();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Saúde');
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/areas/delete/1');
        $this->assertResponseSuccess();
    }
}
