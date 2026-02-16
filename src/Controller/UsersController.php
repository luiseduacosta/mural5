<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find('all')->contain(['Alunos', 'Supervisores', 'Professores']);
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($id == null) {
            $this->Flash->error(__('Sem parâmetros para localizar o usuário!'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $userestagio = $this->Users->get($id, [
                'contain' => ['Alunos', 'Supervisores', 'Professores'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de usuario para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('userestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {

            /** Aluno */
            if ($this->request->getData('categoria_id') == 2):

                $dados = $this->request->getData();

                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                    ->where(['email' => $this->request->getData('email'), 'registro' => $this->request->getData('registro')])
                    ->first();

                /* Se está cadastrado excluo para refazer nova senha */
                if ($usercadastrado):
                    try {
                        $this->Users->delete($usercadastrado);
                    } catch (\Exception $e) {
                        $this->Flash->error(__('Erro ao excluir usuário existente. Tente novamente.'));
                        return $this->redirect(['action' => 'add']);
                    }
                endif;

                /* Verifico se está cadatrado na tabela alunos */
                $estudantetabela = $this->fetchTable('Alunos');
                $estudantecadastrado = $estudantetabela->find()
                    ->where(['registro' => $this->request->getData('registro')])
                    ->first();

                /* Se está já cadastrado como aluno então capturo o id e aplico no usuer no campo aluno_id */
                if ($estudantecadastrado) {
                    $dados['aluno_id'] = $estudantecadastrado->id;
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Usuário aluno inserido.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('registro', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Mostro o aluno */
                        return $this->redirect(['controller' => 'alunos', 'action' => 'view', $estudantecadastrado->id]);
                    }
                } else {
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Usuário inserido.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('registro', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Cadastro o aluno. No cadastramento do aluno tem que prever atualizar o campo aluno_id da tabela users.  */
                        return $this->redirect(['controller' => 'alunos', 'action' => 'add', '?' => ['registro' => $this->request->getData('registro'), 'email' => $this->request->getData('email')]]);
                    }
                }
                $this->Flash->error(__('O usuário não foi cadastrado. Tente novamente.'));
                return $this->redirect(['action' => 'login']);
            endif;

            /** Professor */
            if ($this->request->getData('categoria_id') == 3):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                    ->where(['email' => $this->request->getData('email')])
                    ->first();

                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    try {
                        $this->Users->delete($usercadastrado);
                    } catch (\Exception $e) {
                        $this->Flash->error(__('Erro ao excluir usuário existente. Tente novamente.'));
                        return $this->redirect(['action' => 'add']);
                    }
                endif;

                /* Verifico se está cadatrado como professor */
                $professortabela = $this->fetchTable('Professores');
                $professorcadastrado = $professortabela->find()
                    ->where(['siape' => $this->request->getData('registro')])
                    ->first();

                if ($professorcadastrado) {
                    $dados['professor_id'] = $professorcadastrado->id;
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Professor cadastrado.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('siape', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Professores */
                        return $this->redirect(['controller' => 'professores', 'action' => 'view', $dados['professor_id']]);
                    }
                } else {
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Professora(o) cadastrada(o).'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('siape', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Alunos */
                        return $this->redirect(['controller' => 'professores', 'action' => 'add', '?' => ['registro' => $this->request->getData('registro'), 'email' => $this->request->getData('email')]]);
                    }
                }
                $this->Flash->error(__('Professores são cadastrados diretamente junto com a Coordenação de Estágio'));
                return $this->redirect('/muralestagios/index');
            endif;

            /** Supervisor */
            if ($this->request->getData('categoria_id') == 4):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                    ->where(['email' => $this->request->getData('email'), 'registro' => $this->request->getData('registro')])
                    ->first();

                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    try {
                        $this->Users->delete($usercadastrado);
                    } catch (\Exception $e) {
                        $this->Flash->error(__('Erro ao excluir usuário existente. Tente novamente.'));
                        return $this->redirect(['action' => 'add']);
                    }
                endif;

                /* Verifico se está cadatrado como supervisor */
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisorcadastrado = $supervisorestabela->find()
                    ->where(['cress' => $this->request->getData('registro')])
                    ->first();

                if ($supervisorcadastrado) {
                    $dados['supervisor_id'] = $supervisorcadastrado->id;
                    // pr($dados);
                    // die();
                    $userresultado = $this->Users->patchEntity($user, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Supervisor(a) cadastrado(a).'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('cress', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Professores */
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'view', $dados['supervisor_id']]);
                    }
                } else {
                    /** Supervisor não cadastrado. A coordenação de estágio tem que cadastrar os supervisores por motivos de segurança. */
                    $this->Flash->error(__('Supervisores são cadastrados diretamente junto com a Coordenação de Estágio'));
                    return $this->redirect('/muralestagios/index');
                }
            endif;
        }
        $alunos = $this->Users->Alunos->find('list');
        $supervisores = $this->Users->Supervisores->find('list');
        $professores = $this->Users->Professores->find('list');
        $this->set(compact('user', 'alunos', 'supervisores', 'professores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userestagio = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userestagioresultado = $this->Users->patchEntity($userestagio, $this->request->getData());
            if ($this->Users->save($userestagioresultado)) {
                $this->Flash->success(__('User atualizado.'));

                return $this->redirect(['action' => 'view', $userestagioresultado->id]);
            }
            $this->Flash->error(__('Userestagio não foi atualizado. Tente novamente.'));
        }
        $alunos = $this->Users->Alunos->find('list');
        $supervisores = $this->Users->Supervisores->find('list');
        $professores = $this->Users->Professores->find('list');
        $this->set(compact('userestagio', 'alunos', 'supervisores', 'professores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userestagio = $this->Users->get($id);
        if ($this->Users->delete($userestagio)) {
            $this->Flash->success(__('Usuário excluído.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Não foi possível excluir o usuário.'));
            return $this->redirect(['action' => 'view', $id]);
        }
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful login
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->user = $this->Authentication->getIdentity()->getOriginalData();
            if ($this->user->isAdmin()):
                $this->Flash->success(__('Bem-vindo administrador!'));
                $this->getRequest()->getSession()->write('categoria', $this->user->categoria_id);
                return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
            elseif ($this->user->isStudent()):
                $this->Flash->success(__('Bem-vindo(a) aluno(a) ' . $this->user->nome . '!'));
                $this->getRequest()->getSession()->write('categoria', $this->user->categoria_id);
                $this->getRequest()->getSession()->write('registro', $this->user->registro);
                $this->getRequest()->getSession()->write('usuario', $this->user->email);

                /** Se o campo aluno_id esta vazio então tem que preencher com o valor do id da tabela alunos */
                if (empty($this->user->aluno_id)):
                    /** Busca se o estaduante está cadastrado na tabela alunos */
                    $estudantestabela = $this->fetchTable('Alunos');
                    $estudantecadastrado = $estudantestabela->find()
                        ->where(['registro' => $this->user->registro])
                        ->select(['id'])
                        ->first();

                    /** Se o aluno está cadastrado atualizo. Caso contrário vai para adicionar o aluno. */
                    if ($estudantecadastrado) {
                        /** Atualizo o aluno_id */
                        $userEntity = $this->Users->get($this->user->id);
                        $userEntity->aluno_id = $estudantecadastrado->id;
                        if ($this->Users->save($userEntity)) {
                            return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
                        }
                    } else {
                        return $this->redirect(['controller' => 'alunos', 'action' => 'add', '?' => ['registro' => $this->user->registro, 'email' => $this->user->email]]);
                    }
                else:
                    $estudantetabela = $this->fetchTable('Alunos');
                    $aluno = $estudantetabela->find()->where(['id' => $this->user->aluno_id])->first();
                    if (!$aluno) {
                        return $this->redirect(['controller' => 'alunos', 'action' => 'add', '?' => ['registro' => $this->user->registro, 'email' => $this->user->email]]);
                    }
                endif;
                /** Verifico se o aluno é estagiário e guardo no cookie. Serve para o menu superior selecionar o menu_estagiario. */
                $estagiariotabela = $this->fetchTable('Estagiarios');
                $estagiario = $estagiariotabela->find()
                    ->where(['aluno_id' => $this->user->aluno_id])
                    ->orderDesc('nivel')
                    ->first();
                if ($estagiario) {
                    $this->getRequest()->getSession()->write('estagiario_id', $estagiario->id);
                } else {
                    $this->getRequest()->getSession()->delete('estagiario_id');
                }
                return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            elseif ($this->user->isProfessor()):
                $this->Flash->success(__('Bem-vindo(a) professor(a)!'));

                $this->getRequest()->getSession()->write('categoria', $this->user->categoria_id);
                $this->getRequest()->getSession()->write('siape', $this->user->registro);
                $this->getRequest()->getSession()->write('usuario', $this->user->email);

                /** Verifica se o campo professor_id está preenchido com o valor do id do professor. */
                if (empty($this->user->professor_id)):
                    /** Busca se o professor está cadastrado na tabela professores */
                    $professortabela = $this->fetchTable('Professores');
                    $professorcadastrado = $professortabela->find()->where(['siape' => $this->user->registro])
                        ->select(['id'])
                        ->first();
                    if ($professorcadastrado) {
                        $userEntity = $this->Users->get($this->user->id);
                        $userEntity->professor_id = $professorcadastrado->id;
                        if ($this->Users->save($userEntity)) {
                            return $this->redirect('/muralestagios/index');
                        }
                    } else {
                        return $this->redirect(['controller' => 'professores', 'action' => 'add', '?' => ['siape' => $this->user->registro, 'email' => $this->user->email]]);
                    }
                else:
                    $professortabela = $this->fetchTable('Professores');
                    $professor = $professortabela->find()->where(['id' => $this->user->professor_id])->first();
                    if (!$professor) {
                        return $this->redirect(['controller' => 'professores', 'action' => 'add', '?' => ['siape' => $this->user->registro, 'email' => $this->user->email]]);
                    }
                endif;
                return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            elseif ($this->user->isSupervisor()):
                $this->Flash->success(__('Bem-vindo(a) supervisor(a)!'));

                $this->getRequest()->getSession()->write('categoria', $this->user->categoria_id);
                $this->getRequest()->getSession()->write('cress', $this->user->registro);
                $this->getRequest()->getSession()->write('usuario', $this->user->email);

                /** Verifica se o campo supervisor_id está preenchido com o valor do id do supervisor. */
                if (empty($this->user->supervisor_id)):
                    /** Busca se o professor está cadastrado na tabela professores */
                    $supervisortabela = $this->fetchTable('Supervisores');
                    $supervisorcadastrado = $supervisortabela->find()->where(['cress' => $this->user->registro])
                        ->select(['id'])
                        ->first();
                    if ($supervisorcadastrado) {
                        $userEntity = $this->Users->get($this->user->id);
                        $userEntity->supervisor_id = $supervisorcadastrado->id;
                        if ($this->Users->save($userEntity)) {
                            return $this->redirect('/muralestagios/index');
                        }
                    } else {
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['cress' => $this->user->registro, 'email' => $this->user->email]]);
                    }
                else:
                    $supervisortabela = $this->fetchTable('Supervisores');
                    $supervisor = $supervisortabela->find()->where(['id' => $this->user->supervisor_id])->first();
                    if (!$supervisor) {
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['cress' => $this->user->registro, 'email' => $this->user->email]]);
                    }
                endif;
                return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            else:
                $this->Flash->error(__('Usuário não categorizado em nenhum segmento'));
                return $this->redirect(['controller' => 'users', 'action' => 'logout']);
            endif;
            // return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Usuário e/ou senha errado'));
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful logout
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {

            $this->getRequest()->getSession()->delete('categoria');
            $this->getRequest()->getSession()->delete('registro');
            $this->getRequest()->getSession()->delete('siape');
            $this->getRequest()->getSession()->delete('cress');
            $this->getRequest()->getSession()->delete('usuario');
            $this->getRequest()->getSession()->delete('estagiario_id');

            $this->Authentication->logout();

            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }
    }

    /**
     * Preenche os ids da tabela users com os valores correspondentes
     *
     * @return \Cake\Http\Response|null|void Redirects on successful preenchimento
     */
    public function preencher()
    {

        if (!$this->isAdmin()) {
            $this->Flash->error(__('User not authorized.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }

        $users = $this->Users->find('all');
        foreach ($users as $user) {
            if ($user->categoria_id == 2) {
                $alunostabela = $this->fetchTable('Alunos');
                $aluno = $alunostabela->find()
                    ->contain([])
                    ->where(['Alunos.registro' => $user->registro])
                    ->first();
                if ($aluno) {
                    $user->aluno_id = $aluno->id;
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Student user updated successfully.'));
                    } else {
                        $this->Flash->error(__('Error updating student user. Please try again.'));
                    }
                } else {
                    $this->Flash->warning(__('Student not found for registration: ' . $user->registro));
                }
            }
            // die('Alunos');
            // Professores
            if ($user->categoria_id == 3) {
                $professorestabela = $this->fetchTable('Professores');
                $professor = $professorestabela->find()
                    ->contain([])
                    ->where(['Professores.siape' => $user->registro])
                    ->first();
                if ($professor) {
                    $user->professor_id = $professor->id;
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Professor user updated successfully.'));
                    } else {
                        $this->Flash->error(__('Error updating professor user. Please try again.'));
                    }
                } else {
                    $this->Flash->warning(__('Professor not found for SIAPE: ' . $user->registro));
                }
            }
            // die('Professores');
            // Supervisores
            if ($user->categoria_id == 4) {
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisor = $supervisorestabela->find()
                    ->contain([])
                    ->where(['Supervisores.cress' => $user->registro])
                    ->first();
                if ($supervisor) {
                    $user->supervisor_id = $supervisor->id;
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Supervisor user updated.'));
                    } else {
                        $this->Flash->error(__('Error updating supervisor user. Please try again.'));
                    }
                } else {
                    $this->Flash->warning(__('Supervisor not found for CRESS: ' . $user->registro));
                }
            }
        }
        
        $this->Flash->success(__('Processo de preenchimento concluído.'));
        return $this->redirect(['action' => 'index']);
    }
}
