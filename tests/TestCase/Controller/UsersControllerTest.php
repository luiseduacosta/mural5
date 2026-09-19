<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [
        'app.Users',
        'app.Alunos',
        'app.Supervisores',
        'app.Professores',
        'app.Administradores',
    ];

    /**
     * Helper to authenticate as admin (categoria 1)
     *
     * @return void
     */
    protected function loginAsAdmin(): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(1);
        $this->session(['Auth' => $user]);
    }

    /**
     * Helper to authenticate as aluno (categoria 2)
     *
     * @return void
     */
    protected function loginAsAluno(): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(2);
        $this->session(['Auth' => $user]);
    }

    /**
     * Test index method as admin
     *
     * @return void
     */
    public function testIndexAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseContains('Admin User');
        $this->assertResponseContains('Aluno Test');
    }

    /**
     * Test index method as non-admin (scoped to self)
     *
     * @return void
     */
    public function testIndexAsAluno(): void
    {
        $this->loginAsAluno();
        $this->get('/users');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/users/login');
    }

    /**
     * Test view method as admin
     *
     * @return void
     */
    public function testViewAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/users/view/2');
        $this->assertResponseOk();
        $this->assertResponseContains('Aluno Test');
    }

    /**
     * Test view method as self
     *
     * @return void
     */
    public function testViewAsSelf(): void
    {
        $this->loginAsAluno();
        $this->get('/users/view/2');
        $this->assertResponseOk();
        $this->assertResponseContains('Aluno Test');
    }

    /**
     * Test view method as other user (forbidden)
     *
     * @return void
     */
    public function testViewAsOtherUser(): void
    {
        $this->loginAsAluno();
        $this->get('/users/view/1');
        $this->assertResponseCode(403);
    }

    /**
     * Test add method (public)
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/users/add');
        $this->assertResponseOk();
    }

    /**
     * Test edit method as admin
     *
     * @return void
     */
    public function testEditAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->get('/users/edit/2');
        $this->assertResponseOk();
    }

    /**
     * Test edit method as self
     *
     * @return void
     */
    public function testEditAsSelf(): void
    {
        $this->loginAsAluno();
        $this->get('/users/edit/2');
        $this->assertResponseOk();
    }

    /**
     * Test edit method as other user (forbidden)
     *
     * @return void
     */
    public function testEditAsOtherUser(): void
    {
        $this->loginAsAluno();
        $this->get('/users/edit/1');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/users');
    }

    /**
     * Test delete method as admin
     *
     * @return void
     */
    public function testDeleteAsAdmin(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post('/users/delete/2');
        $this->assertResponseSuccess();
    }

    /**
     * Test delete method as self
     *
     * @return void
     */
    public function testDeleteAsSelf(): void
    {
        $this->loginAsAluno();
        $this->enableCsrfToken();
        $this->post('/users/delete/2');
        $this->assertResponseSuccess();
    }

    /**
     * Test delete method as other user (forbidden)
     *
     * @return void
     */
    public function testDeleteAsOtherUser(): void
    {
        $this->loginAsAluno();
        $this->enableCsrfToken();
        $this->post('/users/delete/1');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/users');
    }
}
