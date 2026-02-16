<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Turmaestagios Controller
 *
 * @property \App\Model\Table\TurmaestagiosTable $Turmaestagios
 * @method \App\Model\Entity\Turmaestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TurmaestagiosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        /** Autorização: Alunos não podem ver a listagem geral */
        $user = $this->getRequest()->getAttribute('identity');
        if ($user->isStudent()) {
            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $user->aluno_id]);
        }
        $turmaestagios = $this->paginate($this->Turmaestagios);

        $this->set(compact('turmaestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Turmaestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        /** Autorização: Alunos não podem ver detalhes de turmas não relacionadas a eles (ou simplesmente não podem ver detalhes de turmas) */
        $user = $this->getRequest()->getAttribute('identity');
        if ($user->isStudent()) {
            $this->Flash->error(__('Não autorizado!'));
            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $user->aluno_id]);
        }

        ini_set('memory_limit', '2048M');
        $turmaestagio = $this->Turmaestagios->get($id, [
            'contain' => ['Estagiarios' => ['Alunos', 'Professores', 'Supervisores', 'Instituicoes']],
        ]);

        if (!isset($turmaestagio)) {
            $this->Flash->error(__('Nao ha registros de turmas de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('turmaestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1) {
            $turmaestagio = $this->Turmaestagios->newEmptyEntity();
            if ($this->request->is('post')) {
                $turmaestagio = $this->Turmaestagios->patchEntity($turmaestagio, $this->request->getData());
                if ($this->Turmaestagios->save($turmaestagio)) {
                    $this->Flash->success(__('Turma de estagio inserida.'));
                    return $this->redirect(['action' => 'view', $turmaestagio->id]);
                }
                $this->Flash->error(__('Não foi possível inserir a Turma de estagio. Tente novamente.'));
            }
            $this->set(compact('turmaestagio'));
        } else {
            $this->Flash->error(__('Não autorizado!'));
            return $this->redirect(['controller' => 'Turmaestagios', 'action' => 'index']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Turmaestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1) {            
            $turmaestagio = $this->Turmaestagios->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $turmaestagio = $this->Turmaestagios->patchEntity($turmaestagio, $this->request->getData());
                if ($this->Turmaestagios->save($turmaestagio)) {
                    $this->Flash->success(__('Turma de estagio atualizada.'));
                    return $this->redirect(['action' => 'view', $turmaestagio->id]);
                }
                $this->Flash->error(__('Turma de estágio não foi atualizada. Tente novamente.'));
            }
            $this->set(compact('turmaestagio'));
        } else {
            $this->Flash->error(__('Não autorizado!'));
            return $this->redirect(['controller' => 'Turmaestagios', 'action' => 'view', $id]);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Turmaestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1) {
            $this->request->allowMethod(['post', 'delete']);
            $turmaestagio = $this->Turmaestagios->get($id, [
                'contain' => ['Estagiarios']
            ]);
            if (sizeof($turmaestagio->estagiarios) > 0) {
                $this->Flash->error(__("Não pode ser excluida porque têm estagiários associados."));
                return $this->redirect(['controller' => 'Turmaestagios', 'action' => 'view', $id]);
            }
            if ($this->Turmaestagios->delete($turmaestagio)) {
                $this->Flash->success(__('Turma de estágio excluída.'));
            } else {
                $this->Flash->error(__('Turma de estágio não foi excluída. Tente novamente.'));
            }
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Não autorizado!'));
            return $this->redirect(['controller' => 'Turmaestagios', 'action' => 'view', $id]);
        }
    }
}
