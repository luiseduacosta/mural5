<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Professores Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Professores
 * @method \App\Model\Entity\Professor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfessoresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Professores);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $professores = $this->paginate($this->Professores);

        $this->set(compact('professores'));
    }

    /**
     * View method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
        $user_session = $this->request->getAttribute('identity');
        if ($user_session) {
            $user_data = $user_session->getOriginalData();
        }

        if ($id === null) {
            $id = $user_data['professor_id'] ?? null;
        }
        /** Têm professores com muitos estagiários: aumentar a memória */
        ini_set('memory_limit', '2048M');

        try {
            $professor = $this->Professores->get($id, contain: ['Estagiarios' => ['sort' => ['Estagiarios.periodo DESC'], 'Alunos', 'Instituicoes', 'Supervisores', 'Professores']]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros para este(a) professor(a)!'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($professor);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->set(compact('professor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $professor = $this->Professores->newEmptyEntity();

        try {
            $this->Authorization->authorize($professor);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $nome = null;
        $siape = null;
        $email = null;
        $identity = $this->getRequest()->getAttribute('identity');
        if ($identity && $identity['categoria'] === '3') {
            $nome = $identity['nome'];
            $siape = $identity['identificacao'];
            $email = $identity['email'];
            $professor->nome = $nome;
            $professor->siape = $siape;
            $professor->email = $email;
        } else {
            $email = $this->request->getQuery('email');
            $siape = $this->request->getQuery('siape');
        }

        /* Verifico se já está cadastrado */
        if ($siape) {
            $professorcadastrado = $this->Professores->find()
                    ->where(['siape' => $siape])
                    ->first();

            if ($professorcadastrado) :
                $this->Flash->error(__('Professor já cadastrado'));

                return $this->redirect(['view' => $professorcadastrado->id]);
            endif;
        }

        if ($this->request->is('post')) {
            /** Busca se já está cadastrado como user */
            $siape = $this->request->getData('siape');
            $usercadastrado = $this->Professores->Users->find()
                    ->where(['categoria' => '3', 'identificacao' => $siape])
                    ->first();
            if (empty($usercadastrado)) :
                $this->Flash->error(__('Professor(a) não cadastrado(a) como usuário(a)'));

                return $this->redirect('/users/add');
            endif;

            $professorresultado = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professorresultado)) {
                $this->Flash->success(__('Registro do(a) professor(a) inserido.'));

                // Update the user record with professor_id and entidade_id
                $userEntity = $this->fetchTable('Users')->get($usercadastrado->id);
                $userEntity->professor_id = $professorresultado->id;
                $userEntity->entidade_id = $professorresultado->id;
                $userEntity->identificacao = $professorresultado->siape;
                $userEntity->role = 'professor';
                if ($this->fetchTable('Users')->save($userEntity)) {
                    $refreshUser = $this->Users->get($userEntity->id);
                    $this->Authentication->setIdentity($refreshUser);
                    $this->Flash->success(__('Usuário atualizado com o id do professor'));

                    // Update the professores table with professor_id
                    $this->Professores->patchEntity($professorresultado, ['user_id' => $userEntity->id]);
                    $this->Professores->save($professorresultado);
                    return $this->redirect(['action' => 'view', $professorresultado->id]);
                }

                $this->Flash->error(__('Não foi possível atualizar a tabela Users com o id do professor'));

                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            }
            $this->Flash->error(__('Registro do(a) professor(a) não inserido. Tente novamente.'));

            return $this->redirect(['action' => 'add', '?' => ['siape' => $siape, 'email' => $email]]);
        }
        $this->set(compact('professor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
        $user_session = $this->request->getAttribute('identity');
        if ($user_session) {
            $user_data = $user_session->getOriginalData();
        }

        try {
            $professor = $this->Professores->get($id, contain: []);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Professor não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($professor);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('Registro do(a) professor(a) atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) no foi atualizado. Tente novamente.'));
        }
        $this->set(compact('professor', 'user_data'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);

        try {
            $professor = $this->Professores->get($id, contain: ['Estagiarios']);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Professor não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($professor);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if (sizeof($professor->estagiarios) > 0) {
            $this->Flash->error(__('Professor(a) tem estagiários associados'));
            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $id]);
        }
        if ($this->Professores->delete($professor)) {
            $this->Flash->success(__('Registro professor(a) excluído.'));
        } else {
            $this->Flash->error(__('Registro professor(a) não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
