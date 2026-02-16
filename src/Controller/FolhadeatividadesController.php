<?php

declare(strict_types=1);

namespace App\Controller;
use App\Model\Entity\Folhadeatividade;

/**
 * Folhadeatividades Controller
 *
 * @property \App\Model\Table\FolhadeatividadesTable $Folhadeatividades
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FolhadeatividadesController extends AppController
{

    /**
     * Index method
     * @param string|null $id Estagiario.id
     * $id = estagiario_id
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent() || !$this->user->isProfessor() || !$this->user->isSupervisor()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id) {
            $folhadeatividades = $this->Folhadeatividades->find('all')
                ->contain(['Estagiarios' => ['Supervisores', 'Professores']])
                ->order(['Folhadeatividades.id'])
                ->where(['estagiario_id' => $estagiario_id]);

            $estagiariotabela = $this->fetchTable('Estagiarios');
            $estagiario = $estagiariotabela->find()
                ->contain(['Alunos', 'Instituicoes', 'Supervisores', 'Professores'])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->first();
        }

        if (empty($folhadeatividades)) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect(['controller' => 'folhadeatividades', 'action' => 'add', '?' => ['estagiario_id' => $estagiario_id]]);
        }

        $folhadeatividades = $this->paginate($folhadeatividades);

        $this->set(compact('estagiario', 'folhadeatividades'));
    }

    /**
     * Add method
     * @param string|null $id Estagiario.id
     * $id = estagiario_id
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function add($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent()) {
            if ($this->user->isStudent()) {
                $estagiario = $this->Estagiarios->find()
                    ->where(['id' => $id, 'aluno_id' => $this->user->aluno_id])
                    ->first();
                if (!$estagiario) {
                    $this->Flash->error(__('Usuario nao autorizado.'));
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
            }
        }

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');

        if ($estagiario_id) {
            $folhadeatividades = $this->Folhadeatividades->find('all')
                ->order(['Folhadeatividades.id'])
                ->contain(['Estagiarios' => ['Alunos', 'Instituicoes']])
                ->where(['estagiario_id' => $estagiario_id]);

            $estagiariotabela = $this->fetchTable('Estagiarios');
            $estagiario = $estagiariotabela->find()
                ->contain(['Alunos', 'Instituicoes'])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->first();
        }

        if (empty($folhadeatividades)) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect(['controller' => 'folhadeatividades', 'action' => 'add', '?' => ['estagiario_id' => $estagiario_id]]);
        }

        $folhadeatividadeentity = $this->Folhadeatividades->newEmptyEntity();

        if ($this->request->is('post')) {
            // pr($this->request->getData());
            $dados = $this->request->getData();
            // Calculate horario: $dados->horario = $dados->final - $dados->inicio using DateTime
            $dados['horario'] = null;
            $dados['horario'] = (new \DateTime($dados['final']))->diff(new \DateTime($dados['inicio']))->format('%H:%I:%S');
            $folhadeatividaderesposta = $this->Folhadeatividades->patchEntity($folhadeatividadeentity, $dados);
            // pr($folhadeatividaderesposta);
            // die();
            if ($this->Folhadeatividades->save($folhadeatividaderesposta)) {
                $this->Flash->success(__('Atividades cadastrada!'));

                return $this->redirect(['action' => 'view', $folhadeatividaderesposta->id]);
            }
            $this->Flash->error(__('Atividade não foi cadastrada. Tente mais uma vez.'));
        } else {
            // die('post');
        }

        $this->set('folhadeatividade', $folhadeatividadeentity);
        $this->set('estagiario', $estagiario);
    }

    /**
     * View method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent() || !$this->user->isProfessor() || !$this->user->isSupervisor()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id) {
            $folhadeatividade = $this->Folhadeatividades->find()
                ->where(['estagiario_id' => $estagiario_id])
                ->first();
        } else {
            $folhadeatividade = $this->Folhadeatividades->get($id, [
                'contain' => ['Estagiarios'],
            ]);
        }

        if (!isset($folhadeatividade)) {
            $this->Flash->error(__('Sem atividades cadastradas'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'view', isset($estagiario_id) ? $estagiario_id : $id]);
        }
        $this->set(compact('folhadeatividade'));
    }

    /**
     * Imprimefolhadeatividades method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function imprimefolhadeatividades($id = null)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent() || !$this->user->isProfessor() || !$this->user->isSupervisor()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $registro = $this->getRequest()->getQuery('registro');
        if ($registro) {
            $estagiariotable = $this->fetchTable('Estagiarios');
            $estagiario = $estagiariotable->find()
                ->where(['registro' => $registro])
                ->first();
            if ($estagiario) {

                $this->viewBuilder()->enableAutoLayout(false);
                $this->viewBuilder()->setClassName('CakePdf.Pdf');
                $this->viewBuilder()->setOption(
                    'pdfConfig',
                    [
                        'orientation' => 'portrait',
                        'download' => true, // This can be omitted if "filename" is specified.
                        'filename' => 'atividades_de_estagio_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                    ]
                );
                $this->set('estagiario', $estagiario);
            } else {
                $this->Flash->error(__('Aluno ainda sem estágio. Tente novamente'));
                return $this->redirect(['controller' => 'alunos', 'action' => 'view', '?' => ['registro' => $registro]]);
            }
        } else {
            $this->Flash->error(__('Sem número de registro. Tente novamente'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'index']);
        }
    }

    /**
     * Exadd method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function exadd($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        /** Verifica se há estagiários */
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        $estagiariostabela = $this->fetchTable('Estagiarios');
        $estagiario = $estagiariostabela->find()
            ->contain(['Alunos', 'Instituicoes', 'Supervisores', 'Professores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();

        if (!$estagiario) {
            $this->Flash->error(__('Aluno sem estágio cadastrado'));
            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'view', $estagiario_id]);
        }

        $atividadesrealizadas = $this->Folhadeatividades->find()
            ->contain(['Estagiarios' => ['Alunos', 'Supervisores', 'Professores', 'Instituicoes']])
            ->where(['estagiario_id' => $estagiario_id])
            ->limit(1)
            ->first();

        $folhadeatividade = $this->Folhadeatividades->newEmptyEntity();

        if ($this->request->is('post')) {
            $folhadeatividaderesposta = $this->Folhadeatividades->patchEntity($folhadeatividade, $this->request->getData());
            if ($this->Folhadeatividades->save($folhadeatividaderesposta)) {
                $this->Flash->success(__('Atividades cadastrada!'));

                return $this->redirect(['action' => 'view', $folhadeatividaderesposta->id]);
            }
            $this->Flash->error(__('Atividade não foi cadastrada. Tente mais uma vez.'));
        }

        $this->set(compact('folhadeatividade', 'atividadesrealizadas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent()) {
            if ($this->user->isStudent()) {
                $estagiario = $this->Estagiarios->find()
                    ->where(['id' => $id, 'aluno_id' => $this->user->aluno_id])
                    ->first();
                if (!$estagiario) {
                    $this->Flash->error(__('Usuario nao autorizado.'));
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
            }
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $folhadeatividade = $this->Folhadeatividades->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dados = $this->request->getData();
            $dados['horario'] = null;
            $dados['horario'] = (new \DateTime($dados['final']))->diff(new \DateTime($dados['inicio']))->format('%H:%I:%S');
            $folhadeatividade = $this->Folhadeatividades->patchEntity($folhadeatividade, $dados);
            if ($this->Folhadeatividades->save($folhadeatividade)) {
                $this->Flash->success(__('Atividade atualizada.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Não foi possível atualizar. Tente outra vez.'));
        }
        $estagiario = $this->Folhadeatividades->find()
            ->where(['Folhadeatividades.id' => $id])
            ->contain(['Estagiarios' => ['Alunos']])
            ->select(['Estagiarios.id', 'Alunos.nome'])
            ->first();

        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent()) {
            if ($this->user->isStudent()) {
                $estagiario = $this->Estagiarios->find()
                    ->where(['id' => $id, 'aluno_id' => $this->user->aluno_id])
                    ->first();
                if (!$estagiario) {
                    $this->Flash->error(__('Usuario nao autorizado.'));
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
            }
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);
        $folhadeatividade = $this->Folhadeatividades->get($id);
        $estagiariotabela = $this->fetchTable('Estagiarios');
        $estagiario = $estagiariotabela->find()
            ->where(['id' => $folhadeatividade->estagiario_id])
            ->first();

        if ($this->Folhadeatividades->delete($folhadeatividade)) {
            $this->Flash->success(__('Registro de atividade excluido.'));
            return $this->redirect(['controller' => 'estagiarios', 'action' => 'view', $estagiario->id]);
        } else {
            $this->Flash->error(__('Registro de atividade nao foi excluido. Tente novamente.'));
            return $this->redirect(['controller' => 'folhadeatividades', 'action' => 'view', $id]);
        }
    }

    /**
     * Selecionafolhadeatividades method
     *
     * @param string|null $id Estagiario.id
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function selecionafolhadeatividades($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent()) {
            if ($this->user->isStudent()) {
                $estagiario = $this->Estagiarios->find()
                    ->where(['id' => $id, 'aluno_id' => $this->user->aluno_id])
                    ->first();
                if (!$estagiario) {
                    $this->Flash->error(__('Usuario nao autorizado.'));
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
            }
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->layout = false;
        $estagiario_id = $this->getRequest()->getSession()->read('estagiario_id');
        if (!$estagiario_id) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));
            return $this->redirect('/estagiarios/index');
        } else {
            $estagiariostabela = $this->fetchTable('Estagiarios');
            $estagiario = $estagiariostabela->find()
                ->contain(['Alunos', 'Supervisores', 'Instituicoes'])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->orderByDesc('nivel')
                ->all()
                ->last();
            $this->set('estagiario', $estagiario);
            return $this->redirect(['controller' => 'alunos', 'action' => 'view', $estagiario->aluno_id]);
        }
     }

    /**
     * Folhadeatividadespdf method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function folhadeatividadespdf($id = NULL)
    {

        /** Autorização */
        if (!$this->user->isAdmin() || !$this->user->isStudent()) {
            if ($this->user->isStudent()) {
                $estagiario = $this->Estagiarios->find()
                    ->where(['id' => $id, 'aluno_id' => $this->user->aluno_id])
                    ->first();
                if (!$estagiario) {
                    $this->Flash->error(__('Usuario nao autorizado.'));
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
            }
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        $this->layout = false;
        $atividades = $this->Folhadeatividades->find()
            ->contain(['Estagiarios' => ['Alunos', 'Professores', 'Instituicoes', 'Supervisores']])
            ->where(['Folhadeatividades.estagiario_id' => $estagiario_id])
            ->all();

        $estagiario = $this->Folhadeatividades->Estagiarios->find()
            ->contain(['Alunos', 'Professores', 'Instituicoes', 'Supervisores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();
        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => 'folha_de_atividades_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('atividades', $atividades);
        $this->set('estagiario', $estagiario);
    }
}
