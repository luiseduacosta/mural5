<?php
declare(strict_types=1);

namespace App\Controller;

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
        if ($this->request->is('post')) {
            $administrador = $this->Administradores->patchEntity($administrador, $this->request->getData());

            if (!$administrador->user_id) {
                $user = $this->Authentication->getIdentity();
                $administrador->user_id = $user->get('id');
            }

            if ($this->Administradores->save($administrador)) {
                $this->Flash->success(__('Administrador inserido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Administrador não foi inserido. Tente novamente.'));
        }
        $this->set(compact('administrador'));
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $administrador = $this->Administradores->patchEntity($administrador, $this->request->getData());
            if ($this->Administradores->save($administrador)) {
                $this->Flash->success(__('Registro administrador atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro administrador não foi atualizado. Tente novamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }
        $this->set(compact('administrador'));
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
        $this->viewBuilder()->setLayout(null);
        $this->request->allowMethod(['post', 'delete']);
        $administrador = $this->Administradores->get($id);
        if ($this->Administradores->delete($administrador)) {
            $this->Flash->success(__('Registro administrador foi excluído.'));
        } else {
            $this->Flash->error(__('Registro administrador não foi excluído. Tente novamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
