<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\MuralestagiosTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\MuralestagiosTablePolicy Test Case
 */
class MuralestagiosTablePolicyTest extends TestCase
{
    protected $MuralestagiosTablePolicy;
    protected $Muralestagios;

    protected array $fixtures = [
        'app.Users',
        'app.Muralestagios',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->MuralestagiosTablePolicy = new MuralestagiosTablePolicy();
        $this->Muralestagios = TableRegistry::getTableLocator()->get('Muralestagios');
    }

    protected function tearDown(): void
    {
        unset($this->MuralestagiosTablePolicy, $this->Muralestagios);
        parent::tearDown();
    }

    protected function makeIdentity(array $data): IdentityInterface
    {
        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    public function testCanIndexAllowsEveryone(): void
    {
        $this->assertTrue($this->MuralestagiosTablePolicy->canIndex(null, $this->Muralestagios));

        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->MuralestagiosTablePolicy->canIndex($aluno, $this->Muralestagios));
    }

    public function testCanAddAdminOnly(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->MuralestagiosTablePolicy->canAdd($admin, $this->Muralestagios));
    }

    public function testCanAddDeniedForNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->MuralestagiosTablePolicy->canAdd($aluno, $this->Muralestagios));
    }

    public function testCanAddDeniedForNullUser(): void
    {
        $this->assertFalse($this->MuralestagiosTablePolicy->canAdd(null, $this->Muralestagios));
    }
}
