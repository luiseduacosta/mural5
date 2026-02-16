<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Alunoestagiarios Controller
 *
 * @property \App\Model\Table\AlunoestagiariosTable $Alunoestagiarios
 * @method \App\Model\Entity\Alunoestagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlunoestagiariosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        // Only admin can access this page
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $alunoestagiarios = $this->paginate($this->Alunoestagiarios);
        $this->set(compact('alunoestagiarios'));
    }

    /**
     * View method
     *
     * @param string|null $id Alunoestagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        // Only admin can access this page
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $alunoestagiario = $this->Alunoestagiarios->get($id, [
            'contain' => ['Estagiarios' => ['Instituicoes', 'Alunos', 'Professores', 'Supervisores']],
        ]);

        if (!isset($alunoestagiario)) {
            $this->Flash->error(__('Nao ha registros de aluno para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('alunoestagiario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        // Only admin can access this page
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $alunoestagiario = $this->Alunoestagiarios->newEmptyEntity();
        if ($this->request->is('post')) {
            $alunoestagiarioresultado = $this->Alunoestagiarios->patchEntity($alunoestagiario, $this->request->getData());
            if ($this->Alunoestagiarios->save($alunoestagiarioresultado)) {
                $this->Flash->success(__('Registro alunoestagiario inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro alunoestagiario nao foi inserido. Tente novamente.'));
        }
        $this->set(compact('alunoestagiario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alunoestagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        // Only admin can access this page
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $alunoestagiario = $this->Alunoestagiarios->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alunoestagiarioresultado = $this->Alunoestagiarios->patchEntity($alunoestagiario, $this->request->getData());
            if ($this->Alunoestagiarios->save($alunoestagiarioresultado)) {
                $this->Flash->success(__('Registro alunoestagiario atualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro alunoestagiario nao atualizado. Tente novamente.'));
        }
        $this->set(compact('alunoestagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alunoestagiario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        // Only admin can access this page
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);
        $alunoestagiario = $this->Alunoestagiarios->get($id, [
            'contain' => ['Estagiarios']
        ]);
        if (sizeof($alunoestagiario->estagiarios) > 0) {
            $this->Flash->error(__('Aluno estagiários tem estagiários associados.'));
            return $this->redirect(['controller' => 'alunoestagiarios', 'action' => 'view', $id]);
        }
        if ($this->Alunoestagiarios->delete($alunoestagiario)) {
            $this->Flash->success(__('Registro alunoestagiario excluido.'));
        } else {
            $this->Flash->error(__('Registro alunoestagiario nao foi excluido. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
