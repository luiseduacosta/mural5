<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Instituicoes Controller
 *
 * @property \App\Model\Table\InstituicoesTable $Instituicoes
 * @method \App\Model\Entity\Instituicoes[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstituicoesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        /** Autorização */
        if (!$this->user || !$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $query = $this->Instituicoes->find('all')
                ->contain(['Areas', 'Supervisores', 'Estagiarios' => ['Alunos', 'Instituicoes', 'Professores', 'Supervisores'], 'Muralestagios', 'Visitas']);

        $instituicoes = $this->paginate($query);

        $this->set(compact('instituicoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Instituicao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        /** Autorização */
        if (!$this->user || !$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($id == null) {
            $this->Flash->error(__('Sem parâmetros para localizar a instituição!'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $instituicao = $this->Instituicoes->get($id, [
                'contain' => ['Areas', 'Supervisores', 'Estagiarios' => ['Alunos', 'Instituicoes', 'Professores', 'Supervisores'], 'Muralestagios', 'Visitas'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de instituicao de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('instituicao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        /** Autorização */
        if (!$this->user || !$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $instituicao = $this->Instituicoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $instituicao = $this->Instituicoes->patchEntity($instituicao, $this->request->getData());
            if ($this->Instituicoes->save($instituicao)) {
                $this->Flash->success(__('Registro instituicao inserido.'));
                return $this->redirect(['action' => 'view', $instituicao->id]);
            }
            $this->Flash->error(__('Não foi possível inserir o registro instituicao. Tente novamente.'));
        }
        $areas = $this->Instituicoes->Areas->find('list');
        $supervisores = $this->Instituicoes->Supervisores->find('list');
        $this->set(compact('instituicao', 'areas', 'supervisores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instituicao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        /** Autorização */
        if (!$this->user || !$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($id == null) {
            $this->Flash->error(__('Sem parâmetros para localizar a instituição!'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $instituicao = $this->Instituicoes->get($id, [
                'contain' => ['Supervisores'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de instituicao de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $instituicao = $this->Instituicoes->patchEntity($instituicao, $this->request->getData());
            if ($this->Instituicoes->save($instituicao)) {
                $this->Flash->success(__('Registro instituição atualizado.'));
                return $this->redirect(['action' => 'view', $instituicao->id]);
            }
            $this->Flash->error(__('Registro instituição não foi atualizado. Tente novamente.'));
        }
        $areas = $this->Instituicoes->Areas->find('list');
        $supervisores = $this->Instituicoes->Supervisores->find('list');
        $this->set(compact('instituicao', 'areas', 'supervisores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instituicao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        /** Autorização */
        if (!$this->user || !$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);

        if ($id == null) {
            $this->Flash->error(__('Sem parâmetros para localizar a instituição!'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $instituicao = $this->Instituicoes->get($id, [
                'contain' => ['Estagiarios']
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de instituicao de estagio para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        if (!empty($instituicao->estagiarios) && count($instituicao->estagiarios) > 0) {
            $this->Flash->error(__('Instituição com estagiários associados. Não é possível excluir.'));
            return $this->redirect(['action' => 'view', $id]);
        }
        if ($this->Instituicoes->delete($instituicao)) {
            $this->Flash->success(__('Registro instituicao excluído.'));
        } else {
            $this->Flash->error(__('Registro instituicao não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
