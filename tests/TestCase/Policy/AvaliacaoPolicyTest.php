<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Avaliacao;
use App\Model\Entity\Estagiario;
use App\Model\Entity\User;
use App\Policy\AvaliacaoPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\AvaliacaoPolicy Test Case
 */
class AvaliacaoPolicyTest extends TestCase
{
    /**
     * @var \App\Policy\AvaliacaoPolicy
     */
    protected $AvaliacaoPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->AvaliacaoPolicy = new AvaliacaoPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->AvaliacaoPolicy);
        parent::tearDown();
    }

    protected function makeIdentity(array $data): IdentityInterface
    {
        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    protected function makeAvaliacao(int $alunoId = 0, int $professorId = 0, int $supervisorId = 0): Avaliacao
    {
        $avaliacao = new Avaliacao();
        $avaliacao->estagiario = new Estagiario([
            'aluno_id' => $alunoId,
            'professor_id' => $professorId,
            'supervisor_id' => $supervisorId,
        ]);
        return $avaliacao;
    }

    public function testBeforeAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->AvaliacaoPolicy->before($admin, new Avaliacao(), 'view'));
    }

    public function testBeforeSupervisor(): void
    {
        $supervisor = $this->makeIdentity(['id' => 4, 'categoria' => '4', 'supervisor_id' => 4]);
        $this->assertTrue($this->AvaliacaoPolicy->before($supervisor, new Avaliacao(), 'view'));
    }

    public function testBeforeStudent(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2', 'aluno_id' => 2]);
        $this->assertNull($this->AvaliacaoPolicy->before($aluno, new Avaliacao(), 'view'));
    }

    public function testCanViewAlunoOwner(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2', 'aluno_id' => 2]);
        $this->assertTrue($this->AvaliacaoPolicy->canView($aluno, $this->makeAvaliacao(alunoId: 2))->getStatus());
    }

    public function testCanViewAlunoOtherDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2', 'aluno_id' => 2]);
        $this->assertFalse($this->AvaliacaoPolicy->canView($aluno, $this->makeAvaliacao(alunoId: 5))->getStatus());
    }

    public function testCanViewProfessorOwner(): void
    {
        $professor = $this->makeIdentity(['id' => 3, 'categoria' => '3', 'professor_id' => 3]);
        $this->assertTrue($this->AvaliacaoPolicy->canView($professor, $this->makeAvaliacao(professorId: 3))->getStatus());
    }

    public function testCanViewUnknownDenied(): void
    {
        $anon = $this->makeIdentity(['id' => 99, 'categoria' => '9']);
        $this->assertFalse($this->AvaliacaoPolicy->canView($anon, $this->makeAvaliacao())->getStatus());
    }

    public function testCanEditDenied(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertFalse($this->AvaliacaoPolicy->canEdit($admin, new Avaliacao())->getStatus());
    }

    public function testCanDeleteDenied(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertFalse($this->AvaliacaoPolicy->canDelete($admin, new Avaliacao())->getStatus());
    }
}
