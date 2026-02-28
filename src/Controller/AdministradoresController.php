<?php

declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;

/**
 * Administradores Controller
 *
 * @property \App\Model\Table\AdministradoresTable $Administradores
 * @method \App\Model\Entity\Administrador[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdministradoresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Administradores);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Não autorizado!'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $administradores = $this->paginate($this->Administradores);

        $this->set(compact('administradores'));
    }

    /**
     * View method
     *
     * @param string|null $id Administrador id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $administrador = $this->Administradores->get($id, [
            'contain' => ['Users'],
        ]);

        try {
            $this->Authorization->authorize($administrador);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Não autorizado!'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->set(compact('administrador'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $administrador = $this->Administradores->newEmptyEntity();

        try {
            $this->Authorization->authorize($administrador);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Não autorizado!'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }
        if ($this->request->is('post')) {
            $administrador = $this->Administradores->patchEntity($administrador, $this->request->getData());

            if (!$administrador->user_id) {
                $administrador->user_id = $this->user->id;
            }

            if ($this->Administradores->save($administrador)) {
                $this->Flash->success(__('Administrador inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Administrador não foi inserido. Tente novamente.'));
        }
        $users = $this->Administradores->Users->find('list', ['limit' => 200]);
        $this->set(compact('administrador', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Administrador id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $administrador = $this->Administradores->get($id);

        try {
            $this->Authorization->authorize($administrador);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Não autorizado!'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $administrador = $this->Administradores->patchEntity($administrador, $this->request->getData());
            if ($this->Administradores->save($administrador)) {
                $this->Flash->success(__('Registro administrador atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro administrador não foi atualizado. Tente novamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }
        $users = $this->Administradores->Users->find('list', ['limit' => 200]);
        $this->set(compact('administrador', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Administrador id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $administrador = $this->Administradores->get($id);

        try {
            $this->Authorization->authorize($administrador);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Não autorizado!'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }
        if ($this->Administradores->delete($administrador)) {
            $this->Flash->success(__('Registro administrador foi excluído.'));
        } else {
            $this->Flash->error(__('Registro administrador não foi excluído. Tente novamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
