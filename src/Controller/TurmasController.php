<?php

declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\NotFoundException;
/**
 * Turmas Controller
 *
 * @property \App\Model\Table\TurmasTable $Turmas
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Turma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TurmasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Turmas);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        $turmas = $this->paginate($this->Turmas);
        $this->set(compact('turmas'));
    }

    /**
     * View method
     *
     * @param string|null $id Turma id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        try {
            $turma = $this->Turmas->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de turmas para esse número!'));
            throw new NotFoundException(__('Não há registros de turmas para esse número!'));
        }

        try {
            $this->Authorization->authorize($turma);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('turma'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $turma = $this->Turmas->newEmptyEntity();
        try {
            $this->Authorization->authorize($turma);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $turma = $this->Turmas->patchEntity($turma, $this->request->getData());
            if ($this->Turmas->save($turma)) {
                $this->Flash->success(__('Turma inserida.'));

                return $this->redirect(['action' => 'view', $turma->id]);
            }
            $this->Flash->error(__('Não foi possível inserir a Turma. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('turma'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Turma id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $turma = $this->Turmas->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de turmas para esse número!'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($turma);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $turma = $this->Turmas->patchEntity($turma, $this->request->getData());
            if ($this->Turmas->save($turma)) {
                $this->Flash->success(__('Turma atualizada com sucesso.'));

                return $this->redirect(['action' => 'view', $turma->id]);
            }
            $this->Flash->error(__('Turma não foi atualizada. Tente novamente.'));
            // return $this->redirect(['action' => 'view', $turma->id]);
        }
        $this->set(compact('turma'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Turma id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $turma = $this->Turmas->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de turmas para esse número!'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($turma);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Turmas->delete($turma)) {
            $this->Flash->success(__('Turma excluída.'));
        } else {
            $this->Flash->error(__('Turma não foi excluída. Tente novamente.'));

            return $this->redirect(['action' => 'view', $turma->id]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
