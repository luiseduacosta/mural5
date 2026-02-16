<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Supervisores Controller
 *
 * @property \App\Model\Table\SupervisoresTable $Supervisores
 * @method \App\Model\Entity\Supervisor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupervisoresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        /** Autorização */
        // Everybody that is logged in can access this page
        if (!$this->user->isAdmin() || $this->user->isProfessor() || $this->user->isSupervisor() || $this->user->isStudent()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $supervisores = $this->paginate($this->Supervisores);

        $this->set(compact('supervisores'));
    }

    /**
     * View method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        /** Autorização */
        // Everybody that is logged Admin, professor or supervisor can access this page
        if (!$this->user->isAdmin() || $this->user->isProfessor() || $this->user->isSupervisor()) {
            if ($this->user->isSupervisor()) {
                $supervisor = $this->Supervisores->get($id);
                if ($this->user->id != $supervisor->user_id) {
                    $this->Flash->error(__('Usuario nao autorizado.'));
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
            }
        }

        $supervisor = $this->Supervisores->get($id, [
            'contain' => [
                'Instituicoes' => ['sort' => ['Instituicoes.instituicao ASC']],
                'Estagiarios' => ['sort' => ['Estagiarios.periodo DESC'], 'Alunos' => ['sort' => ['Alunos.nome ASC']], 'Professores', 'Folhadeatividades', 'Avaliacoes']
            ]
        ]);

        if (!isset($supervisor)) {
            $this->Flash->error(__('Nao ha registros de supervisor para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }


        $this->set(compact('supervisor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        /** Autorização */
        // Everybody that is logged Admin, professor or supervisor can access this page
        if (!$this->user->isAdmin() || $this->user->isSupervisor()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        /* Estes dados vêm da função add ou login do UsersController. Envio paro o formulário */
        $cress = $this->getRequest()->getQuery('cress');
        $email = $this->getRequest()->getQuery('email');

        /** Envio para o formulário */
        if ($cress) {
            $this->set('cress', $cress);
        }
        if ($email) {
            $this->set('email', $email);
        }

        /* Verifico se já está cadastrado */
        if ($cress) {
            $supervisorcadastrado = $this->Supervisores->find()
                ->where(['cress' => $cress])
                ->first();

            if ($supervisorcadastrado):
                $this->Flash->error(__('Supervisor(a) já cadastrado(a)'));
                return $this->redirect(['view' => $supervisorcadastrado->id]);
            endif;
        }

        $supervisor = $this->Supervisores->newEmptyEntity();

        if ($this->request->is('post')) {

            /**
             * Verifico se já é um usuário cadastrado no users.
             * Isto pode acontecer por exemplo quando para recuperar a senha é excluido o usuário.
             */
            $cress = $this->request->getData('cress');
            $usercadastrado = $this->fetchTable('Users')->find()
                ->where(['categoria_id' => 4, 'registro' => $cress])
                ->first();
            if (empty($usercadastrado)):
                $this->Flash->error(__('Supervisor(a) naõ cadastrado(a) como usuário(a)'));
                return $this->redirect(['controller' => 'Users', 'action' => 'add', '?' => ['cress' => $cress]]);
            endif;

            $supervisorresultado = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisorresultado)) {
                $this->Flash->success(__('Registro supervisor inserido.'));

                /**
                 * Verifico se está preenchido o campo supervisor_id na tabela Users.
                 * Primeiro busco o usuário.
                 */
                $usersupervisor = $this->fetchTable('Users')->find()
                    ->where(['supervisor_id' => $supervisorresultado->id])
                    ->first();

                /**
                 * Se a busca retorna vazia então atualizo a tabela Users com o valor do supervisor_id.
                 */
                if (empty($usersupervisor)) {

                    $userestagio = $this->fetchTable('Users')->find()
                        ->where(['categoria_id' => 4, 'registro' => $supervisorresultado->cress])
                        ->first();
                    $userdata = $userestagio->toArray();
                    /** Carrego o valor do campo supervisor_id */
                    $userdata['supervisor_id'] = $supervisorresultado->id;

                    $userestagiostabela = $this->fetchTable('Users');
                    $user_entity = $userestagiostabela->get($userestagio->id);
                    /** Atualiza */
                    $userestagioresultado = $this->Supervisores->Users->patchEntity($user_entity, $userdata);

                    if ($this->Supervisores->Users->save($userestagioresultado)) {
                        $this->Flash->success(__('Usuário atualizado com o id do supervisor'));
                        return $this->redirect(['action' => 'view', $supervisorresultado->id]);
                    } else {
                        $this->Flash->erro(__('Não foi possível atualizar a tabela Users com o id do supervisor'));
                        // debug($users->getErrors());
                        return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
                    }
                }
                return $this->redirect(['action' => 'view', $supervisorresultado->id]);
            }
            $this->Flash->error(__('Registro supervisor não foi inserido. Tente novamente.'));
            return $this->redirect(['action' => 'add', '?' => ['cress' => $cress, 'email' => $email]]);
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list');
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        /** Autorização */
        // Admin or supervisor can access this page
        if (!$this->user->isAdmin() || $this->user->isSupervisor()) {
            if ($this->user->isSupervisor()) {
                $supervisor = $this->Supervisores->get($id);
                if ($this->user->id != $supervisor->user_id) {
                    $this->Flash->error(__('Usuario nao autorizado.'));
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
            }
        }

        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Instituicoes'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('Registro supervisor(a) atualizado.'));

                return $this->redirect(['action' => 'view', $supervisor->id]);
            }
            $this->Flash->error(__('Registro supervisor(a) nao atualizado. Tente novamente.'));
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list', ['limit' => 200]);
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        /** Autorização */
        // Admin or supervisor can access this page
        if (!$this->user->isAdmin()) {
            $this->Flash->error(__('Usuario nao autorizado.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);
        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Estagiarios']
        ]);
        if (sizeof($supervisor->estagiarios) > 0) {
            $this->Flash->error(__('Supervisor(a) com estagiarios'));
            return $this->redirect(['controller' => 'supervisores', 'action' => 'view', $id]);
        }
        if ($this->Supervisores->delete($supervisor)) {
            $this->Flash->success(__('The supervisor has been deleted.'));
        } else {
            $this->Flash->error(__('The supervisor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
