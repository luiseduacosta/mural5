<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\MuralestagiosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\MuralestagiosController Test Case
 *
 * @uses \App\Controller\MuralestagiosController
 */
class MuralestagiosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Muralestagios',
        'app.Instituicoes',
        'app.Professores',
        'app.Inscricoes',
        'app.Alunos',
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
        $this->get('/muralestagios');
        $this->assertResponseOk();
    }

    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/muralestagios/view/1');
        $this->assertResponseOk();
    }

    public function testAdd(): void
    {
        $this->loginAsAdmin();
        $this->get('/muralestagios/add');
        $this->assertResponseOk();
    }

    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/muralestagios/edit/1');
        $this->assertResponseOk();
    }

    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/muralestagios/delete/1');
        $this->assertResponseSuccess();
    }
}
