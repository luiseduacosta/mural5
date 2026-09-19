<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\UsersTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\UsersTablePolicy Test Case
 */
class UsersTablePolicyTest extends TestCase
{
    protected $UsersTablePolicy;
    protected $Users;

    protected array $fixtures = [
        'app.Users',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->UsersTablePolicy = new UsersTablePolicy();
        $this->Users = TableRegistry::getTableLocator()->get('Users');
    }

    protected function tearDown(): void
    {
        unset($this->UsersTablePolicy, $this->Users);
        parent::tearDown();
    }

    protected function makeIdentity(array $data): IdentityInterface
    {
        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    public function testBeforeAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->UsersTablePolicy->before($admin, $this->Users, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertNull($this->UsersTablePolicy->before($aluno, $this->Users, 'index'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->UsersTablePolicy->before(null, $this->Users, 'index'));
    }

    public function testScopeIndexAdminNoFilter(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $query = $this->Users->find();
        $scoped = $this->UsersTablePolicy->scopeIndex($admin, clone $query);
        $this->assertEmpty($scoped->clause('where'));
    }

    public function testScopeIndexNonAdminFiltersById(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $query = $this->Users->find();
        $scoped = $this->UsersTablePolicy->scopeIndex($aluno, clone $query);
        $this->assertNotEmpty($scoped->clause('where'));
    }
}
