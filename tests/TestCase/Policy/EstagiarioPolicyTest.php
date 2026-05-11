<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Aluno;
use App\Model\Entity\Estagiario;
use App\Model\Entity\User;
use App\Policy\EstagiarioPolicy;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\EstagiarioPolicy Test Case
 */
class EstagiarioPolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\EstagiarioPolicy
     */
    protected $EstagiarioPolicy;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->EstagiarioPolicy = new EstagiarioPolicy();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EstagiarioPolicy);
        parent::tearDown();
    }

    protected function getAdminIdentity(): \Authorization\IdentityInterface
    {
        $user = new User([
            'id' => 1,
            'categoria' => '1',
            'entidade_id' => 1,
        ]);
        $user->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        return new \Authorization\Identity($service, $user);
    }

    protected function getIdentity(string $categoria, int $id): \Authorization\IdentityInterface
    {
        $data = [
            'id' => $id,
            'categoria' => $categoria,
            'entidade_id' => $id,
        ];
        
        if ($categoria === '2') {
            $data['aluno_id'] = $id;
        } elseif ($categoria === '3') {
            $data['professor_id'] = $id;
        } elseif ($categoria === '4') {
            $data['supervisor_id'] = $id;
        }

        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        return new \Authorization\Identity($service, $user);
    }

    public function testBefore(): void
    {
        $admin = $this->getAdminIdentity();
        $this->assertTrue($this->EstagiarioPolicy->before($admin, new Estagiario(), 'view'));

        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->EstagiarioPolicy->before($aluno, new Estagiario(), 'view'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->EstagiarioPolicy->canIndex($aluno)->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->EstagiarioPolicy->canAdd($aluno, new Estagiario())->getStatus());
        $this->assertFalse($this->EstagiarioPolicy->canAdd(null, new Estagiario())->getStatus());
    }

    public function testCanView(): void
    {
        $alunoId = 2;
        $professorId = 3;
        $supervisorId = 4;
        $unrelatedUserId = 5;

        $aluno = clone $this->getIdentity('2', $alunoId);
        $professor = clone $this->getIdentity('3', $professorId);
        $supervisor = clone $this->getIdentity('4', $supervisorId);
        $unrelatedAluno = clone $this->getIdentity('2', $unrelatedUserId);

        $resource = new Estagiario([
            'professor_id' => $professorId,
            'supervisor_id' => $supervisorId,
            'aluno' => new Aluno(['user_id' => $alunoId])
        ]);

        // Supervisor associated with the estagiario
        $this->assertTrue($this->EstagiarioPolicy->canView($supervisor, $resource)->getStatus());
        
        // Professor associated with the estagiario
        $this->assertTrue($this->EstagiarioPolicy->canView($professor, $resource)->getStatus());
        
        // Aluno owning the estagiario
        $this->assertTrue($this->EstagiarioPolicy->canView($aluno, $resource)->getStatus());

        // Unrelated user
        $this->assertFalse($this->EstagiarioPolicy->canView($unrelatedAluno, $resource)->getStatus());
    }

    public function testCanEdit(): void
    {
        $alunoId = 2;
        $professorId = 3;

        $aluno = clone $this->getIdentity('2', $alunoId);
        $professor = clone $this->getIdentity('3', $professorId);
        $unrelatedAluno = clone $this->getIdentity('2', 99);

        $resource = new Estagiario([
            'professor_id' => $professorId,
            'aluno' => new Aluno(['user_id' => $alunoId])
        ]);

        $this->assertTrue($this->EstagiarioPolicy->canEdit($professor, $resource)->getStatus());
        $this->assertTrue($this->EstagiarioPolicy->canEdit($aluno, $resource)->getStatus());
        $this->assertFalse($this->EstagiarioPolicy->canEdit($unrelatedAluno, $resource)->getStatus());
    }

    public function testCanLancanota(): void
    {
        $professor = $this->getIdentity('3', 3);
        $aluno = $this->getIdentity('2', 2);

        $this->assertTrue($this->EstagiarioPolicy->canLancanota($professor)->getStatus());
        $this->assertFalse($this->EstagiarioPolicy->canLancanota($aluno)->getStatus());
    }

    public function testCanDelete(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertFalse($this->EstagiarioPolicy->canDelete($aluno, new Estagiario())->getStatus());
    }
}
