<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Complementos Controller
 *
 * @property \App\Model\Table\ComplementosTable $Complementos
 * @method \App\Model\Entity\Complemento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ComplementosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $complementos = $this->paginate($this->Complementos);

        $this->set(compact('complementos'));
    }

    /**
     * View method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $complemento = $this->Complementos->get($id, [
            'contain' => ['Estagiarios'],
        ]);
        $this->set(compact('complemento'));
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
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $complemento = $this->Complementos->newEmptyEntity();
        if ($this->request->is('post')) {
            $complemento = $this->Complementos->patchEntity($complemento, $this->request->getData());
            if ($this->Complementos->save($complemento)) {
                $this->Flash->success(__('Registro complemento inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro complemento nao foi inserido. Tente novamente.'));
        }
        $this->set(compact('complemento'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $complemento = $this->Complementos->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complemento = $this->Complementos->patchEntity($complemento, $this->request->getData());
            if ($this->Complementos->save($complemento)) {
                $this->Flash->success(__('Registro complemento atualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro complemento nao foi atualizado. Tente novamente.'));
        }
        $this->set(compact('complemento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        /** Autorização */
        $identity = $this->getRequest()->getAttribute('identity');
        $user = $identity->getOriginalData();
        if (!$user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);
        $complemento = $this->Complementos->get($id);
        if ($this->Complementos->delete($complemento)) {
            $this->Flash->success(__('Registro complemento excluido.'));
        } else {
            $this->Flash->error(__('Registro complemento nao foi excluido. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
