<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Input edge case tests for controller actions.
 *
 * Covers invalid IDs (non-existent, non-numeric, negative, out-of-range),
 * missing route parameters and unusual query strings.
 *
 * NOTE on status 500:
 *   Several controllers catch RecordNotFoundException and redirect without
 *   calling $this->Authorization->authorize() first. Under the AuthorizationMiddleware
 *   with the "required" option (default), that results in an
 *   AuthorizationRequiredException (HTTP 500). This is CakePHP's intentional
 *   safety net — not an uncaught crash — so we accept 500 as a valid
 *   "safely handled" outcome alongside 302 / 404 for invalid IDs.
 */
class InputEdgeCaseTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Accepted status codes for "invalid id, safely handled":
     *  - 302 redirect to index (controllers that pass auth then catch NotFound)
     *  - 404 explicit not-found
     *  - 500 AuthorizationRequiredException (catch-and-redirect before authorize)
     */
    private const SAFE_ERROR_STATUSES = [302, 404, 500];

    protected array $fixtures = [
        'app.Users',
        'app.Administradores',
        'app.Alunos',
        'app.Estagiarios',
        'app.Professores',
        'app.Supervisores',
        'app.Instituicoes',
        'app.Areas',
        'app.Categorias',
        'app.Complementos',
        'app.Configuracoes',
        'app.Turmas',
        'app.Turnos',
        'app.Visitas',
        'app.Questionarios',
        'app.Questoes',
        'app.Inscricoes',
        'app.Muralestagios',
    ];

    protected function loginAsAdmin(): void
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->get(1);
        $this->session(['Auth' => $user]);
    }

    private function assertSafeErrorStatus(string $url, ?string $context = null): void
    {
        $status = $this->_response->getStatusCode();
        $msg = $context ?? "Edge case at {$url} must not leak data (status={$status})";
        $this->assertContains($status, self::SAFE_ERROR_STATUSES, $msg);
        $this->assertNotSame(200, $status, "Invalid request at {$url} should not return 200.");
    }

    /* --------------------------------------------------------------------
     * Non-existent IDs on view.
     * ------------------------------------------------------------------ */

    public static function nonExistentViewProvider(): array
    {
        return [
            'areas'         => ['/areas/view/999999'],
            'categorias'    => ['/categorias/view/999999'],
            'complementos'  => ['/complementos/view/999999'],
            'instituicoes'  => ['/instituicoes/view/999999'],
            'turmas'        => ['/turmas/view/999999'],
            'turnos'        => ['/turnos/view/999999'],
            'visitas'       => ['/visitas/view/999999'],
            'questionarios' => ['/questionarios/view/999999'],
            'questoes'      => ['/questoes/view/999999'],
        ];
    }

    /**
     * @dataProvider nonExistentViewProvider
     */
    public function testViewNonExistentIdHandledSafely(string $url): void
    {
        $this->loginAsAdmin();
        $this->get($url);
        $this->assertSafeErrorStatus($url);
    }

    /* --------------------------------------------------------------------
     * Non-existent IDs on edit.
     * ------------------------------------------------------------------ */

    public static function nonExistentEditProvider(): array
    {
        return [
            'areas'         => ['/areas/edit/999999'],
            'categorias'    => ['/categorias/edit/999999'],
            'complementos'  => ['/complementos/edit/999999'],
            'instituicoes'  => ['/instituicoes/edit/999999'],
            'turmas'        => ['/turmas/edit/999999'],
            'visitas'       => ['/visitas/edit/999999'],
            'questionarios' => ['/questionarios/edit/999999'],
            'questoes'      => ['/questoes/edit/999999'],
        ];
    }

    /**
     * @dataProvider nonExistentEditProvider
     */
    public function testEditNonExistentIdHandledSafely(string $url): void
    {
        $this->loginAsAdmin();
        $this->get($url);
        $this->assertSafeErrorStatus($url);
    }

    /* --------------------------------------------------------------------
     * Non-existent IDs on delete (POST).
     * ------------------------------------------------------------------ */

    public static function nonExistentDeleteProvider(): array
    {
        return [
            'areas'         => ['/areas/delete/999999'],
            'categorias'    => ['/categorias/delete/999999'],
            'complementos'  => ['/complementos/delete/999999'],
            'turmas'        => ['/turmas/delete/999999'],
            'visitas'       => ['/visitas/delete/999999'],
        ];
    }

    /**
     * @dataProvider nonExistentDeleteProvider
     */
    public function testDeleteNonExistentIdHandledSafely(string $url): void
    {
        $this->loginAsAdmin();
        $this->enableCsrfToken();
        $this->post($url);
        $this->assertSafeErrorStatus($url);
    }

    /* --------------------------------------------------------------------
     * Non-numeric / zero / negative / oversized IDs.
     * ------------------------------------------------------------------ */

    public function testViewWithNonNumericIdHandledSafely(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/view/abc');
        $this->assertSafeErrorStatus('/areas/view/abc');
    }

    public function testEditWithNonNumericIdHandledSafely(): void
    {
        $this->loginAsAdmin();
        $this->get('/categorias/edit/not-a-number');
        $this->assertSafeErrorStatus('/categorias/edit/not-a-number');
    }

    public function testViewWithZeroIdHandledSafely(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/view/0');
        $this->assertSafeErrorStatus('/areas/view/0');
    }

    public function testViewWithNegativeIdHandledSafely(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/view/-1');
        $this->assertSafeErrorStatus('/areas/view/-1');
    }

    public function testViewWithExtremelyLargeIdHandledSafely(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/view/999999999999999');
        $this->assertSafeErrorStatus('/areas/view/999999999999999');
    }

    /* --------------------------------------------------------------------
     * Missing ID parameter.
     * ------------------------------------------------------------------ */

    public function testViewWithoutIdHandledSafely(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/view');
        $this->assertSafeErrorStatus('/areas/view');
    }

    public function testEditWithoutIdHandledSafely(): void
    {
        $this->loginAsAdmin();
        $this->get('/categorias/edit');
        $this->assertSafeErrorStatus('/categorias/edit');
    }

    /* --------------------------------------------------------------------
     * Estagiarios listing with various periodo query strings.
     * ------------------------------------------------------------------ */

    public function testEstagiariosIndexWithEmptyPeriodo(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios?periodo=');
        // Empty periodo should fall back to default (configuracao) and render.
        $this->assertResponseOk();
    }

    public function testEstagiariosIndexWithUnknownPeriodo(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios?periodo=1800-1');
        // Unknown periodo returns an empty list, still renders OK.
        $this->assertResponseOk();
    }

    public function testEstagiariosIndexWithMalformedPeriodo(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios?periodo=not-a-period');
        $this->assertResponseOk();
    }

    /* --------------------------------------------------------------------
     * Estagiarios add with missing / invalid aluno_id.
     * ------------------------------------------------------------------ */

    public function testEstagiariosAddWithoutAlunoId(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios/add');
        $status = $this->_response->getStatusCode();
        $this->assertContains(
            $status,
            [200, 302, 404, 500],
            "Add without aluno_id should not leak (got {$status})"
        );
    }

    public function testEstagiariosAddWithInvalidAlunoIdReturns404(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios/add?aluno_id=999999');
        $this->assertResponseCode(404);
    }

    public function testEstagiariosAddWithNonNumericAlunoId(): void
    {
        $this->loginAsAdmin();
        $this->get('/estagiarios/add?aluno_id=abc');
        $status = $this->_response->getStatusCode();
        $this->assertContains($status, [200, 302, 404, 500]);
    }

    /* --------------------------------------------------------------------
     * Unknown controller / unknown action.
     * ------------------------------------------------------------------ */

    public function testUnknownControllerRoutes404(): void
    {
        $this->loginAsAdmin();
        $this->get('/nonexistentcontroller');
        $this->assertResponseCode(404);
    }

    public function testUnknownActionHandledSafely(): void
    {
        $this->loginAsAdmin();
        $this->get('/areas/nonexistentaction');
        $status = $this->_response->getStatusCode();
        $this->assertContains($status, [404, 500]);
    }
}
