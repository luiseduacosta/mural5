<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Folhadeatividade;
use App\Model\Entity\User;
use App\Policy\FolhadeatividadePolicy;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\FolhadeatividadePolicy Test Case
 */
class FolhadeatividadePolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\FolhadeatividadePolicy
     */
    protected $FolhadeatividadePolicy;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->FolhadeatividadePolicy = new FolhadeatividadePolicy();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FolhadeatividadePolicy);
        parent::tearDown();
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
        $admin = $this->getIdentity('1', 1);
        $aluno = $this->getIdentity('2', 2);

        $this->assertTrue($this->FolhadeatividadePolicy->before($admin, new Folhadeatividade(), 'view'));
        $this->assertNull($this->FolhadeatividadePolicy->before($aluno, new Folhadeatividade(), 'view'));
    }

    public function testCanView(): void
    {
        $alunoId = 2;
        $aluno = $this->getIdentity('2', $alunoId);
        $otherAluno = $this->getIdentity('2', 99);

        $resource = new Folhadeatividade([
            'estagiario' => new \App\Model\Entity\Estagiario([
                'aluno' => new \App\Model\Entity\Aluno(['user_id' => $alunoId])
            ])
        ]);

        $this->assertTrue($this->FolhadeatividadePolicy->canView($aluno, $resource)->getStatus());
        $this->assertFalse($this->FolhadeatividadePolicy->canView($otherAluno, $resource)->getStatus());
    }

    public function testCanAdd(): void
    {
        $alunoId = 2;
        $aluno = $this->getIdentity('2', $alunoId);
        
        $this->assertTrue($this->FolhadeatividadePolicy->canAdd($aluno, new Folhadeatividade())->getStatus());
    }

    public function testCanEdit(): void
    {
        $alunoId = 2;
        $aluno = $this->getIdentity('2', $alunoId);
        $otherAluno = $this->getIdentity('2', 99);
        
        $resource = new Folhadeatividade([
            'estagiario' => new \App\Model\Entity\Estagiario([
                'aluno' => new \App\Model\Entity\Aluno(['user_id' => $alunoId])
            ])
        ]);

        $this->assertTrue($this->FolhadeatividadePolicy->canEdit($aluno, $resource)->getStatus());
        $this->assertFalse($this->FolhadeatividadePolicy->canEdit($otherAluno, $resource)->getStatus());
    }

    public function testCanDelete(): void
    {
        $alunoId = 2;
        $aluno = $this->getIdentity('2', $alunoId);
        $otherAluno = $this->getIdentity('2', 99);

        $resource = new Folhadeatividade([
            'estagiario' => new \App\Model\Entity\Estagiario([
                'aluno' => new \App\Model\Entity\Aluno(['user_id' => $alunoId])
            ])
        ]);

        $this->assertTrue($this->FolhadeatividadePolicy->canDelete($aluno, $resource)->getStatus());
        $this->assertFalse($this->FolhadeatividadePolicy->canDelete($otherAluno, $resource)->getStatus());
    }
}
