<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Configuracao;
use App\Model\Entity\User;
use App\Policy\ConfiguracaoPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\ConfiguracaoPolicy Test Case
 */
class ConfiguracaoPolicyTest extends TestCase
{
    protected $ConfiguracaoPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ConfiguracaoPolicy = new ConfiguracaoPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->ConfiguracaoPolicy);
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
        $this->assertTrue($this->ConfiguracaoPolicy->before($admin, new Configuracao(), 'view'));
        $this->assertNull($this->ConfiguracaoPolicy->before($aluno, new Configuracao(), 'view'));
    }

    public function testCanView(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->ConfiguracaoPolicy->canView($user, new Configuracao())->getStatus());
    }

    public function testCanEditDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->ConfiguracaoPolicy->canEdit($user, new Configuracao())->getStatus());
    }

    public function testCanDeleteDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->ConfiguracaoPolicy->canDelete($user, new Configuracao())->getStatus());
    }

    public function testCanAddDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->ConfiguracaoPolicy->canAdd($user, new Configuracao())->getStatus());
    }
}
