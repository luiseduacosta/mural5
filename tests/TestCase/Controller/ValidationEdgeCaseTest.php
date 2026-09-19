<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Validation edge case tests for controller add/edit actions.
 *
 * Confirms that invalid input (empty required fields, oversize values,
 * malformed patterns) does not alter the database and is rejected by
 * the validation layer.
 */
class ValidationEdgeCaseTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Users',
        'app.Administradores',
        'app.Alunos',
        'app.Professores',
        'app.Supervisores',
        'app.Areas',
        'app.Categorias',
        'app.Instituicoes',
        'app.Turmas',
        'app.Configuracoes',
    ];

    protected function loginAsAdmin(): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(1);
        $this->session(['Auth' => $user]);
    }

    /* --------------------------------------------------------------------
     * Areas — area is notEmptyString, maxLength 90
     * ------------------------------------------------------------------ */

    public function testAreasAddRejectsEmptyArea(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $areas = $this->getTableLocator()->get('Areas');
        $initial = $areas->find()->count();

        $this->post('/areas/add', ['area' => '']);

        $this->assertSame($initial, $areas->find()->count(), 'Area with empty name must not be saved.');
    }

    public function testAreasAddRejectsOversizeArea(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $areas = $this->getTableLocator()->get('Areas');
        $initial = $areas->find()->count();

        $this->post('/areas/add', ['area' => str_repeat('x', 100)]);

        $this->assertSame($initial, $areas->find()->count(), 'Area longer than 90 chars must not be saved.');
    }

    public function testAreasEditRejectsEmptyArea(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $areas = $this->getTableLocator()->get('Areas');
        $originalName = $areas->get(1)->area;

        $this->post('/areas/edit/1', ['area' => '']);

        $this->assertSame(
            $originalName,
            $areas->get(1)->area,
            'Area must retain original name when edited with empty value.'
        );
    }

    /* --------------------------------------------------------------------
     * Categorias — categoria is notEmptyString, maxLength 50
     * ------------------------------------------------------------------ */

    public function testCategoriasEditRejectsEmptyName(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $categorias = $this->getTableLocator()->get('Categorias');
        $original = $categorias->get(1)->categoria;

        $this->post('/categorias/edit/1', ['categoria' => '']);

        $this->assertSame($original, $categorias->get(1)->categoria);
    }

    public function testCategoriasEditRejectsOversizeName(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $categorias = $this->getTableLocator()->get('Categorias');
        $original = $categorias->get(1)->categoria;

        $this->post('/categorias/edit/1', ['categoria' => str_repeat('y', 60)]);

        $this->assertSame($original, $categorias->get(1)->categoria);
    }

    /* --------------------------------------------------------------------
     * Turmas — turma is notEmptyString, maxLength 70
     * ------------------------------------------------------------------ */

    public function testTurmasAddRejectsEmptyName(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $turmas = $this->getTableLocator()->get('Turmas');
        $initial = $turmas->find()->count();

        $this->post('/turmas/add', ['turma' => '']);

        $this->assertSame($initial, $turmas->find()->count());
    }

    public function testTurmasAddRejectsOversizeName(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $turmas = $this->getTableLocator()->get('Turmas');
        $initial = $turmas->find()->count();

        $this->post('/turmas/add', ['turma' => str_repeat('t', 100)]);

        $this->assertSame($initial, $turmas->find()->count());
    }

    /* --------------------------------------------------------------------
     * Instituicoes — multiple validations: instituicao required, cnpj regex, email format
     * ------------------------------------------------------------------ */

    public function testInstituicoesAddRejectsEmptyName(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $instituicoes = $this->getTableLocator()->get('Instituicoes');
        $initial = $instituicoes->find()->count();

        $this->post('/instituicoes/add', [
            'instituicao' => '',
            'area_id' => 1,
        ]);

        $this->assertSame($initial, $instituicoes->find()->count(), 'Instituicao must require a name.');
    }

    public function testInstituicoesAddRejectsInvalidCnpj(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $instituicoes = $this->getTableLocator()->get('Instituicoes');
        $initial = $instituicoes->find()->count();

        $this->post('/instituicoes/add', [
            'instituicao' => 'Nova Instituição',
            'area_id' => 1,
            'cnpj' => 'NOT-A-VALID-CNPJ',
        ]);

        $this->assertSame($initial, $instituicoes->find()->count(), 'Invalid CNPJ pattern must be rejected.');
    }

    public function testInstituicoesAddRejectsInvalidEmail(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $instituicoes = $this->getTableLocator()->get('Instituicoes');
        $initial = $instituicoes->find()->count();

        $this->post('/instituicoes/add', [
            'instituicao' => 'Nova Instituição',
            'area_id' => 1,
            'email' => 'not-an-email',
        ]);

        $this->assertSame($initial, $instituicoes->find()->count(), 'Invalid email must be rejected.');
    }

    /* --------------------------------------------------------------------
     * Users — email must be unique; email format required
     * ------------------------------------------------------------------ */

    public function testUsersAddRejectsInvalidEmail(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $users = $this->getTableLocator()->get('Users');
        $initial = $users->find()->count();

        $this->post('/users/add', [
            'nome' => 'Bogus',
            'email' => 'not-an-email',
            'password' => 'abc12345',
            'confirm_password' => 'abc12345',
            'categoria' => '2',
        ]);

        $this->assertSame($initial, $users->find()->count(), 'Invalid email must reject user creation.');
    }

    public function testUsersAddRejectsDuplicateEmail(): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();

        $users = $this->getTableLocator()->get('Users');
        $initial = $users->find()->count();

        // admin@test.com already exists in UsersFixture (id=1).
        $this->post('/users/add', [
            'nome' => 'Duplicate Admin',
            'email' => 'admin@test.com',
            'password' => 'abc12345',
            'confirm_password' => 'abc12345',
            'categoria' => '1',
        ]);

        $this->assertSame($initial, $users->find()->count(), 'Duplicate email must not create a user.');
    }
}
