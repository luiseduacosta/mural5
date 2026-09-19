<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Questao;
use App\Model\Entity\User;
use App\Policy\QuestaoPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\QuestaoPolicy Test Case
 */
class QuestaoPolicyTest extends TestCase
{
    protected $QuestaoPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->QuestaoPolicy = new QuestaoPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->QuestaoPolicy);
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
        $this->assertTrue($this->QuestaoPolicy->before($admin, new Questao(), 'view'));
        $this->assertNull($this->QuestaoPolicy->before($aluno, new Questao(), 'view'));
    }

    public function testCanAddAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->QuestaoPolicy->canAdd($admin, new Questao())->getStatus());
    }

    public function testCanAddNonAdminDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->QuestaoPolicy->canAdd($aluno, new Questao())->getStatus());
    }

    public function testCanAddNullDenied(): void
    {
        $this->assertFalse($this->QuestaoPolicy->canAdd(null, new Questao())->getStatus());
    }

    public function testCanEditAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->QuestaoPolicy->canEdit($admin, new Questao())->getStatus());
    }

    public function testCanEditNonAdminDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->QuestaoPolicy->canEdit($aluno, new Questao())->getStatus());
    }

    public function testCanDeleteAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->QuestaoPolicy->canDelete($admin, new Questao())->getStatus());
    }

    public function testCanDeleteNonAdminDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->QuestaoPolicy->canDelete($aluno, new Questao())->getStatus());
    }

    public function testCanView(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->QuestaoPolicy->canView($user, new Questao())->getStatus());
    }

    public function testCanViewNullDenied(): void
    {
        $this->assertFalse($this->QuestaoPolicy->canView(null, new Questao())->getStatus());
    }
}
