<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\QuestionariosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\QuestionariosController Test Case
 *
 * @uses \App\Controller\QuestionariosController
 */
class QuestionariosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Questionarios',
        'app.Questoes',
        'app.Respostas',
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
        $this->get('/questionarios');
        $this->assertResponseSuccess();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/questionarios/view/1');
        $this->assertResponseSuccess();
    }

    public function testAddAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/questionarios/add');
        $this->assertResponseSuccess();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/questionarios/edit/1');
        $this->assertResponseSuccess();
    }
}
