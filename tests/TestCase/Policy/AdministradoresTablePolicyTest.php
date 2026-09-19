<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\AdministradoresTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\AdministradoresTablePolicy Test Case
 */
class AdministradoresTablePolicyTest extends TestCase
{
    /**
     * @var \App\Policy\AdministradoresTablePolicy
     */
    protected $AdministradoresTablePolicy;

    /**
     * @var \App\Model\Table\AdministradoresTable
     */
    protected $Administradores;

    protected array $fixtures = [
        'app.Users',
        'app.Administradores',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->AdministradoresTablePolicy = new AdministradoresTablePolicy();
        $this->Administradores = TableRegistry::getTableLocator()->get('Administradores');
    }

    protected function tearDown(): void
    {
        unset($this->AdministradoresTablePolicy, $this->Administradores);
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
        $this->assertTrue($this->AdministradoresTablePolicy->before($admin, $this->Administradores, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->AdministradoresTablePolicy->before($aluno, $this->Administradores, 'index'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->AdministradoresTablePolicy->before(null, $this->Administradores, 'index'));
    }

    public function testCanIndexAuthenticated(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->AdministradoresTablePolicy->canIndex($aluno, $this->Administradores)->getStatus());
    }

    public function testCanIndexUnauthenticated(): void
    {
        $this->assertFalse($this->AdministradoresTablePolicy->canIndex(null, $this->Administradores)->getStatus());
    }
}
