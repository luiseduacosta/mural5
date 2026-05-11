<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Questionario;
use App\Model\Entity\User;
use App\Policy\QuestionarioPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\QuestionarioPolicy Test Case
 */
class QuestionarioPolicyTest extends TestCase
{
    protected $QuestionarioPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->QuestionarioPolicy = new QuestionarioPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->QuestionarioPolicy);
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
        $this->assertTrue($this->QuestionarioPolicy->before($admin, new Questionario(), 'view'));
        $this->assertNull($this->QuestionarioPolicy->before($aluno, new Questionario(), 'view'));
    }

    public function testCanAddAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->QuestionarioPolicy->canAdd($admin, new Questionario())->getStatus());
    }

    public function testCanAddNonAdminDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->QuestionarioPolicy->canAdd($aluno, new Questionario())->getStatus());
    }

    public function testCanEditAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->QuestionarioPolicy->canEdit($admin, new Questionario())->getStatus());
    }

    public function testCanEditNonAdminDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->QuestionarioPolicy->canEdit($aluno, new Questionario())->getStatus());
    }

    public function testCanDeleteAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->QuestionarioPolicy->canDelete($admin, new Questionario())->getStatus());
    }

    public function testCanDeleteNonAdminDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->QuestionarioPolicy->canDelete($aluno, new Questionario())->getStatus());
    }

    public function testCanView(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->QuestionarioPolicy->canView($user, new Questionario())->getStatus());
    }

    public function testCanViewNullDenied(): void
    {
        $this->assertFalse($this->QuestionarioPolicy->canView(null, new Questionario())->getStatus());
    }
}
