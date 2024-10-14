<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\Userestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {
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
    public function index() {
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
    public function view($id = null) {

        $userestagio = $this->Users->get($id, [
            'contain' => ['Alunos', 'Supervisores', 'Professores'],
        ]);

        if (!isset($userestagio)) {
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
    public function add() {

        $userestagio = $this->Users->newEmptyEntity();
        // pr($this->request->getData());
        // die();
        if ($this->request->is('post')) {

            if ($this->request->getData('categoria_id') == 2):

                $dados = $this->request->getData();

                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                        ->where(['email' => $this->request->getData('email'), 'registro' => $this->request->getData('registro')])
                        ->first();

                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Users->delete($usercadastrado->id);
                endif;

                /* Verifico se está cadatrado como aluno */
                $estudantetabela = $this->fetchTable('Alunos');
                $estudantecadastrado = $estudantetabela->find()
                        ->where(['registro' => $this->request->getData('registro')])
                        ->first();
                // pr($estudantecadastrado);
                // die();
                /* Se está já cadastrado como aluno então capturo o id e aplico no usuer no campo aluno_id */
                if ($estudantecadastrado) {
                    $dados['aluno_id'] = $estudantecadastrado->id;
                    $userresultado = $this->Users->patchEntity($userestagio, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Usuário aluno inserido.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('registro', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Mostro o aluno */
                        return $this->redirect(['controller' => 'alunos', 'action' => 'view', $estudantecadastrado->id]);
                    }
                } else {
                    $userresultado = $this->Users->patchEntity($userestagio, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Usuário inserido.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('registro', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Cadastro o aluno. No cadastramento do aluno tem que prever atualizar o campo aluno_id da tabela users.  */
                        return $this->redirect(['controller' => 'alunos', 'action' => 'add', '?' => ['registro' => $this->request->getData('registro'), 'email' => $this->request->getData('email')]]);
                    }
                }
                $this->Flash->error(__('O usuário de estagio não foi cadastrado. Tente novamente.'));
                return $this->redirect(['action' => 'login']);
            endif;

            if ($this->request->getData('categoria_id') == 3):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                        ->where(['email' => $this->request->getData('email')])
                        ->first();
                // pr($usercadastrado);
                // die();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Users->delete($usercadastrado->id);
                endif;

                /* Verifico se está cadatrado como professor */
                $professortabela = $this->fetchTable('Professores');
                $professorcadastrado = $professortabela->find()
                        ->where(['siape' => $this->request->getData('registro')])
                        ->first();
                // pr($professorcadastrado);
                // die();
                if ($professorcadastrado) {
                    $dados['professor_id'] = $professorcadastrado->id;
                    // pr($dados);
                    // die();
                    $userresultado = $this->Users->patchEntity($userestagio, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Professor cadastrado.'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('siape', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Professores */
                        return $this->redirect(['controller' => 'professores', 'action' => 'view', $dados['professor_id']]);
                    }
                } else {
                    $userresultado = $this->Users->patchEntity($userestagio, $dados);
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

            if ($this->request->getData('categoria_id') == 4):

                $dados = $this->request->getData();
                /* Verifico se já está cadastrado */
                $usercadastrado = $this->Users->find()
                        ->where(['email' => $this->request->getData('email'), 'registro' => $this->request->getData('registro')])
                        ->first();
                // pr($usercadastrado);
                // die();
                /* Se está cadastrado excluo para refazer a senha */
                if ($usercadastrado):
                    $this->Users->delete($usercadastrado->id);
                endif;

                /* Verifico se está cadatrado como supervisor */
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisorcadastrado = $supervisorestabela->find()
                        ->where(['cress' => $this->request->getData('registro')])
                        ->first();
                // pr($supervisorcadastrado);
                // die();
                if ($supervisorcadastrado) {
                    $dados['supervisor_id'] = $supervisorcadastrado->id;
                    // pr($dados);
                    // die();
                    $userresultado = $this->Users->patchEntity($userestagio, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Supervisor(a) cadastrado(a).'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('cress', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Professores */
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'view', $dados['supervisor_id']]);
                    }
                } else {
                    $userresultado = $this->Users->patchEntity($userestagio, $dados);
                    if ($this->Users->save($userresultado)) {
                        $this->Flash->success(__('Supervisora(o) cadastrada(o).'));

                        $this->getRequest()->getSession()->write('categoria', $this->request->getData('categoria_id'));
                        $this->getRequest()->getSession()->write('cress', $this->request->getData('registro'));
                        $this->getRequest()->getSession()->write('usuario', $this->request->getData('email'));

                        /* Precisa de autorização na ação add do controller Alunos */
                        return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['registro' => $this->request->getData('registro'), 'email' => $this->request->getData('email')]]);
                    }
                }
                $this->Flash->error(__('Supervisores são cadastrados diretamente junto com a Coordenação de Estágio'));
                return $this->redirect('/muralestagios/index');
            endif;
        }
        $alunos = $this->Users->Alunos->find('list');
        $supervisores = $this->Users->Supervisores->find('list');
        $professores = $this->Users->Professores->find('list');
        $this->set(compact('userestagio', 'alunos', 'supervisores', 'professores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
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
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $userestagio = $this->Users->get($id);
        if ($this->Users->delete($userestagio)) {
            $this->Flash->success(__('Usuário excluído.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Não foi possível excluir o usuário.'));
            return $this->redirect(['action' => 'view', $id]);
        }
        // return $this->redirect(['action' => 'login']);
    }

    public function login() {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            switch ($this->Authentication->getIdentityData('categoria_id')):
                case 1:
                    echo "Administrador";
                    $this->Flash->success(__('Bem-vindo administrador!'));
                    $this->getRequest()->getSession()->write('categoria', $this->Authentication->getIdentityData('categoria_id'));
                    return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
                    break;
                case 2:
                    echo "Aluno";
                    $this->Flash->success(__('Bem-vindo(a) aluno!'));
                    $this->getRequest()->getSession()->write('categoria', $this->Authentication->getIdentityData('categoria_id'));
                    $this->getRequest()->getSession()->write('registro', $this->Authentication->getIdentityData('registro'));
                    $this->getRequest()->getSession()->write('usuario', $this->Authentication->getIdentityData('email'));

                    /** Se o campo aluno_id esta vazio então tem que preencher com o valor do id da tabela alunos */
                    if (empty($this->Authentication->getIdentityData('aluno_id'))):
                        /** Busca se o estaduante está cadastrado na tabela alunos */
                        $estudantestabela = $this->fetchTable('Alunos');
                        $estudantecadastrado = $estudantestabela->find()
                                ->where(['registro' => $this->Authentication->getIdentityData('registro')])
                                ->select(['id'])
                                ->first();

                        /** Se o aluno está cadastrado atualizo. Caso contrário vai para adicionar o aluno. */
                        if ($estudantecadastrado) {
                            /** Atualizo o aluno_id */
                            $users = $this->Users->get($this->Authentication->getIdentityData('id'));
                            $userestagiodata = $users->toArray();
                            $userestagiodata['aluno_id'] = $estudantecadastrado->id;
                            $userestagioresultado = $this->Users->patchEntity($users, $userestagiodata);
                            if ($this->Users->save($userestagioresultado)) {
                                /** Para debug */
                                //return $this->redirect(['controller' => 'Users', 'action' => 'view', $userestagioresultado->id]);
                                return $this->redirect(['controller' => 'muralestagios', 'action' => 'index']);
                            } else {
                                // debug($userestagioresultado);
                            }
                        } else {
                            return $this->redirect(['controller' => 'alunos', 'action' => 'add', '?' => ['registro' => $this->Authentication->getIdentityData('registro'), 'email' => $this->Authentication->getIdentityData('email')]]);
                        }
                    /** Busco se o aluno está efetivamente cadastrado */
                    else:
                        $estudantetabela = $this->fetchTable('Alunos');
                        $aluno = $estudantetabela->find()->where(['id' => $this->Authentication->getIdentityData('aluno_id')])->first();
                        if (isset($aluno)) {
                            echo 'Aluno cadastrado' . '<br>';
                        } else {
                            return $this->redirect(['controller' => 'alunos', 'action' => 'add', '?' => ['registro' => $this->Authentication->getIdentityData('registro'), 'email' => $this->Authentication->getIdentityData('email')]]);
                        }
                    endif;
                    /** Verifico se o aluno é estagiário e guardo no cookie. Serve para o menu superior selecionar o menu_estagiario. */
                    $estagiariotabela = $this->fetchTable('Estagiarios');
                    $estagiario = $estagiariotabela->find()->where(['registro' => $this->Authentication->getIdentityData('registro')])->first();
                    if ($estagiario) {
                        $this->getRequest()->getSession()->write('estagiario_id', $estagiario->id);
                    } else {
                        $this->getRequest()->getSession()->delete('estagiario_id');
                    }
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                    break;
                case 3:
                    echo "Professor";
                    $this->Flash->success(__('Bem-vindo(a) professor(a)!'));
                    $this->getRequest()->getSession()->write('categoria', $this->Authentication->getIdentityData('categoria_id'));
                    $this->getRequest()->getSession()->write('siape', $this->Authentication->getIdentityData('registro'));
                    $this->getRequest()->getSession()->write('usuario', $this->Authentication->getIdentityData('email'));

                    /** Verifica se o campo professor_id está preenchido com o valor do id do professor. */
                    if (empty($this->Authentication->getIdentityData('professor_id'))):
                        /** Busca se o professor está cadastrado na tabela professores */
                        $professortabela = $this->fetchTable('Professores');
                        $professorcadastrado = $professortabela->find()->where(['siape' => $this->Authentication->getIdentityData('registro')])
                                ->select(['id'])
                                ->first();
                        if ($professorcadastrado) {
                            $users = $this->Users->get($this->Authentication->getIdentityData('id'));
                            $userestagiodata = $users->toArray();
                            $userestagiodata['professor_id'] = $professorcadastrado->id;
                            $users = $this->Users->patchEntity($users, $userestagiodata);
                            if ($this->Users->save($users)) {
                                // $this->Flash->success(__('Usuário atualizado!'));
                                return $this->redirect('/muralestagios/index');
                            }
                        } else {
                            return $this->redirect(['controller' => 'professores', 'action' => 'add', '?' => ['siape' => $this->Authentication->getIdentityData('registro'), 'email' => $this->Authentication->getIdentityData('email')]]);
                        }
                        $this->Flash->success(__('Bem-vinda(o) professora(o)!'));
                        return $this->redirect('/muralestagios/index');
                    /** Busco se o professor está efetivamente cadastrado */
                    else:
                        // die('professor_id2');
                        $professortabela = $this->fetchTable('Professores');
                        $professor = $professortabela->find()->where(['id' => $this->Authentication->getIdentityData('professor_id')])->first();
                        if (isset($professor)) {
                            echo 'Professor cadastrado' . '<br>';
                        } else {
                            return $this->redirect(['controller' => 'professores', 'action' => 'add', '?' => ['siape' => $this->Authentication->getIdentityData('registro'), 'email' => $this->Authentication->getIdentityData('email')]]);
                        }
                    endif;
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                    break;
                case 4:
                    echo "Supervisor";
                    $this->Flash->success(__('Bem-vindo(a) supervisor(a)!'));
                    $this->getRequest()->getSession()->write('categoria', $this->Authentication->getIdentityData('categoria_id'));
                    $this->getRequest()->getSession()->write('cress', $this->Authentication->getIdentityData('registro'));
                    $this->getRequest()->getSession()->write('usuario', $this->Authentication->getIdentityData('email'));

                    /** Verifica se o campo supervisor_id está preenchido com o valor do id do supervisor. */
                    if (empty($this->Authentication->getIdentityData('supervisor_id'))):
                        /** Busca se o professor está cadastrado na tabela professores */
                        $supervisortabela = $this->fetchTable('Supervisores');
                        $supervisorcadastrado = $supervisortabela->find()->where(['cress' => $this->Authentication->getIdentityData('registro')])
                                ->select(['id'])
                                ->first();
                        if ($supervisorcadastrado) {
                            $users = $this->Users->get($this->Authentication->getIdentityData('id'));
                            $userestagiodata = $users->toArray();
                            $userestagiodata['supervisor_id'] = $supervisorcadastrado->id;
                            $users = $this->Users->patchEntity($users, $userestagiodata);
                            if ($this->Users->save($users)) {
                                // $this->Flash->success(__('Usuário atualizado!'));
                                return $this->redirect('/muralestagios/index');
                            }
                        } else {
                            // echo "Supervisor não cadastrado";
                            return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['cress' => $this->Authentication->getIdentityData('registro'), 'email' => $this->Authentication->getIdentityData('email')]]);
                        }
                    /** Busco se o supervisor está efetivamente cadastrado */
                    else:
                        $supervisortabela = $this->fetchTable('Supervisores');
                        $supervisor = $supervisortabela->find()->where(['id' => $this->Authentication->getIdentityData('supervisor_id')])->first();
                        if (isset($supervisor)) {
                            echo 'Supervisor cadastrado' . '<br>';
                        } else {
                            return $this->redirect(['controller' => 'supervisores', 'action' => 'add', '?' => ['cress' => $this->Authentication->getIdentityData('registro'), 'email' => $this->Authentication->getIdentityData('email')]]);
                        }
                    endif;
                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                    break;
                default:
                    echo "Sem categorizar";
                    $this->Flash->error(__('Usuário não categorizado em nenhum segmento'));
                    return $this->redirect('/users/logout');
            endswitch;
            // return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Usuário e/ou senha errado'));
        }
    }

    public function logout() {
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

    /*
     * Preenche os ids da tabela users com os valores correspondentes
     *
     */

    public function preencher() {

        $user = $this->Users->find('all');
        foreach ($user as $c_user) {
            // pr($c_user->categoria_id);
            if ($c_user->categoria_id == 2) {
                // pr($c_user->registro);
                $professorestabela = $this->fetchTable('Alunos');
                $aluno = $professorestabela->find()
                        ->contain([])
                        ->where(['alunos.registro' => $c_user->registro])
                        ->first();
                // pr($aluno);
                // pr($aluno->first()->registro);
                $c_user->aluno_id = $aluno->id;
                // pr($c_user->aluno_id);
                // pr($c_user->id);
                if ($this->Users->save($c_user)) {
                    // echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('Usuario de estagio atualizado.'));
                } else {
                    // echo "Erro!" . "<br>";
                    $this->Flash->error(__('Erro na atualizacao. Tente novamente.'));
                }
                ;
                // die();
            }
            // die('Alunos');
            // Professores
            if ($c_user->categoria_id == 3) {
                // pr($c_user->registro);
                // die();
                $professorestabela = $this->fetchTable('Professores');
                $professor = $professorestabela->find()
                        ->contain([])
                        ->where(['professores.siape' => $c_user->registro])
                        ->first();
                // pr($professor);
                // pr($professor->first()->siape);
                $c_user->professor_id = $professor->id;
                // pr($c_user->professor_id);
                // pr($c_user->id);
                // die();
                if ($this->Users->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                }
                ;
                // die('if professores');
            }
            // die('Professores');
            // Supervisores
            if ($c_user->categoria_id == 4) {
                // pr($c_user->registro);
                // die();
                $supervisorestabela = $this->fetchTable('Supervisores');
                $supervisor = $supervisorestabela->find()
                        ->contain([])
                        ->where(['supervisores.cress' => $c_user->registro])
                        ->first();
                // pr($professor);
                // pr($professor->first()->siape);
                $c_user->supervisor_id = $supervisor->id;
                // pr($c_user->professor_id);
                // pr($c_user->id);
                // die();
                if ($this->Users->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                }
                ;
                // die('if professores');
            }
            // die('Professores');
        }
        // pr($user);
        die();
    }
}
