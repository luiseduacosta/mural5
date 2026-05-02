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
        $this->Authorization->authorize($this->Supervisores);

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

        if ($this->getRequest()->getAttribute('identity')['categoria'] == 4) {
            $id = $this->getRequest()->getAttribute('identity')['supervisor_id'];
        }
        if (empty($id)) {
            $this->Flash->error(__('Nõo há registros de supervisor para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }
        $supervisor = $this->Supervisores->get($id, [
            'contain' => [
                'Instituicoes' => ['sort' => ['Instituicoes.instituicao ASC']],
                'Estagiarios' => ['sort' => ['Estagiarios.periodo DESC'], 'Alunos' => ['sort' => ['Alunos.nome ASC']], 'Professores', 'Folhadeatividades', 'Avaliacoes']
            ]
        ]);

        $this->Authorization->authorize($supervisor);

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

        $supervisor = $this->Supervisores->newEmptyEntity();

        $this->Authorization->authorize($supervisor);

        $nome = null;
        $cress = null;
        $email = null;
        $identity = $this->getRequest()->getAttribute('identity');
        if ($identity && $identity['categoria'] == 4) {
            $nome = $identity['nome'];
            $cress = $identity['identificacao'];
            $email = $identity['email'];
            $supervisor->nome = $nome;
            $supervisor->cress = $cress;
            $supervisor->email = $email;
        } else {
            $email = $this->request->getQuery('email');
            $cress = $this->request->getQuery('cress');
        }

        /* Verifico se já está cadastrado */
        if ($cress) {
            $supervisorcadastrado = $this->Supervisores->find()
                ->where(['cress' => $cress])
                ->first();

            if ($supervisorcadastrado) :
                $this->Flash->error(__('Supervisor(a) já cadastrado(a)'));

                return $this->redirect(['view' => $supervisorcadastrado->id]);
            endif;
        }

        if ($this->request->is('post')) {
            /**
             * Verifico se já é um usuário cadastrado no users.
             */
            $cress = $this->request->getData('cress');
            $usercadastrado = $this->Supervisores->Users->find()
                ->where(['categoria' => '4', 'identificacao' => $cress])
                ->first();
            if (empty($usercadastrado)) :
                $this->Flash->error(__('Supervisor(a) não cadastrado(a) como usuário(a)'));

                return $this->redirect('/users/add');
            endif;

            $supervisorresultado = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisorresultado)) {
                $this->Flash->success(__('Registro supervisor inserido.'));

                // Update the user record with supervisor_id and entidade_id
                $userEntity = $this->fetchTable('Users')->get($usercadastrado->id);
                $userEntity->supervisor_id = $supervisorresultado->id;
                $userEntity->entidade_id = $supervisorresultado->id;
                $userEntity->identificacao = $supervisorresultado->cress;
                $userEntity->role = 'supervisor';
                if ($this->fetchTable('Users')->save($userEntity)) {
                    $refreshUser = $this->fetchTable('Users')->get($userEntity->id);
                    $this->Authentication->setIdentity($refreshUser);
                    $this->Flash->success(__('Usuário atualizado com o id do supervisor'));
                    // Update the user_id of the supervisores table
                    $this->Supervisores->patchEntity($supervisorresultado, ['user_id' => $userEntity->id]);
                    $this->Supervisores->save($supervisorresultado);

                    return $this->redirect(['action' => 'view', $supervisorresultado->id]);
                }

                $this->Flash->error(__('Não foi possível atualizar a tabela Users com o id do supervisor'));

                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
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
        if (is_null($id)) {
            $id = $this->getRequest()->getAttribute('identity')['supervisor_id'];
        }
        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Instituicoes'],
        ]);

        $this->Authorization->authorize($supervisor);

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
        if (is_null($id)) {
            $id = $this->getRequest()->getAttribute('identity')['supervisor_id'];
        }
        $this->request->allowMethod(['post', 'delete']);
        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Estagiarios']
        ]);

        $this->Authorization->authorize($supervisor);

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
