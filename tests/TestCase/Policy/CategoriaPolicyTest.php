<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Categoria;
use App\Model\Entity\User;
use App\Policy\CategoriaPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\CategoriaPolicy Test Case
 */
class CategoriaPolicyTest extends TestCase
{
    protected $CategoriaPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->CategoriaPolicy = new CategoriaPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->CategoriaPolicy);
        parent::tearDown();
    }

    protected function makeIdentity(array $data): IdentityInterface
    {
        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    public function testBefore(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->CategoriaPolicy->before($admin, new Categoria(), 'view'));
        $this->assertNull($this->CategoriaPolicy->before($aluno, new Categoria(), 'view'));
    }

    public function testCanView(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->CategoriaPolicy->canView($user, new Categoria())->getStatus());
    }

    public function testCanEditDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->CategoriaPolicy->canEdit($user, new Categoria())->getStatus());
    }

    public function testCanDeleteDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->CategoriaPolicy->canDelete($user, new Categoria())->getStatus());
    }
}
