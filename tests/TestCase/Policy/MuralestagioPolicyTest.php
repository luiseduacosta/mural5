<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Muralestagio;
use App\Model\Entity\User;
use App\Policy\MuralestagioPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\MuralestagioPolicy Test Case
 */
class MuralestagioPolicyTest extends TestCase
{
    protected $MuralestagioPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->MuralestagioPolicy = new MuralestagioPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->MuralestagioPolicy);
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
        $this->assertTrue($this->MuralestagioPolicy->before($admin, new Muralestagio(), 'view'));
        $this->assertNull($this->MuralestagioPolicy->before($aluno, new Muralestagio(), 'view'));
    }

    public function testCanView(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->MuralestagioPolicy->canView($user, new Muralestagio())->getStatus());
    }

    public function testCanEditDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->MuralestagioPolicy->canEdit($user, new Muralestagio())->getStatus());
    }

    public function testCanDeleteDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->MuralestagioPolicy->canDelete($user, new Muralestagio())->getStatus());
    }
}
