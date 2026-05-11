<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\QuestoesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\QuestoesController Test Case
 *
 * @uses \App\Controller\QuestoesController
 */
class QuestoesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Questoes',
        'app.Questionarios',
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
        $this->get('/questoes');
        $this->assertResponseSuccess();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/questoes/view/1');
        $this->assertResponseSuccess();
    }

    public function testAddAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/questoes/add');
        $this->assertResponseSuccess();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/questoes/edit/1');
        $this->assertResponseSuccess();
    }
}
