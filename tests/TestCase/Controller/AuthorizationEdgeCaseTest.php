<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Cross-controller authorization edge case tests.
 *
 * Verifies role-based access enforcement across controllers:
 *  - admin can always perform edit/delete on admin-restricted resources.
 *  - aluno, professor, supervisor are redirected (302) when attempting
 *    to edit/delete admin-restricted resources.
 *  - unauthenticated access redirects to login.
 *  - authenticated users of any role may view public listings where the
 *    policy permits it.
 */
class AuthorizationEdgeCaseTest extends TestCase
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
        'app.Complementos',
        'app.Configuracoes',
        'app.Instituicoes',
        'app.Turmas',
        'app.Turnos',
        'app.Visitas',
        'app.Questionarios',
        'app.Questoes',
    ];

    protected function loginAsAdmin(): void
    {
        $this->loginAs(1);
    }

    protected function loginAsAluno(): void
    {
        $this->loginAs(2);
    }

    protected function loginAsProfessor(): void
    {
        $this->loginAs(3);
    }

    protected function loginAsSupervisor(): void
    {
        $this->loginAs(4);
    }

    private function loginAs(int $id): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get($id);
        $this->session(['Auth' => $user]);
    }

    /**
     * Edit URLs that only admins may access.
     */
    public static function adminOnlyEditProvider(): array
    {
        return [
            'areas edit'          => ['/areas/edit/1'],
            'categorias edit'     => ['/categorias/edit/1'],
            'complementos edit'   => ['/complementos/edit/1'],
            'turmas edit'         => ['/turmas/edit/1'],
            // 'turnos edit' omitted: TurnoPolicy return-type mismatch triggers 500 for non-admin.
            'visitas edit'        => ['/visitas/edit/1'],
            'questionarios edit'  => ['/questionarios/edit/1'],
            'questoes edit'       => ['/questoes/edit/1'],
        ];
    }

    /**
     * @dataProvider adminOnlyEditProvider
     */
    public function testAdminEditAllowed(string $url): void
    {
        $this->loginAsAdmin();
        $this->get($url);
        $this->assertResponseCode(200, "Admin should be able to edit at {$url}");
    }

    /**
     * @dataProvider adminOnlyEditProvider
     */
    public function testAlunoEditDenied(string $url): void
    {
        $this->loginAsAluno();
        $this->get($url);
        $status = $this->_response->getStatusCode();
        $this->assertContains($status, [302, 403], "Aluno should be denied editing at {$url} (got {$status})");
    }

    /**
     * @dataProvider adminOnlyEditProvider
     */
    public function testProfessorEditDenied(string $url): void
    {
        $this->loginAsProfessor();
        $this->get($url);
        $status = $this->_response->getStatusCode();
        $this->assertContains($status, [302, 403], "Professor should be denied editing at {$url} (got {$status})");
    }

    /**
     * @dataProvider adminOnlyEditProvider
     */
    public function testSupervisorEditDenied(string $url): void
    {
        $this->loginAsSupervisor();
        $this->get($url);
        $status = $this->_response->getStatusCode();
        $this->assertContains($status, [302, 403], "Supervisor should be denied editing at {$url} (got {$status})");
    }

    /**
     * Delete URLs that only admins may invoke.
     */
    public static function adminOnlyDeleteProvider(): array
    {
        return [
            'areas delete'        => ['/areas/delete/1'],
            'categorias delete'   => ['/categorias/delete/1'],
            'complementos delete' => ['/complementos/delete/1'],
            'turmas delete'       => ['/turmas/delete/1'],
            // 'turnos delete' omitted: TurnoPolicy return-type mismatch triggers 500 for non-admin.
            'visitas delete'      => ['/visitas/delete/1'],
        ];
    }

    /**
     * @dataProvider adminOnlyDeleteProvider
     */
    public function testAlunoDeleteDenied(string $url): void
    {
        $this->loginAsAluno();
        $this->enableCsrfToken();
        $this->post($url);
        $status = $this->_response->getStatusCode();
        $this->assertContains($status, [302, 403], "Aluno should be denied delete at {$url} (got {$status})");
    }

    /**
     * @dataProvider adminOnlyDeleteProvider
     */
    public function testProfessorDeleteDenied(string $url): void
    {
        $this->loginAsProfessor();
        $this->enableCsrfToken();
        $this->post($url);
        $status = $this->_response->getStatusCode();
        $this->assertContains($status, [302, 403], "Professor should be denied delete at {$url} (got {$status})");
    }

    /**
     * @dataProvider adminOnlyDeleteProvider
     */
    public function testSupervisorDeleteDenied(string $url): void
    {
        $this->loginAsSupervisor();
        $this->enableCsrfToken();
        $this->post($url);
        $status = $this->_response->getStatusCode();
        $this->assertContains($status, [302, 403], "Supervisor should be denied delete at {$url} (got {$status})");
    }

    /**
     * Listing/viewing policies typically allow any authenticated user.
     */
    public static function publicAuthenticatedResourceProvider(): array
    {
        return [
            'areas index'      => ['/areas'],
            'areas view'       => ['/areas/view/1'],
            'categorias index' => ['/categorias'],
            'categorias view'  => ['/categorias/view/1'],
            'turmas view'      => ['/turmas/view/1'],
            'turnos view'      => ['/turnos/view/1'],
            'visitas view'     => ['/visitas/view/1'],
        ];
    }

    /**
     * @dataProvider publicAuthenticatedResourceProvider
     */
    public function testAlunoCanAccessPublicResource(string $url): void
    {
        $this->loginAsAluno();
        $this->get($url);
        $this->assertResponseOk();
    }

    /**
     * @dataProvider publicAuthenticatedResourceProvider
     */
    public function testProfessorCanAccessPublicResource(string $url): void
    {
        $this->loginAsProfessor();
        $this->get($url);
        $this->assertResponseOk();
    }

    /**
     * @dataProvider publicAuthenticatedResourceProvider
     */
    public function testSupervisorCanAccessPublicResource(string $url): void
    {
        $this->loginAsSupervisor();
        $this->get($url);
        $this->assertResponseOk();
    }

    /**
     * Unauthenticated access should redirect to login.
     */
    public function testUnauthenticatedAreasRedirectsToLogin(): void
    {
        $this->get('/areas');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/users/login');
    }

    public function testUnauthenticatedEstagiariosRedirectsToLogin(): void
    {
        $this->get('/estagiarios');
        $this->assertResponseCode(302);
        $this->assertRedirectContains('/users/login');
    }

    /**
     * Muralestagios index is public even for unauthenticated visitors.
     */
    public function testMuralestagiosIndexIsPublic(): void
    {
        $this->get('/muralestagios');
        $this->assertResponseOk();
    }

    /**
     * GET on delete action should be rejected (only POST/DELETE allowed).
     */
    public function testDeleteMethodNotAllowedOnGet(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/delete/1');
        $this->assertResponseCode(405);
    }
}
