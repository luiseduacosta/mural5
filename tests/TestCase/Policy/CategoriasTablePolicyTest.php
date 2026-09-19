<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\CategoriasTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\CategoriasTablePolicy Test Case
 */
class CategoriasTablePolicyTest extends TestCase
{
    protected $CategoriasTablePolicy;
    protected $Categorias;

    protected array $fixtures = [
        'app.Users',
        'app.Categorias',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->CategoriasTablePolicy = new CategoriasTablePolicy();
        $this->Categorias = TableRegistry::getTableLocator()->get('Categorias');
    }

    protected function tearDown(): void
    {
        unset($this->CategoriasTablePolicy, $this->Categorias);
        parent::tearDown();
    }

    protected function getIdentity(string $categoria, int $id): IdentityInterface
    {
        $user = new User(['id' => $id, 'categoria' => $categoria, 'entidade_id' => $id]);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    public function testBeforeAdmin(): void
    {
        $admin = $this->getIdentity('1', 1);
        $this->assertTrue($this->CategoriasTablePolicy->before($admin, $this->Categorias, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->CategoriasTablePolicy->before($aluno, $this->Categorias, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->CategoriasTablePolicy->canIndex($aluno, $this->Categorias)->getStatus());
        $this->assertFalse($this->CategoriasTablePolicy->canIndex(null, $this->Categorias)->getStatus());
    }

    public function testCanAddDenied(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertFalse($this->CategoriasTablePolicy->canAdd($aluno, $this->Categorias)->getStatus());
    }
}
