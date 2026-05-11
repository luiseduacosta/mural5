<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Complemento;
use App\Model\Entity\User;
use App\Policy\ComplementoPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\ComplementoPolicy Test Case
 */
class ComplementoPolicyTest extends TestCase
{
    protected $ComplementoPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ComplementoPolicy = new ComplementoPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->ComplementoPolicy);
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
        $this->assertTrue($this->ComplementoPolicy->before($admin, new Complemento(), 'view'));
        $this->assertNull($this->ComplementoPolicy->before($aluno, new Complemento(), 'view'));
    }

    public function testCanView(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->ComplementoPolicy->canView($user, new Complemento())->getStatus());
    }

    public function testCanEditDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->ComplementoPolicy->canEdit($user, new Complemento())->getStatus());
    }

    public function testCanDeleteDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->ComplementoPolicy->canDelete($user, new Complemento())->getStatus());
    }
}
